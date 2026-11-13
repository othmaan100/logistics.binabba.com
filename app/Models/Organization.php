<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Organization extends Model
{
    protected $table = 'organization_settings';

    protected $fillable = [
        'name', 'short_name', 'tagline', 'rc_number', 'address', 'phone',
        'email', 'website', 'logo_path', 'letterhead_path', 'setup_completed_at',
    ];

    protected $casts = [
        'setup_completed_at' => 'datetime',
    ];

    // Where uploaded logos and letterheads are kept, relative to public/
    public const UPLOAD_DIR = 'uploads/organization';

    private static ?Organization $current = null;
    private static bool $loaded = false;

    /**
     * The organization's saved details, or null before setup has been done.
     * Looked up once per request.
     */
    public static function current(): ?self
    {
        if (!self::$loaded) {
            self::$loaded = true;
            self::$current = self::tableExists() ? self::query()->first() : null;
        }

        return self::$current;
    }

    public static function forget(): void
    {
        self::$loaded = false;
        self::$current = null;
    }

    public static function tableExists(): bool
    {
        try {
            return Schema::hasTable('organization_settings');
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function isSetUp(): bool
    {
        return (bool) self::current()?->setup_completed_at;
    }

    public function logoUrl(): ?string
    {
        return $this->logo_path ? asset($this->logo_path) : null;
    }

    public function letterheadUrl(): ?string
    {
        return $this->letterhead_path ? asset($this->letterhead_path) : null;
    }

    /**
     * An image embedded as a data: URI, so PDFs (dompdf) can show it without fetching a URL.
     */
    public function embedded(string $field): ?string
    {
        $path = $this->{$field} ? public_path($this->{$field}) : null;
        if (!$path || !is_file($path)) {
            return null;
        }

        $mime = mime_content_type($path) ?: 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    }

    /**
     * Phone numbers and emails may be entered comma-separated.
     */
    public function phones(): array
    {
        return self::splitList($this->phone);
    }

    public function emails(): array
    {
        return self::splitList($this->email);
    }

    private static function splitList(?string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/[,;\n]+/', (string) $value))));
    }
}
