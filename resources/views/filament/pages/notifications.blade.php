<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
          

            @php
                $unreadCount = auth()->user()->unreadNotifications()->count();
            @endphp

            @if($unreadCount > 0)
                <x-filament::button wire:click="markAllAsRead" color="success">
                    <x-filament::icon name="heroicon-o-check" class="mr-2 h-5 w-5" />
                    Mark all as read
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-semibold leading-none text-white bg-rose-500 rounded-full">{{ $unreadCount }}</span>
                </x-filament::button>
            @else
                <button class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium bg-gray-200 text-gray-700" disabled>
                  
                </button>
            @endif
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
