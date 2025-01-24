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
                <form id="registerAdminForm" class="needs-validation" novalidate>
                    <div class="row mb-3">
                        <div class="col-6">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" id="add_last_name" class="form-control" placeholder="Enter Last Name" maxlength=20 required/>
                        </div>
                        <div class="col-6">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" id="add_first_name" class="form-control" placeholder="Enter First Name" maxlength=20 required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                        <label class="form-label">Middle Name</label>
                        <input type="text" id="add_middle_name" class="form-control" placeholder="Enter Middle Name" maxlength=20>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_gender" required>
                                <option selected="" value="" disabled>Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Prefer not to say">Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="add_email" class="form-control" placeholder="Enter Email" maxlength=40 required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Office Assigned <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_office" required>
                                <option selected="" value="" disabled>Select Office</option>

                            </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-check form-switch form-switch-3">
                            <input class="form-check-input" id="add_is_technician" type="checkbox">	
                            <span class="form-check-label">Assign as Technician</span>
                        </label>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" id="registerAdminFormSubmit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Admin Modal -->
<div class="modal modal-blur fade" id="editAdmin-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Edit Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editregisterAdminForm" class="needs-validation" novalidate>
                    <div class="row mb-3">
                        <div class="col-6">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_last_name" class="form-control" placeholder="Enter Last Name" maxlength=20 required/>
                        </div>
                        <div class="col-6">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_first_name" class="form-control" placeholder="Enter First Name" maxlength=20 required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                        <label class="form-label">Middle Name</label>
                        <input type="text" id="edit_middle_name" class="form-control" placeholder="Enter Middle Name" maxlength=20>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_gender" required>
                                <option selected="" value="" disabled>Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Prefer not to say">Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" id="edit_email" class="form-control" placeholder="Enter Email" maxlength=40 required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Office Assigned <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_office" required>
                                <option selected="" value="" disabled>Select Office</option>

                            </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-check form-switch form-switch-3">
                            <input class="form-check-input" id="edit_add_is_technician" type="checkbox">	
                            <span class="form-check-label">Assign as Technician</span>
                        </label>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" id="editregisterAdminFormSubmit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Admin Modal -->
<div class="modal modal-blur fade" id="addOffice-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Add Office</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerOfficeForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Office Name <span class="text-danger">*</span></label>
                        <input type="text" id="register_office" class="form-control" placeholder="Add Office Name" maxlength=40 required/>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" id="registerOfficeFormSubmit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Admin Modal -->
<div class="modal modal-blur fade" id="editOffice-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Edit Office</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editregisterOfficeForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <input type="hidden" id="edit_register_office_id"/>
                        <label class="form-label">Office Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_register_office" class="form-control" placeholder="Edit Office Name" maxlength=40 required/>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" id="editregisterOfficeFormSubmit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
  @endslot

  @slot('content')
        <div class="row align-items-center">
            <div class="col-6 d-flex justify-content-start align-items-center">
                <h1>Admin Management</h1>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
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

        <div class="row">
            <div class="col-6 justify-content-start align-items-center d-flex">
                <h1 class="mt-5">Office Management</h1>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOffice-modal">
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
  <script src="{{ asset('libs/bootstrap/validation.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/dataTables.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/dataTables.responsive.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/admin-management.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>