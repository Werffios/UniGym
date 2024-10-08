<div class="flex flex-col items-center bg-gray-100 dark:bg-gray-900 rounded-xl py-8 border dark:border-gray-700">
    <h2 class="text-2xl font-bold mb-4 text-center">Filtrar asistencias</h2>
    <form wire:submit.prevent="filter" class="w-full mt-2 max-w-lg bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
        <div class="flex flex-col">
            <label for="startDate" class="block text-sm font-medium text-slate-700">Fecha de inicio</label>
            <input type="date" wire:model="startDate" id="startDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-800 dark:text-gray-100" />
            @error('startDate') <span class="text-sm" style="color: #CD6155">*{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col  mt-2">
            <label for="endDate" class="block text-sm font-medium text-slate-700">Fecha de fin</label>
            <input type="date" wire:model="endDate" id="endDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-xl shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-800 dark:text-gray-100" />
            @error('endDate') <span class="text-sm" style="color: #CD6155">*{{ $message }}</span> @enderror
        </div>


        <div class="flex justify-center">
          <button type="submit" class="w-80 mt-6 flex px-4 py-2 rounded-lg font-bold" style="background-color: #94B431; color: white; border: none; hover:bg-blue-600; focus:outline-none; focus:ring-2; focus:ring-blue-500;">            
            Filtrar<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
            </svg>
          </button>
        </div>
       
    </form>

    @if ($message)
    <!-- Mensaje cuando no se encuentran asistencias registradas -->
    <div style="margin-top: 1.5rem; padding: 1.5rem; background-color: #fee2e2; border-radius: 0.75rem; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); text-align: center; color: #b91c1c;">
        {{ $message }}
    </div>
    @endif


    @if($totalAttendances)
        <!-- Tarjeta con la cantidad total de asistencias -->
        <div class="w-1/2 mt-6 p-10 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl shadow-md text-center justify-between">
            <p class="pt-6 mt-4 text-sm font-medium text-slate-500">Total de Asistencias:</p>
            <h3 class="text-3xl font-bold my-4 text-center">{{ $totalAttendances }}</h3>
            <p class="my-4 text-sm text-slate-700 dark:text-slate-300"><strong>Rango de fechas:</strong> {{ $startDate }} y {{ $endDate }}</p>
          
          <!-- Botón de exportación a Excel -->
          <div class="flex justify-center mb-4">            
            <button wire:click="export" class="flex mt-3 px-4 py-2 rounded-lg font-bold" style="background-color: #3B82F6; color: white; border: none; hover:bg-blue-700; focus:outline-none; focus:ring-2; focus:ring-blue-500;">
              Exportar a Excel
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
              </svg>
            </button>
          </div>
        </div>

    @endif
</div>
