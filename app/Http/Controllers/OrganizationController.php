<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * First-run setup. On a brand-new install it also creates the first admin account;
     * otherwise only a signed-in admin may run it.
     */
    public function setup(Request $request): View|RedirectResponse
    {
        if (Organization::isSetUp()) {
            return redirect()->route('home');
        }

        if ($denied = $this->guardSetup($request)) {
            return $denied;
        }

        return view('setup.wizard', [
            'org' => Organization::current() ?? new Organization(),
            'createAdmin' => !User::query()->exists(),
        ]);
    }

    public function storeSetup(Request $request): RedirectResponse
    {
        if (Organization::isSetUp()) {
            return redirect()->route('home');
        }

        if ($denied = $this->guardSetup($request)) {
            return $denied;
        }

        $createAdmin = !User::query()->exists();
        $org = Organization::current() ?? new Organization();

        $rules = $this->rules(logoRequired: !$org->logo_path);
        if ($createAdmin) {
            $rules += [
                'admin_name'     => ['required', 'string', 'max:255'],
                'admin_email'    => ['required', 'email', 'max:255', 'unique:users,email'],
                'admin_phone'    => ['required', 'string', 'max:20'],
                'admin_password' => ['required', 'confirmed', Password::min(8)],
            ];
        }
        $data = $request->validate($rules, [], $this->attributeNames());

        DB::transaction(function () use ($request, $data, $org, $createAdmin) {
            $this->fill($org, $request, $data);
            $org->setup_completed_at = now();
            $org->save();

            if ($createAdmin) {
                $admin = User::create([
                    'fullName' => $data['admin_name'],
                    'email'    => $data['admin_email'],
                    'phone'    => $data['admin_phone'],
                    'address'  => $data['address'],
                    'password' => Hash::make($data['admin_password']),
                    'role'     => '1',
                    'status'   => '1',
                ]);
                Auth::login($admin);
                $request->session()->regenerate();
            }
        });

        Organization::forget();
        $this->log($request, 'Completed organization setup');

        return redirect()->route('dashboard')->with('success', 'Setup complete. Welcome to ' . $org->short_name . '!');
    }

    /**
     * Admin page for changing the details after setup.
     */
    public function edit(): View
    {
        return view('admin.organization', ['org' => Organization::current() ?? new Organization()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $org = Organization::current() ?? new Organization();
        $data = $request->validate($this->rules(logoRequired: !$org->logo_path), [], $this->attributeNames());

        $this->fill($org, $request, $data);
        $org->setup_completed_at ??= now();
        $org->save();

        Organization::forget();
        $this->log($request, 'Updated organization settings');

        return redirect()->route('organization.edit')->with('success', 'Organization details saved.');
    }

    private function guardSetup(Request $request): ?RedirectResponse
    {
        if (!User::query()->exists()) {
            return null;
        }
        if (!$request->user()) {
            return redirect()->route('login');
        }
        if ($request->user()->role != 1) {
            return redirect()->route('denied');
        }

        return null;
    }

    private function rules(bool $logoRequired): array
    {
        // No SVG: an uploaded SVG can carry script
        $image = ['image', 'mimes:png,jpg,jpeg,webp'];

        return [
            'name'              => ['required', 'string', 'max:255'],
            'short_name'        => ['required', 'string', 'max:40'],
            'tagline'           => ['nullable', 'string', 'max:255'],
            'rc_number'         => ['nullable', 'string', 'max:50'],
            'address'           => ['required', 'string', 'max:255'],
            'phone'             => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'max:255', function ($attr, $value, $fail) {
                foreach (preg_split('/[,;\s]+/', $value, -1, PREG_SPLIT_NO_EMPTY) as $email) {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $fail("\"$email\" is not a valid email address.");
                    }
                }
            }],
            'website'           => ['nullable', 'string', 'max:255'],
            'logo'              => [$logoRequired ? 'required' : 'nullable', ...$image, 'max:2048'],
            'letterhead'        => ['nullable', ...$image, 'max:4096'],
            'remove_letterhead' => ['nullable', 'boolean'],
        ];
    }

    private function attributeNames(): array
    {
        return [
            'name' => 'organization name', 'short_name' => 'short name', 'rc_number' => 'RC number',
            'admin_name' => 'full name', 'admin_email' => 'email', 'admin_phone' => 'phone number',
            'admin_password' => 'password',
        ];
    }

    private function fill(Organization $org, Request $request, array $data): void
    {
        $org->fill(collect($data)->only([
            'name', 'short_name', 'tagline', 'rc_number', 'address', 'phone', 'email', 'website',
        ])->all());

        if ($request->hasFile('logo')) {
            $org->logo_path = $this->store($request->file('logo'), 'logo', $org->logo_path);
        }

        if ($request->hasFile('letterhead')) {
            $org->letterhead_path = $this->store($request->file('letterhead'), 'letterhead', $org->letterhead_path);
        } elseif ($request->boolean('remove_letterhead') && $org->letterhead_path) {
            $this->delete($org->letterhead_path);
            $org->letterhead_path = null;
        }
    }

    /**
     * Saves straight under public/ (not storage/) so it works without a storage symlink
     * and dompdf can read it from disk.
     */
    private function store(UploadedFile $file, string $kind, ?string $previous): string
    {
        $dir = public_path(Organization::UPLOAD_DIR);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = $kind . '-' . now()->format('YmdHis') . '.' . $file->guessExtension();
        $file->move($dir, $name);

        if ($previous) {
            $this->delete($previous);
        }

        return Organization::UPLOAD_DIR . '/' . $name;
    }

    private function delete(string $relative): void
    {
        // Only ever remove files inside the uploads folder
        if (str_starts_with($relative, Organization::UPLOAD_DIR . '/') && is_file(public_path($relative))) {
            @unlink(public_path($relative));
        }
    }

    private function log(Request $request, string $activity): void
    {
        if ($request->user()) {
            ActivityLog::create(['user_id' => $request->user()->id, 'activity' => $activity]);
        }
    }
}
