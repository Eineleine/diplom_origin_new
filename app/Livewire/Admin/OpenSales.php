<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;

class OpenSales extends Component
{
  public $halls;
  public $salesActive;

  #[On('inactive-hall')] 
  public function setInactive() {
    $this->salesActive = false;
  }

  public function openSales()
  {
    try {
      foreach ($this->halls as $hall) {
        $hall->active = true;
        $hall->save();
      }
      $this->salesActive = true;
      $this->js("alert('Продажи открыты')");
    } catch (\Exception $e) {
      return response($e, 500);
    }
  }

  public function closeSales()
  {
    try {
      foreach ($this->halls as $hall) {
        $hall->active = false;
        $hall->save();
      }
      $this->salesActive = false;
      $this->js("alert('Продажи приостановлены')");
    } catch (\Exception $e) {
      return response($e, 500);
    }
  }

  public function mount() {
    $this->salesActive = $this->halls->firstWhere('active', false) === null;
  }


  public function render()
  {
    return <<<'HTML'
        <section class="conf-step">
          <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Открыть продажи</h2>
          </header>
          @if(count($halls) > 0)
          <div class="conf-step__wrapper text-center">
            @if($this->salesActive)
            <button class="conf-step__button conf-step__button-accent" type="button" wire:click="closeSales">Приостановить продажу билетов</button>
            @else
            <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
            <button class="conf-step__button conf-step__button-accent" type="button" wire:click="openSales">Открыть продажу билетов</button>
            @endif
          </div>
          @endif
        </section>
        HTML;
  }
}
