<x-admin-layout>
  @slot('customCSS')
  <link rel="stylesheet" href="{{asset ('libs/flatpickr/flatpickr.min.css')}}">
  @endslot

  @slot('modals')

  @endslot

  @slot('content')
    <h1>Reports</h1>
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-center">
          <div class="col-6">
            <h1>Select Month and Year</h1>
            <form class="needs-validation" id="setMonthForm"  novalidate>
                <input type="date" id="selectMonth" class="form-control" required>
                <button type="submit" id="setMonthFormSubmit" class="btn btn-primary mt-2 w-100"> Submit</button>
            </form>
          </div>
        </div>
        <div class="mt-2">
          <h1>Monthly Ticket Status Report</h1>
          <table id="ticketStatusTable" class="display table hover table-striped responsive nowrap" >
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
        </div>
        <div class="mt-2">
          <h1>Monthly Ticket Rating Report</h1>
          <table id="ticketStatusTable" class="display table hover table-striped responsive nowrap" >
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
        </div>
        <div class="mt-2">
          <h1>Monthly Office Evaluation Report</h1>
          <table id="ticketStatusTable" class="display table hover table-striped responsive nowrap" >
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
        </div>
      </div>
    </div>
    
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/flatpickr/flatpickr.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/reports.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>