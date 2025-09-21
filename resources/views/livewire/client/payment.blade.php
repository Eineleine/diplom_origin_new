<main>
  <section class="ticket">
    
    <header class="tichet__check">
    <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
    </header>
    
    <div class="ticket__info-wrapper">
    <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $seance->movie->title }}</span></p>
    <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">
      @foreach($seats as $seat)
      ряд {{ $seat->row }}, место {{ $seat->seat }}{{ $loop->last ? '' : ';'}}
      @endforeach
    </span></p>
    <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $seance->hall->title}}</span></p>
    <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ $seance->start }}, {{ $date }}</span></p>
    <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">{{ $fullPrice }}</span> рублей</p>

    <button class="acceptin-button" wire:click="buyTickets()" >Получить код бронирования</button>

    <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контролёру у входа в зал.</p>
    <p class="ticket__hint">Приятного просмотра!</p>
    </div>
  </section>   
  </main>