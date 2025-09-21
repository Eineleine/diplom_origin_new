<div @class(['popup', 'active'=> $active]) id="newMoviePopup">
  <div class="popup__container">
    <div class="popup__content">
      <h2 class="popup__header">
        <div class="popup__title">
          Добавление фильма
          <div class="popup__dismiss" wire:click="$set('active', false)">
            <img src="i/ui/cross.png" alt="Закрыть">
          </div>
        </div>
      </h2>
      <div class="popup__wrapper">
        <form wire:submit="save" accept-charset="utf-8">
          <div class="popup__container">
            @if ($poster)
            <div class="popup__poster">
              <img src="{{ $poster->temporaryUrl() }}" alt="Постер">
            </div>
            @endif
            <div class="popup__form">
              <label class="conf-step__label conf-step__label-fullsize">
                Название фильма
                <input type="text" class="conf-step__input" name="title" placeholder="Например, «Гражданин Кейн»" wire:model.blur="title">
                @error('title')<p class="conf-step__error"> {{ $message }} </p>@enderror
              </label>
              <label class="conf-step__label conf-step__label-fullsize">
                Продолжительность фильма (мин.)
                <input type="text" class="conf-step__input" name="duration" wire:model.blur="duration">
                @error('duration')<p class="conf-step__error"> {{ $message }} </p>@enderror
              </label>
              <label class="conf-step__label conf-step__label-fullsize">
                Описание фильма
                <textarea type="text" class="conf-step__input" name="description" wire:model.blur="description"></textarea>
                @error('description')<p class="conf-step__error"> {{ $message }} </p>@enderror
              </label>
              <label class="conf-step__label conf-step__label-fullsize">
                Страна
                <input type="text" class="conf-step__input" name="country" wire:model.blur="country">
                @error('country')<p class="conf-step__error"> {{ $message }} </p>@enderror
              </label>
            </div>
          </div>
          <input type="file" name="poster" id="poster" wire:model.blur="poster">
          @error('poster')<p class="conf-step__error"> {{ $message }} </p>@enderror
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent">
            <label class="conf-step__button conf-step__button-accent popup__upload-file" for="poster">Загрузить постер</label>
            <button class="conf-step__button conf-step__button-regular" type="button" wire:click="discard">Отмена</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>