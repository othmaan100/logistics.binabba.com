{{-- Organization details form, shared by the first-run setup and the admin settings page --}}
@php $v = fn ($field) => old($field, $org->{$field}); @endphp

<div class="org-section">
    <div class="org-section-head">
        <span class="org-step">1</span>
        <div>
            <h3>Organization</h3>
            <p>How the organization is named across the system and on printed documents.</p>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="name">Organization name <span class="req">*</span></label>
            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $v('name') }}"
                placeholder="e.g. Acme Haulage Limited" required maxlength="255">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group col-md-4">
            <label for="short_name">Short name <span class="req">*</span></label>
            <input id="short_name" name="short_name" class="form-control @error('short_name') is-invalid @enderror" value="{{ $v('short_name') }}"
                placeholder="e.g. Acme" required maxlength="40">
            <small class="form-text">Shown in the sidebar and browser tab.</small>
            @error('short_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="tagline">Tagline or line of business</label>
            <input id="tagline" name="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ $v('tagline') }}"
                placeholder="e.g. Transporters and General Contractors" maxlength="255">
            @error('tagline')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group col-md-4">
            <label for="rc_number">RC number</label>
            <input id="rc_number" name="rc_number" class="form-control @error('rc_number') is-invalid @enderror" value="{{ $v('rc_number') }}"
                placeholder="e.g. 1234567" maxlength="50">
            @error('rc_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="org-section">
    <div class="org-section-head">
        <span class="org-step">2</span>
        <div>
            <h3>Contact details</h3>
            <p>Printed on invoices, reports and other documents.</p>
        </div>
    </div>
    <div class="form-group">
        <label for="address">Address <span class="req">*</span></label>
        <input id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $v('address') }}"
            placeholder="e.g. No. 12, Example Road, Kano" required maxlength="255">
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="phone">Phone number(s) <span class="req">*</span></label>
            <input id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $v('phone') }}"
                placeholder="e.g. 08030000000, 08020000000" required maxlength="255">
            <small class="form-text">Separate several numbers with commas.</small>
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email address(es) <span class="req">*</span></label>
            <input id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $v('email') }}"
                placeholder="e.g. info@company.com" required maxlength="255">
            <small class="form-text">Separate several addresses with commas.</small>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="form-group">
        <label for="website">Website</label>
        <input id="website" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ $v('website') }}"
            placeholder="e.g. www.company.com" maxlength="255">
        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="org-section">
    <div class="org-section-head">
        <span class="org-step">3</span>
        <div>
            <h3>Branding</h3>
            <p>PNG, JPG or WebP images.</p>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="logo">Logo @if (!$org->logo_path)<span class="req">*</span>@endif</label>
            <div class="org-upload">
                <div class="org-preview" id="logoPreview">
                    @if ($org->logo_path)
                        <img src="{{ $org->logoUrl() }}" alt="Current logo">
                    @else
                        <i class="far fa-image"></i>
                    @endif
                </div>
                <div class="org-upload-body">
                    <input id="logo" type="file" name="logo" accept="image/png,image/jpeg,image/webp"
                        class="form-control-file @error('logo') is-invalid @enderror" @if (!$org->logo_path) required @endif
                        data-preview="logoPreview">
                    <small class="form-text">Square or wide, up to 2 MB.{{ $org->logo_path ? ' Leave empty to keep the current logo.' : '' }}</small>
                    @error('logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="letterhead">Letterhead image <span class="text-muted font-weight-normal">(optional)</span></label>
            <div class="org-upload">
                <div class="org-preview org-preview-wide" id="letterheadPreview">
                    @if ($org->letterhead_path)
                        <img src="{{ $org->letterheadUrl() }}" alt="Current letterhead">
                    @else
                        <i class="far fa-file-image"></i>
                    @endif
                </div>
                <div class="org-upload-body">
                    <input id="letterhead" type="file" name="letterhead" accept="image/png,image/jpeg,image/webp"
                        class="form-control-file @error('letterhead') is-invalid @enderror" data-preview="letterheadPreview">
                    <small class="form-text">A ready-made banner for the top of documents, up to 4 MB. Without one, a header is built from the details above.</small>
                    @if ($org->letterhead_path)
                        <label class="org-check"><input type="checkbox" name="remove_letterhead" value="1"> Remove the current letterhead</label>
                    @endif
                    @error('letterhead')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show a preview of a chosen image before it is uploaded
    document.querySelectorAll('input[type=file][data-preview]').forEach(function (input) {
        input.addEventListener('change', function () {
            var box = document.getElementById(input.dataset.preview);
            if (!input.files || !input.files[0] || !box) return;
            var img = document.createElement('img');
            img.alt = 'Preview';
            img.src = URL.createObjectURL(input.files[0]);
            box.innerHTML = '';
            box.appendChild(img);
        });
    });
</script>
