<section class="conf-step">
  <header class="conf-step__header conf-step__header_opened">
    <h2 class="conf-step__title">Управление залами</h2>
  </header>
  <div class="conf-step__wrapper">
    @if(count($halls) > 0)
    <p class="conf-step__paragraph">Доступные залы:</p>
    <ul class="conf-step__list">
      @foreach ($halls as $hall)
      <li wire:key="$hall->id">{{ $hall->title }}
        <button
          class="conf-step__button conf-step__button-trash"
          wire:click="$dispatchTo('admin.forms.delete-hall', 'delete-hall', { id: {{$hall->id}} })"></button>
      </li>
      @endforeach
    </ul>
    @else
    <p class="conf-step__paragraph">Залов нет.</p>
    @endif
    <button
      class="conf-step__button conf-step__button-accent"
      id="create-hall"
      type="button"
      wire:click="$dispatchTo('admin.forms.new-hall','new-hall')">Создать зал</button>
  </div>
</section>