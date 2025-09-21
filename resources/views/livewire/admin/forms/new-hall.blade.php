<div @class(['popup', 'active'=> $active]) id="newHallPopup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Добавление зала
          <div class="popup__dismiss" wire:click="$set('active', false)">
            <img src="i/ui/cross.png" alt="Закрыть">
          </div>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form accept-charset="utf-8" wire:submit="save">
          <label class="conf-step__label conf-step__label-fullsize">
            Название зала
            <input class="conf-step__input" type="text" placeholder="Например, &laquo;Зал 1&raquo;" required wire:model.blur="title">
            @error('title')<p class="conf-step__error"> {{ $message }} </p>@enderror
          </label>
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent">
            <button class="conf-step__button conf-step__button-regular" type="button" wire:click="discard">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>