<x-app>
    <x-slot:title>Notifikasi</x-slot:title>
    
    <div class="container px-6 mx-auto grid">
        <div class="flex justify-between items-center">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Notifikasi
            </h2>
            @if(auth()->user()->unreadNotifications()->count() > 0)
                <form method="POST" action="{{ route('api.notifications.mark-all-read') }}">
                    @csrf
                    <x-button variant="secondary" type="submit">
                        Tandai Semua Dibaca
                    </x-button>
                </form>
            @endif
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <x-card class="hover:shadow-md transition-shadow {{ !$notification->is_read ? 'border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4 flex-1">
                                <div class="w-3 h-3 bg-{{ $notification->type_color }}-500 rounded-full mt-2 {{ $notification->is_read ? 'opacity-30' : '' }}"></div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ $notification->title }}
                                        </h3>
                                        <span class="text-sm text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-400 mb-3">
                                        {{ $notification->message }}
                                    </p>
                                    <div class="flex items-center space-x-4">
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" 
                                               onclick="event.preventDefault(); markAsReadAndRedirect({{ $notification->id }}, '{{ $notification->action_url }}')"
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Lihat Detail →
                                            </a>
                                        @endif
                                        @if(!$notification->is_read)
                                            <button onclick="markAsRead({{ $notification->id }})" 
                                                    class="text-gray-500 hover:text-gray-700 text-sm">
                                                Tandai Dibaca
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <x-card class="text-center py-12">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-13h5v13z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Tidak ada notifikasi</h3>
                <p class="text-gray-500 dark:text-gray-400">Notifikasi akan muncul di sini ketika ada aktivitas baru.</p>
            </x-card>
        @endif
    </div>

    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(() => {
                location.reload();
            });
        }

        function markAsReadAndRedirect(notificationId, url) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
                }
            }).then(() => {
                window.location.href = url;
            });
        }
    </script>
</x-app>