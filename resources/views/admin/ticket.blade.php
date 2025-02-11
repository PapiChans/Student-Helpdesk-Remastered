<x-admin-layout>
  @slot('customCSS')
  <link href="{{ asset('libs/datatables/dataTables.min.css')}}" rel="stylesheet" />
  <link href="{{ asset('libs/datatables/responsive.dataTables.min.css')}}" rel="stylesheet" />
  @endslot

  @slot('modals')

  @endslot

  @slot('content')
    <h1>Tickets</h1>
    <div class="card">
      <div class="card-body">
        <table id="ticketTable" class="display table hover table-striped responsive nowrap" >
            <thead>
                <tr>
                    <th class="text-center">Ticket Number</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Priority</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Date Created</th>
                </tr>
            </thead>
        </table>
      </div>
    </div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/datatables/dataTables.min.js')}}" defer></script>
  <script src="{{ asset('libs/datatables/dataTables.responsive.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/ticket.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>