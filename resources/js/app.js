import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Initialize Echo with better error handling
const initializeEcho = () => {
    try {
        window.Pusher = Pusher;
        
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: import.meta.env.VITE_REVERB_APP_KEY || 'zkl0dl4s2sskyfytscln',
            wsHost: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
            wsPort: parseInt(import.meta.env.VITE_REVERB_PORT || '8080'),
            wssPort: parseInt(import.meta.env.VITE_REVERB_PORT || '8080'),
            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
            disableStats: true,
            cluster: 'mt1',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                }
            }
        });

        // Log connection status
        window.Echo.connector.pusher.connection.bind('connected', () => {
            console.log('Echo connected successfully to Reverb server');
        });

        window.Echo.connector.pusher.connection.bind('error', (err) => {
            console.error('Echo connection error:', err);
        });

        console.log('Echo initialized with Reverb', {
            key: import.meta.env.VITE_REVERB_APP_KEY || 'zkl0dl4s2sskyfytscln',
            host: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
            port: parseInt(import.meta.env.VITE_REVERB_PORT || '8080')
        });
    } catch (error) {
        console.error('Failed to initialize Echo:', error);
    }
};

// Initialize Echo immediately
initializeEcho();

// Import Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
