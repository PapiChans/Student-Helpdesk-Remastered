<x-admin-layout>
  @slot('customCSS')
  <link rel="stylesheet" href="{{asset ('libs/flatpickr/flatpickr.min.css')}}">
  <link href="{{ asset('libs/datatables/dataTables.min.css')}}" rel="stylesheet" />
  <link href="{{ asset('libs/datatables/buttons.dataTables.css')}}" rel="stylesheet" />
  <link href="{{ asset('libs/datatables/responsive.dataTables.min.css')}}" rel="stylesheet" />
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
        <div class="mt-5">
          <h1>Monthly Ticket Status Report</h1>
          <table id="ticketStatusTable" class="display table hover table-striped responsive nowrap" >
              <thead>
                  <tr>
                      <th class="text-center">Office</th>
                      <th class="text-center">Pending</th>
                      <th class="text-center">In Progress</th>
                      <th class="text-center">Resolved</th>
                      <th class="text-center">Closed</th>
                      <th class="text-center">Total</th>
                  </tr>
              </thead>
          </table>
        </div>
        <div class="mt-5">
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
        <div class="mt-5">
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
  <script src="{{ asset('libs/datatables/dataTables.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/dataTables.buttons.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/buttons.dataTables.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/jszip.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/pdfmake.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/vfs_fonts.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/buttons.html5.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/buttons.print.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/dataTables.responsive.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/reports.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>