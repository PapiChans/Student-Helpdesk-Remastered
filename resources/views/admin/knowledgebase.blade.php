<x-admin-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')
<!-- Add Folder Modal -->
<div class="modal modal-blur fade" id="addFolder-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Add Folder</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFolderForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Folder Name <span class="text-danger">*</span></label>
                        <input type="text" id="add_folder" class="form-control" placeholder="Add Folder Name" maxlength=40 required/>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" id="addFolderFormSubmit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Folder Modal -->
<div class="modal modal-blur fade" id="editFolder-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Edit Folder</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editFolderForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <input type="hidden" id="edit_folder_id"/>
                        <label class="form-label">Folder Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_folder" class="form-control" placeholder="Edit Folder Name" maxlength=40 required/>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" id="editFolderFormSubmit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
  @endslot

  @slot('content')
    <h1>Knowledgebase</h1>
    <div class="row" id="show-resolved-button">
        <div class="col-12 d-flex justify-content-end">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle mb-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Add New
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addFolder-modal">Folder</a>
                <a class="dropdown-item" href="#">Article</a>
            </div>
        </div>
        </div>
    </div>
    <div class="card">
    <div class="row g-0">
        <div class="col-12 col-lg-5 col-xl-3 border-end">
            <div class="card-body p-0 scrollable" style="max-height: 35rem">
                <div class="nav flex-column nav-pills" role="tablist">
                    <div class="nav-link text-start mw-100 p-3">
                        <div class="row align-items-center flex-fill">
                            <div class="col text-body">
                                <div class="d-flex justify-content-center">
                                    <h2>Folders</h2>
                                </div>
                                <div class="mb-2" id="folder_lists">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7 col-xl-9 d-flex flex-column">
            <div class="card-body scrollable" style="height: 35rem">
                <h2>Topics</h2>
                <div class="mb-2" id="topic_lists">
                    <div class="d-flex justify-content-center">
                        <h2>Select Folder to See Topic</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/bootstrap/validation.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/knowledgebase.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>