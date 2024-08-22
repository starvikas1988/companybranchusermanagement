@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create User</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container mt-5">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                
                <div id="company-branch-container">
                    <!-- Initial Company-Branch Pair -->
                    <div class="company-branch-pair mb-3">
                        <select name="company_branch_pairs[0][company_id]" class="form-control company-select">
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <select name="company_branch_pairs[0][branch_id]" class="form-control branch-select">
                            <option value="">Select Branch</option>
                        </select>
                        <br>
                        <button type="button" class="btn btn-danger remove-pair">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-pair" class="btn btn-primary">Add Another Company-Branch</button>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
<!-- Add jQuery and Bootstrap JS here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to add a new company-branch pair
        let pairIndex = 1;
        $('#add-pair').on('click', function() {
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
            $('#company-branch-container').append(newPair);
            pairIndex++;
        });

        // Function to remove a company-branch pair
        $(document).on('click', '.remove-pair', function() {
            $(this).closest('.company-branch-pair').remove();
        });

        // Function to populate branches based on selected company
        $(document).on('change', '.company-select', function() {
            const companyId = $(this).val();
            const branchSelect = $(this).closest('.company-branch-pair').find('.branch-select');
            branchSelect.html('<option value="">Select Branch</option>'); // Reset branch dropdown

            if (companyId) {
                fetch(`/branches_per_company/${companyId}`)
                    .then(response => response.json())
                    .then(data => {
                        branchSelect.html('<option value="">Select Branch</option>');
                        data.forEach(branch => {
                            branchSelect.append(`<option value="${branch.id}">${branch.name}</option>`);
                        });
                    })
                    .catch(error => console.error('Fetch Error:', error));
            }
        });
    });
</script>
@endsection