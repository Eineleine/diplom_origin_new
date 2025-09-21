<div>
  <nav class="page-nav">
    @for($i = 0; $i < 7; $i++)
    <a @class([
      'page-nav__day',
      'page-nav__day_today' => $i === 0,
      'page-nav__day_chosen' => $i === $chosenDay
      ]) wire:click="$set('chosenDay', {{ $i }})">
      <span class="page-nav__day-week"> {{ $week[$i]->minDayName }}</span><span class="page-nav__day-number">{{ $week[$i]->day }}</span>
    </a>
    @endfor
  </nav>

  <main>
    @foreach($movies as $movie)
    <section class="movie">
      <div class="movie__info">
        <div class="movie__poster">
          <img class="movie__poster-image" alt="{{ $movie->title }} постер" src="{{ Storage::url($movie->poster) }}">
        </div>
        <div class="movie__description">
          <h2 class="movie__title">{{ $movie->title }}</h2>
          <p class="movie__synopsis">{{ $movie->description }}</p>
          <p class="movie__data">
            <span class="movie__data-duration">{{ $movie->duration }} минут</span>
            <span class="movie__data-origin">{{ $movie->country }}</span>
          </p>
        </div>
      </div>

      @foreach($halls as $hall)
      @if($hall->seances->where('movie_id', $movie->id)->isNotEmpty())
      <div class="movie-seances__hall">
        <h3 class="movie-seances__hall-title">{{ $hall->title }}</h3>
        <ul class="movie-seances__list">
          @foreach($hall->seances->where('movie_id', $movie->id)->sortBy('start') as $seance)
          <li class="movie-seances__time-block"><a class="movie-seances__time" href="seance/{{ $seance->id }}?date={{ $week[$chosenDay]->toDateString() }}">{{ $seance->start }}</a></li>
          @endforeach
        </ul>
      </div>
      @endif
      @endforeach
    </section>
    @endforeach
  </main>
</div>