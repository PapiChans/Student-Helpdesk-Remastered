<x-admin-layout>
  @slot('customCSS')
  <link rel="stylesheet" href="{{asset ('libs/flatpickr/flatpickr.min.css')}}">
  @endslot

  @slot('modals')

  @endslot

  @slot('content')
    <h1>Welcome, Admin</h1>
    <div class="card">
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-4 justify-content-center mb-3">
              <h1>Select Month and Year</h1>
              <form class="needs-validation" id="setMonthForm"  novalidate>
                  <input type="date" id="selectMonth" class="form-control" required>
                  <button type="submit" id="setMonthFormSubmit" class="btn btn-primary mt-2 w-100"> Submit</button>
              </form>
            </div>
            <div class="d-flex col-12 col-sm-8 justify-content-center mb-2">
              <div id="analytic-chart" style="width: 290px; height:400px; overflow-x: hidden;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/bootstrap/validation.js')}}" defer></script>
  <script src="{{ asset('libs/echarts/echarts.min.js')}}" defer></script>
  <script src="{{ asset('libs/flatpickr/flatpickr.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/home.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>