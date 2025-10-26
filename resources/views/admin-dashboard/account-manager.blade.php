<!--**********************************
    Content body start
***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <!--form-->
            <div class="col-xl-12">
                <form id="updateAccountForm" class="flex-grow p-4 mb-4 bg-white border rounded">
                    @csrf
                    @method('PUT')
                    <h4 class="mb-4">Update Account</h4>

                    <div class="mb-4">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input type="text" name="name" id="nameInput" class="form-control"
                                placeholder="Kasun Perera" value="{{ old('name', auth()->user()->name) }}">
                            <div id="nameError" class="invalid-feedback d-none"></div>
                        </div>

                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email</label>
                            <input type="email" name="email" id="emailInput" class="form-control"
                                placeholder="email@company.com" value="{{ old('email', auth()->user()->email) }}">
                            <div id="emailError" class="invalid-feedback d-none"></div>
                        </div>

                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">
                                Password <small class="text-muted">(Keep empty to keep current password)</small>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="passwordInput" class="form-control"
                                    placeholder="******">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordError" class="invalid-feedback d-none"></div>
                        </div>
                    </div>

                    <div class="gap-3 d-flex justify-content-end w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--**********************************
    Content body end
***********************************-->

@push('page-ajax')
@include('admin-dashboard.footer.account-ajax')
@endpush
