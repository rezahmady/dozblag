// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.6.8/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.6.8/firebase-messaging.js');


// Initialize Firebase
var firebaseConfig = {
    apiKey: "AIzaSyBEEI9LBfnspWNjUOu0L4zJCzVC-PUByUU",
    authDomain: "react-lesson-c7038.firebaseapp.com",
    databaseURL: "https://react-lesson-c7038.firebaseio.com",
    projectId: "react-lesson-c7038",
    storageBucket: "react-lesson-c7038.appspot.com",
    messagingSenderId: "652673181841",
    appId: "1:652673181841:web:44ecc7e7c42cba1e7ef730"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    // console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    // const notificationTitle = 'Background Message Title';
    // const notificationOptions = {
    //     body: 'Background Message body.',
    //     icon: '/firebase-logo.png'
    // };

    // self.registration.showNotification(notificationTitle,
    //     notificationOptions);
});