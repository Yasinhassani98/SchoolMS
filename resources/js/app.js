import './bootstrap';
import Echo from 'laravel-echo';
// import Reverb from 'laravel-reverb';

// window.Reverb = Reverb;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME || 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';

const app = createApp({});
app.mount('#app');

// Check if user is logged in
if (window.userId) {
    // Listen to the user's notification channel
    window.Echo.private(`App.Models.User.${window.userId}`)
        .notification((notification) => {
            // Add new notification to the notification list
            let notificationList = document.getElementById('notification-list');
            if (notificationList) {
                let notificationItem = document.createElement('li');
                notificationItem.className = `${notification.read_at ? 'notification-read' : 'notification-unread'}`;

                // Create notification content with proper styling
                notificationItem.innerHTML = `
                    <a href="javascript:void(0)" class="d-flex align-items-center">
                        <span class="mr-3 avatar-icon bg-${notification.type || 'info'}-lighten-2">
                            <i class="icon-${getIconForNotificationType(notification.type || 'info')}"></i>
                        </span>
                        <div class="notification-content flex-grow-1">
                            <h6 class="notification-heading font-weight-bold mb-0">
                                ${notification.title || 'Notification'}
                            </h6>
                            <p class="notification-text mb-0">
                                ${notification.message || ''}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="notification-timestamp text-muted">
                                    Just now
                                </small>
                                <form action="/notifications/${notification.id}/mark-as-read" method="POST" class="d-inline">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                    <button type="submit" class="btn btn-link p-0 text-primary" style="font-size: 0.7rem;">
                                        Mark as read
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
                `;

                // Add notification at the beginning of the list
                if (notificationList.firstChild) {
                    notificationList.insertBefore(notificationItem, notificationList.firstChild);
                } else {
                    notificationList.appendChild(notificationItem);
                }

                // Update unread notification count badge
                updateNotificationBadge();

                // Show toast notification
                showToast(notification.title || 'Notification', notification.message || '', notification.type || 'info');
            }
        });
}

/**
 * Get the appropriate icon class based on notification type
 * @param {string} type - Notification type
 * @return {string} Icon class
 */
function getIconForNotificationType(type) {
    switch (type) {
        case 'success': return 'check';
        case 'warning': return 'exclamation';
        case 'danger': return 'close';
        case 'info':
        default: return 'info';
    }
}

/**
 * Update the notification badge count
 */
function updateNotificationBadge() {
    let notificationBadge = document.querySelector('.badge.badge-pill.gradient-2');

    if (notificationBadge) {
        let count = parseInt(notificationBadge.textContent) + 1;
        notificationBadge.textContent = count;
        notificationBadge.style.display = 'inline-block';
    } else {
        // If no badge exists, find the notification bell icon and add a badge
        let bellIcon = document.querySelector('.mdi.mdi-bell-outline');
        if (bellIcon && bellIcon.parentElement) {
            let badge = document.createElement('span');
            badge.className = 'badge badge-pill gradient-2 position-absolute';
            badge.textContent = '1';
            badge.style.top = '-5px';
            badge.style.right = '-5px';

            // Make sure parent has position relative
            bellIcon.parentElement.style.position = 'relative';
            bellIcon.parentElement.appendChild(badge);
        }
    }
}

/**
 * Show a toast notification
 * @param {string} title - Toast title
 * @param {string} message - Toast message
 * @param {string} type - Notification type (success, warning, danger, info)
 */
function showToast(title, message, type = 'info') {
    // Set toast background color based on type
    let bgColor, textColor = '#212529';
    switch (type) {
        case 'success':
            bgColor = '#d1e7dd';
            break;
        case 'warning':
            bgColor = '#fff3cd';
            break;
        case 'danger':
            bgColor = '#f8d7da';
            break;
        case 'info':
        default:
            bgColor = '#cff4fc';
            break;
    }

    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.style.backgroundColor = bgColor;
    toast.style.color = textColor;
    toast.style.minWidth = '300px';
    toast.style.margin = '0 0 10px 0';
    toast.style.boxShadow = '0 0.5rem 1rem rgba(0, 0, 0, 0.15)';
    toast.style.borderRadius = '0.25rem';
    toast.style.border = 'none';

    toast.innerHTML = `
        <div class="toast-header" style="background-color: ${bgColor}; border-bottom: 1px solid rgba(0,0,0,.05);">
            <strong class="me-auto">${title}</strong>
            <small>Just now</small>
            <button type="button" class="btn-close" style="font-size: 0.875rem; margin-left: 10px;" aria-label="Close"></button>
        </div>
        <div class="toast-body" style="padding: 12px;">
            ${message}
        </div>
    `;

    // Add toast to container
    toastContainer.appendChild(toast);

    // Auto-close toast after 5 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s ease';

        // Remove toast after fade out
        setTimeout(() => {
            toast.remove();

            // Remove container if empty
            if (toastContainer.children.length === 0) {
                toastContainer.remove();
            }
        }, 500);
    }, 5000);

    // Add close button functionality
    toast.querySelector('.btn-close').addEventListener('click', () => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s ease';

        setTimeout(() => {
            toast.remove();

            // Remove container if empty
            if (toastContainer.children.length === 0) {
                toastContainer.remove();
            }
        }, 500);
    });
}
