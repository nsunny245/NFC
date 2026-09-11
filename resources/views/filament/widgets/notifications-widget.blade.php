<x-filament-widgets::widget>
    @php
        $notifs = $this->getNotifications();
    @endphp

    <style>
        .nfc-notif-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
        }
        .dark .nfc-notif-card {
            background: #0f172a !important;
            border-color: #334155 !important;
        }
    </style>

    @if(count($notifs) > 0)
        <x-filament::section class="border-yellow-500/25 transition-all" wire:poll.5s>
            <x-slot name="heading">
                <div class="flex items-center gap-2.5">
                    <span class="text-xl">🔔</span>
                    <span class="text-sm font-bold tracking-wider text-amber-500 dark:text-amber-400">ACTIVE ROYAL ALERTS REGISTER</span>
                    <span class="px-2 py-0.5 rounded-full bg-red-600 text-white text-[9px] font-extrabold animate-pulse leading-none">
                        {{ count($notifs) }} PENDING
                    </span>
                </div>
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mt-3">
                @foreach($notifs as $notif)
                    <div class="nfc-notif-card p-3.5 rounded-xl flex flex-col justify-between gap-3 shadow-sm relative overflow-hidden">
                        <div class="flex justify-between items-start gap-2">
                            <div class="min-w-0">
                                <h4 class="text-xs font-extrabold text-gray-800 dark:text-gray-100 uppercase tracking-wide flex items-center gap-1.5 truncate">
                                    @if($notif->type === 'online_order')
                                        <span>🚨</span>
                                    @else
                                        <span>📅</span>
                                    @endif
                                    {{ $notif->title }}
                                </h4>
                                <p class="text-[10px] text-gray-500 dark:text-slate-400 mt-1 leading-snug">{{ $notif->message }}</p>
                                <span class="text-[8px] text-gray-400 mt-1.5 block font-mono">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <button wire:click="markAsRead({{ $notif->id }})" class="text-gray-400 hover:text-gray-250 dark:hover:text-gray-200 font-extrabold text-sm leading-none shrink-0">&times;</button>
                        </div>

                        <div class="flex justify-end gap-2 border-t border-gray-100 dark:border-gray-900 pt-2 shrink-0">
                            @if($notif->type === 'online_order')
                                <button wire:click="sendKitchenKOT({{ $notif->id }}, {{ $notif->related_id }})" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-[10px] font-extrabold rounded-lg flex items-center gap-1.5 transition-all shadow-sm">
                                    <span>👨‍🍳</span> Send Kitchen
                                </button>
                            @elseif($notif->type === 'table_reservation')
                                <button wire:click="markAsRead({{ $notif->id }})" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-black text-[10px] font-extrabold rounded-lg flex items-center gap-1.5 transition-all shadow-sm">
                                    <span>📅</span> Accept & Dismiss
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </x-filament::section>
    @endif
</x-filament-widgets::widget>
