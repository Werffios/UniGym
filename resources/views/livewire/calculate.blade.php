<div class="flex flex-col items-center bg-gray-100 dark:bg-gray-900 rounded-xl py-8 border dark:border-gray-700">
    <h2 class="text-2xl flex justify-center text-gray-900 dark:text-gray-100 font-bold">Calculadora de fuerza máxima</h2>

    <form wire:submit.prevent="calcular" class="w-full mt-6 max-w-lg bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
        {{-- Peso --}}
        <div class="form-group mb-4">
            <label for="peso" class="block text-sm font-medium text-slate-700">Peso corporal (Kg)</label>
            <input wire:model.defer="peso" type="number" id="peso" class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm placeholder-gray-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Ingrese el peso">
            @error('peso')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Peso Levantado --}}
        <div class="form-group mb-4">
            <label for="peso_levantado" class="block text-sm font-medium text-slate-700">Peso levantado (Kg)</label>
            <input wire:model.defer="peso_levantado" type="number" id="peso_levantado" class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm placeholder-gray-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Ingrese el peso levantado">
            @error('peso_levantado')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Repeticiones --}}
        <div class="form-group mb-4">
            <label for="repeticiones" class="block text-sm font-medium text-slate-700">Repeticiones</label>
            <input wire:model.defer="repeticiones" type="number" id="repeticiones" class="w-full mt-1 px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm placeholder-gray-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block rounded-md sm:text-sm focus:ring-1 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" placeholder="Ingrese el número de repeticiones">
            @error('repeticiones')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-center">
            <button type="submit" class="w-80 flex px-4 py-2 rounded-md font-bold" style="background-color: #94B431; color: white; border: none; hover:bg-blue-600; focus:outline-none; focus:ring-2; focus:ring-blue-500;">
            Calcular<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </button> 
                       
        </div>
        


    </form>

    @if (!empty($resultados))
    <h2 class="text-xl mt-6 mb-4 text-center text-gray-900 font-bold">Resultados</h2>
    <div class="flex flex-wrap justify-center gap-4">
        <div class="p-4 bg-white dark:bg-gray-800 rounded-md shadow-md text-center">
            <h3 class="text-lg font-semibold text-slate-700">Fuerza Máxima</h3>
            <p class="text-gray-900 dark:text-gray-100">{{ $resultados['fuerza_maxima'] }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-md shadow-md text-center">
            <h3 class="text-lg font-semibold text-slate-700">60%</h3>
            <p class="text-gray-900 dark:text-gray-100">{{ $resultados['60'] }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-md shadow-md text-center">
            <h3 class="text-lg font-semibold text-slate-700">65%</h3>
            <p class="text-gray-900 dark:text-gray-100">{{ $resultados['65'] }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-md shadow-md text-center">
            <h3 class="text-lg font-semibold text-slate-700">70%</h3>
            <p class="text-gray-900 dark:text-gray-100">{{ $resultados['70'] }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-md shadow-md text-center">
            <h3 class="text-lg font-semibold text-slate-700">75%</h3>
            <p class="text-gray-900 dark:text-gray-100">{{ $resultados['75'] }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-md shadow-md text-center">
            <h3 class="text-lg font-semibold text-slate-700">80%</h3>
            <p class="text-gray-900 dark:text-gray-100">{{ $resultados['80'] }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-md shadow-md text-center">
            <h3 class="text-lg font-semibold text-slate-700">Relación Fuerza/Peso</h3>
            <p class="text-gray-900 dark:text-gray-100">{{ $resultados['fuerza_peso'] }}</p>
        </div>     
    </div>
@endif

