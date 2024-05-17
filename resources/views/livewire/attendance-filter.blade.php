<div  class="flex flex-col items-center bg-gray-100 dark:bg-gray-900 rounded-lg py-8 border dark:border-gray-700">
    <h2 class="text-2xl font-bold mb-4 text-center">Filtrar Asistencias por Fecha</h2>
    <form wire:submit.prevent="filter" class="flex flex-col items-center space-y-4">
    
        <div class="flex flex-col">
            <label for="startDate" class="text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Inicio</label>
            <input type="date" wire:model="startDate" id="startDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-800 dark:text-gray-100" />
            @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col">
            <label for="endDate" class="text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Fin</label>
            <input type="date" wire:model="endDate" id="endDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-800 dark:text-gray-100" />
            @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 rounded-md font-bold" style="background-color: #94B431; color: white; border: none; hover:bg-blue-600; focus:outline-none; focus:ring-2; focus:ring-blue-500;">
            Filtrar
        </button>
    </form>

    @if($totalAttendances)
        <!-- Tarjeta con la cantidad total de asistencias -->
      <div class="w-1/2 mt-6 p-10 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-md shadow-md text-center justify-between">
          <p class="pt-6 mt-4 text-sm font-medium text-slate-500">Total de Asistencias:</p>
          <h3 class="text-3xl font-bold my-4 text-center">{{ $totalAttendances }}</h3>
          <p class="my-4 text-sm text-slate-700 dark:text-slate-300"><strong>Rango de fechas:</strong> {{ $startDate }} y {{ $endDate }}</p>
          <p class="my-4 text-sm text-slate-700 dark:text-slate-300"><strong>Creado:</strong> {{ now()->format('Y-m-d') }}</p>
      </div>
    @endif
</div>
