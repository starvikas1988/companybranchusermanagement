<!-- resources/views/users/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password (Leave it blank if you don't want to change.)</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password (Leave it blank if you don't want to change Password.)</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <!-- Company-Branch Pairs -->
        <div id="company-branch-container">
            @foreach($user->companies as $company)
                <div class="company-branch-pair mb-3">
                    <select name="company_branch_pairs[0][company_id]" class="form-control company-select">
                        <option value="">Select Company</option>
                        @foreach($companies as $comp)
                            <option value="{{ $comp->id }}" {{ $comp->id == $company->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                        @endforeach
                    </select>
                    <select name="company_branch_pairs[0][branch_id]" class="form-control branch-select">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $branch->company_id == $company->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-danger remove-pair">Remove</button>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-pair" class="btn btn-primary">Add Another Company-Branch</button>
        <button type="submit" class="btn btn-success">Update User</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Add a new company-branch pair
    let pairIndex = {{ count($user->companies) }};
    document.getElementById('add-pair').addEventListener('click', function() {
        const newPair = `
            <div class="company-branch-pair mb-3">
                <select name="company_branch_pairs[${pairIndex}][company_id]" class="form-control company-select">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
                <select name="company_branch_pairs[${pairIndex}][branch_id]" class="form-control branch-select">
                    <option value="">Select Branch</option>
                </select>
                <button type="button" class="btn btn-danger remove-pair">Remove</button>
            </div>
        `;
        document.getElementById('company-branch-container').insertAdjacentHTML('beforeend', newPair);
        pairIndex++;
    });

    // Remove a company-branch pair
    document.getElementById('company-branch-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-pair')) {
            e.target.closest('.company-branch-pair').remove();
        }
    });

    // Update branches based on selected company
    document.getElementById('company-branch-container').addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('company-select')) {
            const companyId = e.target.value;
            const branchSelect = e.target.nextElementSibling;

            if (branchSelect) {
                branchSelect.innerHTML = '<option value="">Select Branch</option>'; // Reset branch dropdown

                if (companyId) {
                    fetch(`/branches_per_company/${companyId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(branch => {
                                const option = document.createElement('option');
                                option.value = branch.id;
                                option.textContent = branch.name;
                                branchSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Fetch Error:', error));
                }
            }
        }
    });
});

</script>
@endsection
