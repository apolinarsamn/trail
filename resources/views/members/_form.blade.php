@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-4">
        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" id="first_name" name="first_name"
            class="form-control @error('first_name') is-invalid @enderror"
            value="{{ old('first_name', $member->first_name) }}" required>

        @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="middle_name" class="form-label">Middle Name</label>
        <input type="text" id="middle_name" name="middle_name"
            class="form-control"
            value="{{ old('middle_name', $member->middle_name) }}">
    </div>

    <div class="col-md-4">
        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" id="last_name" name="last_name"
            class="form-control @error('last_name') is-invalid @enderror"
            value="{{ old('last_name', $member->last_name) }}" required>

        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
        <input type="email" id="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $member->email) }}" required>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="phone_number" class="form-label">Phone Number</label>
        <input type="text" id="phone_number" name="phone_number"
            class="form-control"
            placeholder="e.g. 09171234567"
            value="{{ old('phone_number', $member->phone_number) }}">
    </div>

    <div class="col-md-6">
        <label for="membership_category" class="form-label">
            Membership Category <span class="text-danger">*</span>
        </label>

        <select id="membership_category" name="membership_category"
            class="form-select @error('membership_category') is-invalid @enderror" required>
            <option value="">Select a category</option>

            @foreach (['Student', 'Regular', 'Senior Citizen', 'Corporate'] as $category)
                <option value="{{ $category }}"
                    @selected(old('membership_category', $member->membership_category) === $category)>
                    {{ $category }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="membership_level" class="form-label">
            Membership Level <span class="text-danger">*</span>
        </label>

        <select id="membership_level" name="membership_level"
            class="form-select @error('membership_level') is-invalid @enderror" required>
            <option value="">Select a level</option>

            @foreach (['Basic', 'Silver', 'Gold', 'Platinum'] as $level)
                <option value="{{ $level }}"
                    @selected(old('membership_level', $member->membership_level) === $level)>
                    {{ $level }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="birth_date" class="form-label">Birth Date</label>
        <input type="date" id="birth_date" name="birth_date"
            class="form-control"
            value="{{ old('birth_date', $member->birth_date) }}">
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Membership Status <span class="text-danger">*</span></label>

        <select id="status" name="status" class="form-select" required>
            <option value="Active" @selected(old('status', $member->status ?? 'Active') === 'Active')>
                Active
            </option>
            <option value="Inactive" @selected(old('status', $member->status) === 'Inactive')>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-12">
        <label for="address" class="form-label">Address</label>
        <textarea id="address" name="address" rows="3" class="form-control"
            placeholder="Enter complete address">{{ old('address', $member->address) }}</textarea>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-brand">{{ $buttonText }}</button>
    </div>
</div>