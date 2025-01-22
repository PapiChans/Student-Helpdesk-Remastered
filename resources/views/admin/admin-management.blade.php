<x-admin-layout>
  @slot('customCSS')
  <link href="{{ asset('libs/datatables/dataTables.min.css')}}" rel="stylesheet" />
  <link href="{{ asset('libs/datatables/responsive.dataTables.min.css')}}" rel="stylesheet" />
  @endslot

  @slot('modals')
 <!-- Add Admin Modal -->
<div class="modal modal-blur fade" id="addAdmin-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Add Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="signupForm" class="needs-validation" novalidate>
                    <div class="row mb-3">
                        <div class="col-6">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" id="last_name" class="form-control" placeholder="Enter Last Name" maxlength=20 required/>
                        </div>
                        <div class="col-6">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" id="first_name" class="form-control" placeholder="Enter First Name" maxlength=20 required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                        <label class="form-label">Middle Name</label>
                        <input type="text" id="middle_name" class="form-control" placeholder="Enter Middle Name" maxlength=20>
                        </div>
                        <div class="col-6">
                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                        <select class="form-select" id="gender" required>
                            <option selected="" value="" disabled>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="email" class="form-control" placeholder="Enter Email" maxlength=40 required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off" minlength=8 maxlength=20 required/>
                            <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                            </a>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm Password" autocomplete="off" minlength=8 maxlength=20 required/>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" id="signupFormSubmit" class="btn btn-primary w-100">Create new account</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Register</button>
            </div>
        </div>
    </div>
</div>
  @endslot

  @slot('content')
    <h1>Admin Management</h1>
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdmin-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                        Add Admin
                    </button>
            </div>
        </div>
        <table id="adminTable" class="display table hover table-striped responsive nowrap" >
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Office</th>
                    <th class="text-center">Master Admin</th>
                    <th class="text-center">Technician</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
        </table>
    <h1 class="mt-5">Office Management</h1>
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdmin-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                        Add Office
                    </button>
            </div>
        </div>
        <table id="officeTable" class="display table hover table-striped responsive nowrap" >
            <thead>
                <tr>
                    <th class="text-center">Office</th>
                    <th class="text-center">Added By</th>
                    <th class="text-center">Date Added</th>
                    <th class="text-center">Last Modified</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
        </table>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/datatables/dataTables.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/dataTables.responsive.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/admin-management.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>