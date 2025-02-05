<x-user-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')

  @endslot

  @slot('content')
    <h1>Welcome</h1>
  @endslot

  @slot('customJS')
  <script src="{{ asset('js/ajax/user/home.ajax.js')}}" defer></script>
  @endslot
</x-user-layout>