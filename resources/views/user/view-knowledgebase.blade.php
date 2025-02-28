<x-user-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')

  @endslot

  @slot('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-lg-8">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="col-md-12 mt-2" id="topic_content">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-2">Title</h4>
                    <p id="topic_title"></p>
                    <div class="mb-3">
                        <h4 class="mt-2">Folder</h4>
                        <p id="topic_folder"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/showdown/showdown.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/user/view-knowledgebase.ajax.js')}}" defer></script>
  @endslot
</x-user-layout>