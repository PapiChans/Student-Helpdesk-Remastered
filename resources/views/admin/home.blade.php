<x-admin-layout>
  @slot('customCSS')

  @endslot

  @slot('content')
    <h1>Hello World</h1>
  @endslot

  @slot('customJS')
  <script src="{{ asset('js/ajax/admin/home.ajax.js')}}" defer></script>
  @endslot
</x-admin-layout>