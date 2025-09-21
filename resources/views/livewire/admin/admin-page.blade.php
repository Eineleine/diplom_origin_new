<div>
  <main class="conf-steps">
    <livewire:admin.halls-list :$halls />

    <livewire:admin.hall-settings :$halls />

    <livewire:admin.hall-prices :$halls />

    <livewire:admin.seances :$halls />

    <livewire:admin.open-sales :$halls />
  </main>

  <livewire:admin.forms.new-hall />
  <livewire:admin.forms.delete-hall />
  <livewire:admin.forms.new-movie />
  <livewire:admin.forms.delete-movie />


  <script src="{{asset('js/accordeon.js')}}"></script>
  <script src="{{asset('js/seances.js')}}"></script>
</div>