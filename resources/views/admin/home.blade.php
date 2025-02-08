<x-admin-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')

  @endslot

  @slot('content')
    <h1>Welcome, Admin</h1>
    <div class="card">
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="d-flex col-12 col-sm-3 justify-content-center mb-2">
              <h1>Set Month and Year</h1>
            </div>
            <div class="d-flex col-12 col-sm-9 justify-content-center mb-2">
              <div id="analytic-chart" style="width: 290px; height:400px; overflow-x: hidden;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/echarts/echarts.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/home.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>