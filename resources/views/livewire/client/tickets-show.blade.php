<main>
    <section class="tickets">
        <header class="tichet__check">
            <h2 class="ticket__check-title">Электронный билет</h2>
        </header>
            @foreach($tickets as $ticket)
            <div class="ticket__info-wrapper">
                <div class="ticket__info">
                    <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $ticket->seance->movie->title }}</span></p>
                    <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">ряд {{ $ticket->seat->row }}, место {{ $ticket->seat->seat }}</span></p>
                    <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $ticket->seance->hall->title }}</span></p>
                    <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ $ticket->seance->start }}, {{ $ticket->seance_date }}</span></p>
                </div>
                <div class="ticket__info-qr">
                    {!! QrCode::size(150)->generate($ticket->code) !!}
                </div>
                <p class="ticket__hint">Покажите QR-код нашему контролеру для подтверждения бронирования.</p>
                <p class="ticket__hint">Приятного просмотра!</p>
            </div>
            @endforeach
    </section>
</main>