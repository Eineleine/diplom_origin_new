<div @class(['popup', 'active'=> $active]) id="deleteHallPopup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Удаление зала
          <div class="popup__dismiss" wire:click="closePopup">
            <img src="i/ui/cross.png" alt="Закрыть">
          </div>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form wire:submit="deleteHall" accept-charset="utf-8">
          <p class="conf-step__paragraph">Вы действительно хотите удалить зал &laquo;{{ $hall ? $hall->title : '' }}&raquo;?</p>
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
            <button class="conf-step__button conf-step__button-regular" type="button" wire:click="closePopup">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>