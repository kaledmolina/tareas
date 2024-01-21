<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tareas') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-full sm:max-w-xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:p-8 text-gray-900 dark:text-gray-100">
                    <livewire:tarealist />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
