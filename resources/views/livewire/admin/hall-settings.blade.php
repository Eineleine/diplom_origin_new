<section class="conf-step">
  <header class="conf-step__header conf-step__header_opened">
    <h2 class="conf-step__title">Конфигурация залов</h2>
  </header>
  <div class="conf-step__wrapper">
    @if(count($halls) > 0)
    <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
    <ul class="conf-step__selectors-box">
      @foreach ($halls as $hall)
      <li wire:click="selectHall({{ $hall->id }})"">
        <input type="radio" class="conf-step__radio" name="chairs-hall" value="{{ $hall->id }}" wire:model="currentHall" wire:key="hall{{ $hall->id }}">
        <span class="conf-step__selector">{{ $hall->title }}</span>
      </li>
      @endforeach
    </ul>

    @foreach ($halls as $hall)
    @if ($currentHall === $hall->id)
    <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
    <div class="conf-step__legend">
      <label class="conf-step__label">Рядов, шт<input type="text" class="conf-step__input" wire:model.blur="rows_count.{{ $hall->id }}" wire:key="rows{{ $hall->id }}"></label>
      <span class="multiplier">x</span>
      <label class="conf-step__label">Мест, шт<input type="text" class="conf-step__input" wire:model.blur="seats_count.{{ $hall->id }}" wire:key="seats{{ $hall->id }}"></label>
      @error('*_count.*')<p class="conf-step__error"> {{ $message }} </p>@enderror
    </div>
    <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
    <div class="conf-step__legend">
      <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
      <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
      <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
      <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
    </div>

    <div class="conf-step__hall">
      <div class="conf-step__hall-wrapper">
        @if(!$preventSeatsRender)
        @for ($i = 1; $i <= $rows_count[$hall->id]; $i++)
          <div class="conf-step__row">
            @for ($j = 1; $j <= $seats_count[$hall->id]; $j++)
              <span class="conf-step__chair conf-step__chair_{{ $seats[$hall->id][$i][$j] }}" wire:click="switchSeatType({{ $i }}, {{ $j }})" wire:key="seat{{$hall->id}}-{{$i}}-{{$j}}"></span>
              @endfor
          </div>
          @endfor
          @endif
      </div>
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