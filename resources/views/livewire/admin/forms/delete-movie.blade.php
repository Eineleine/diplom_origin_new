<div @class(['popup', 'active'=> $active]) id="deleteMoviePopup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Удаление фильма
          <div class="popup__dismiss" wire:click="closePopup"><img src="i/ui/cross.png" alt="Закрыть"></div>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form wire:submit="deleteMovie" accept-charset="utf-8">
          <p class="conf-step__paragraph">Вы действительно хотите удалить фильм &laquo;{{ $movie ? $movie->title : '' }}&raquo;?</p>
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
            <button class="conf-step__button conf-step__button-regular" type="button" wire:click="closePopup">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
