importScripts('https://www.gstatic.com/firebasejs/12.13.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/12.13.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyDZHzg97344lqzH4fjpb_tda5c0VMO36es",
    authDomain: "sisal-e8016.firebaseapp.com",
    projectId: "sisal-e8016",
    storageBucket: "sisal-e8016.firebasestorage.app",
    messagingSenderId: "473592016862",
    appId: "1:473592016862:web:9dd66833be41b9a5cfb74f",
    measurementId: "G-9EKQLZYZ3V"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    const titulo = payload.notification?.title || 'Nueva alerta SISAL';
    const opciones = {
        body: payload.notification?.body || 'Se ha registrado una nueva alerta.',
        icon: '/icons/icon-192.png',
        badge: '/icons/icon-192.png',
        data: {
            url: payload.data?.url || '/dashboard'
        }
    };

    self.registration.showNotification(titulo, opciones);
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const url = event.notification.data?.url || '/dashboard';

    event.waitUntil(
        clients.openWindow(url)
    );
});
