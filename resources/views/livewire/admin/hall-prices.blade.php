<section class="conf-step">
  <header class="conf-step__header conf-step__header_opened">
    <h2 class="conf-step__title">Конфигурация цен</h2>
  </header>
  <div class="conf-step__wrapper">
    @if(count($halls) > 0)
    <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
    <ul class="conf-step__selectors-box">
      @foreach ($halls as $hall)
      <li wire:click="selectHall({{ $hall->id }})" wire:key="{{ $hall->id }}">
        <input type="radio" class="conf-step__radio" name="prices-hall" value="{{ $hall->id }}" wire:model="currentHall">
        <span class="conf-step__selector">{{ $hall->title }}</span>
      </li>
      @endforeach
    </ul>

    @foreach ($halls as $hall)
    @if ($currentHall === $hall->id)
    <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
    <div class="conf-step__legend">
      <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" value="{{ $prices[$hall->id]['standart'] }}" wire:model.blur="prices.{{ $hall->id }}.standart"></label>
      за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
      @error('prices.*.standart')<p class="conf-step__error"> {{ $message }} </p>@enderror
    </div>
    <div class="conf-step__legend">
      <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" value="{{ $prices[$hall->id]['vip'] }}" wire:model.blur="prices.{{ $hall->id }}.vip"></label>
      за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
      @error('prices.*.vip')<p class="conf-step__error"> {{ $message }} </p>@enderror
    </div>
    @endif
    @endforeach

    <fieldset class="conf-step__buttons text-center">
      <button class="conf-step__button conf-step__button-regular" type="button" wire:click="init">Отмена</button>
      <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent" wire:click="save">
    </fieldset>
    @endif
  </div>
</section>