<x-user-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')

  @endslot

  @slot('content')
    <h1>Knowledgebase</h1>
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
                <div class="row" id="topic_title">
                    <div class="col-12">
                        <h2>Topics</h2>
                    </div>
                </div>
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
  <script src="{{ asset('js/ajax/user/knowledgebase.ajax.js')}}" defer></script>
  @endslot
</x-user-layout>