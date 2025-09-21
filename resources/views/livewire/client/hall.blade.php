<main>
  <section class="buying">
    <div class="buying__info">
      <div class="buying__info-description">
        <h2 class="buying__info-title">{{ $seance->movie->title}}</h2>
        <p class="buying__info-start">Начало сеанса: {{ $seance->start }}, {{ $date }}</p>
        <p class="buying__info-hall">{{ $seance->hall->title }}</p>
      </div>
      <div class="buying__info-hint">
        <p>Тапните дважды,<br>чтобы увеличить</p>
      </div>
    </div>
    <div class="buying-scheme">
      <div class="buying-scheme__wrapper">
        @for ($i = 1; $i <= $seance->hall->rows_count; $i++)
          <div class="buying-scheme__row">
            @for ($j = 1; $j <= $seance->hall->seats_count; $j++)
              <span
                class="buying-scheme__chair buying-scheme__chair_{{ $seats[$i][$j]['selected'] ? 'selected' : $seats[$i][$j]['type'] }}"
                @if ($seats[$i][$j]['type'] !=='disabled' && $seats[$i][$j]['type'] !=='taken' )
                wire:click="toggleSelect({{ $i }}, {{ $j }})"
                @endif
                data-id="{{ $seats[$i][$j]['seat_id'] }}"
                wire:key="{{ $seats[$i][$j]['seat_id'] }}"></span>
              @endfor
          </div>
          @endfor
      </div>
      <div class="buying-scheme__legend">
        <div class="col">
          <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">{{ $seance->hall->price_standart }}</span>руб)</p>
          <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">{{ $seance->hall->price_vip }}</span>руб)</p>
        </div>
        <div class="col">
          <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
          <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
        </div>
      </div>
    </div>
    <button class="acceptin-button" wire:click="confirmBooking()">Забронировать</button>
  </section>
</main>