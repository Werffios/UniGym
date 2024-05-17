<?php

namespace App\Livewire;

use Livewire\Component;

class Calculate extends Component
{
  public $peso;
  public $peso_levantado;
  public $repeticiones;
  public $resultados = [];

  public function rules()
  {
      return [
          'peso' => 'required|numeric',
          'peso_levantado' => 'required|numeric',
          'repeticiones' => 'required|numeric',
      ];
  }

  public function updated($propertyName)
  {
      $this->validateOnly($propertyName);
  }

  public function calcular()
  {
      $this->validate();

      $fuerzaMaxima = $this->peso_levantado * (1 + $this->repeticiones / 30);

      $this->resultados = [
          'fuerza_maxima' => round($fuerzaMaxima, 2) . ' Kg',
          '60' => round($fuerzaMaxima * 0.60, 2) . ' Kg',
          '65' => round($fuerzaMaxima * 0.65, 2) . ' Kg',
          '70' => round($fuerzaMaxima * 0.70, 2) . ' Kg',
          '75' => round($fuerzaMaxima * 0.75, 2) . ' Kg',
          '80' => round($fuerzaMaxima * 0.80, 2) . ' Kg',
          'fuerza_peso' => round($fuerzaMaxima / $this->peso, 2),
      ];
  }

  public function render()
  {
      return view('livewire.calculate');
  }
}
