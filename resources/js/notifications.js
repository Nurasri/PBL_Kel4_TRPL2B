// Auto refresh notifikasi setiap 30 detik
setInterval(function() {
    fetch('/api/notifications')
        .then(response => response.json())
        .then(data => {
            updateNotificationBadge(data.unread_count);
            updateNotificationDropdown(data.notifications);
        })
        .catch(error => console.error('Error fetching notifications:', error));
}, 30000);

function updateNotificationBadge(count) {
    const badge = document.querySelector('#notification-badge');
    if (badge) {
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.style.display = 'inline-flex';
        } else {
            badge.style.display = 'none';
        }
    }
}

function updateNotificationDropdown(notifications) {
    const dropdown = document.querySelector('#notification-dropdown');
    if (!dropdown) return;

    let html = '';
    
    if (notifications.length === 0) {
        html = `
            <div class="px-4 py-8 text-center">
                <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-13h5v13z"></path>
                </svg>
                <p class="text-sm text-gray-500">Tidak ada notifikasi</p>
            </div>
        `;
    } else {
        notifications.forEach(notification => {
            const typeColors = {
                'success': 'green',
                'info': 'blue', 
                'warning': 'yellow',
                'danger': 'red'
            };
            
            const color = typeColors[notification.type] || 'gray';
            const isUnread = !notification.read_at;
            
            html += `
                <div class="border-b border-gray-100 dark:border-gray-600 last:border-b-0">
                    <a href="${notification.action_url || '#'}" 
                       onclick="markAsRead(${notification.id})"
                       class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-150 ${isUnread ? 'bg-blue-50 dark:bg-blue-900' : ''}">
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-${color}-500 rounded-full mt-2 mr-3 ${isUnread ? '' : 'opacity-30'}"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                    ${notification.title}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                    ${notification.message}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    ${formatTimeAgo(notification.created_at)}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        });
    }
    
    dropdown.innerHTML = html;
}

function markAsRead(notificationId) {
    fetch(`/api/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => {
        // Refresh notifications after marking as read
        setTimeout(() => {
            fetch('/api/notifications')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.unread_count);
                    updateNotificationDropdown(data.notifications);
                });
        }, 500);
    });
}

function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) return 'Baru saja';
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} menit yang lalu`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} jam yang lalu`;
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} hari yang lalu`;
    
    return date.toLocaleDateString('id-ID');
}

// Mark all as read function
function markAllAsRead() {
    fetch('/api/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => {
        location.reload();
    });
}
