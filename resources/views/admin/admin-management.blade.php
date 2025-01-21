<x-admin-layout>
  @slot('customCSS')
  <link href="{{ asset('libs/datatables/dataTables.min.css')}}" rel="stylesheet" />
  @endslot

  @slot('content')
    <h1>Admin Management</h1>
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-primary">Add Admin</button>
            </div>
        </div>
        <table id="adminTable" class="display table hover table-striped" >
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
    <h1>Office Management</h1>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/datatables/dataTables.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/admin/admin-management.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>