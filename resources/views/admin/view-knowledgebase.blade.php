<x-admin-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')
<!--Preview Modal -->
<div class="modal modal-blur fade" id="preview-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Preview</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="preview-area">

                </div>
            </div>
            </form>
        </div>
    </div>
</div>
  @endslot

  @slot('content')
<form id="editTopicForm" class="needs-validation" novalidate>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-lg-8">
            <div class="card card-sm">
                <div class="card-body">
                    <h1>Content</h1>
                    <div class="col-md-12 mt-2">
                        <textarea required class="form-control" id="edit_content" rows="5" placeholder="Topic Content."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <label class="form-label mt-2">Title<span class="text-danger">*</span></label>
                    <input type="text" id="edit_title" class="form-control" placeholder="Edit Topic Name" maxlength=50 required/>
                    <div class="mb-3">
                        <label class="form-label mt-2">Change Folder<span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_topic_folder" required>
                                <option selected="" value="" disabled>Select Folder</option>

                            </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label mt-2">Status<span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_status" required>
                                <option selected="" value="" disabled>Status</option>
                                <option value="Published">Published</option>
                                <option value="Unpublished">Unpublished</option>
                            </select>
                    </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#preview-modal" onclick="preview()">Preview</button>
                            <button type="button" class="btn btn-danger m-1" onclick="deleteTopic()">Delete</button>
                            <button type="submit" id="editTopicFormSubmit" class="btn btn-success m-1">Save Changes</button>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/showdown/showdown.min.js')}}" defer></script>
  <script src="{{ asset('libs/bootstrap/validation.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/view-knowledgebase.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>