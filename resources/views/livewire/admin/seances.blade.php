<section class="conf-step">
  <header class="conf-step__header conf-step__header_opened">
    <h2 class="conf-step__title">Сетка сеансов</h2>
  </header>
  <div class="conf-step__wrapper">
    @if(count($halls) > 0)
    <p class="conf-step__paragraph">
      <button class="conf-step__button conf-step__button-accent" type="button" wire:click="$dispatchTo('admin.forms.new-movie', 'new-movie')">Добавить фильм</button>
    </p>
    <div class="conf-step__movies">
      @foreach($movies as $movie)
      <div class="conf-step__movie" data-id="{{ $movie->id }}">
        <img class="conf-step__movie-poster" alt="{{ $movie->title }} poster" src="{{ Storage::url($movie->poster) }}">
        <h3 class="conf-step__movie-title">{{ $movie->title }}</h3>
        <p class="conf-step__movie-duration">{{ $movie->duration }} минут</p>
        <div class="conf-step__movie-delete" wire:click="$dispatchTo('admin.forms.delete-movie', 'delete-movie', { id: {{ $movie->id }} })"></div>
      </div>
      @endforeach
    </div>

    <div class="conf-step__seances">
      @foreach($halls as $hall)
      <div class="conf-step__seances-hall" data-id="{{ $hall->id }}">
        <h3 class="conf-step__seances-title">{{ $hall->title }}</h3>
        <div class="conf-step__seances-timeline">
          @foreach($hall->seances as $seance)
          <div class="conf-step__seances-movie" data-id="{{ $seance->movie_id }}" style="width: {{  $seance->movie->duration / 2 }}px">
            <p class="conf-step__seances-movie-title">{{ $seance->movie->title }}</p>
            <p class="conf-step__seances-movie-start">{{ $seance->start }}</p>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>

    <fieldset class="conf-step__buttons text-center">
      <button class="conf-step__button conf-step__button-regular" type="button" wire:click="$refresh">Отмена</button>
      <input type="button" value="Сохранить" class="conf-step__button conf-step__button-accent" onclick="collectSeances()">
    </fieldset>
    @endif
  </div>
</section>