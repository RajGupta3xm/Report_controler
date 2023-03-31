
/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
const firebaseConfig = {
  apiKey: "AIzaSyCoFdYyy5PAO54AsvvbfIkilTfoC-cge5g",
  authDomain: "diet-on-8fa10.firebaseapp.com",
  projectId: "diet-on-8fa10",
  storageBucket: "diet-on-8fa10.appspot.com",
  messagingSenderId: "468072234198",
  appId: "1:468072234198:web:5d3dc1c1288480e6851d77",
  measurementId: "G-H56RVNC37F"
};

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
firebase.initializeApp(firebaseConfig);
self.addEventListener('push', function (event) {
	var data = event.data.json();
 
	const title = data.Title;
	data.Data.actions = data.Actions;
	const options = {
		body: 'fcgfdg',
		data: 'dfgdgf'
	};
	event.waitUntil(self.registration.showNotification(title, options));
});
 
self.addEventListener('notificationclick', function (event) {});
 
self.addEventListener('notificationclose', function (event) {});

// const messaging = firebase.messaging();
// messaging.setBackgroundMessageHandler(function(payload) {
//   console.log('[firebase-messaging-sw.js] Received background message ', payload);
//   // Customize notification here
//   const notificationTitle = 'Background Message Title';
//   const notificationOptions = {
//     body: 'Background Message body.',
//     icon: '/firebase-logo.png'
//   };

//   return self.registration.showNotification(notificationTitle,
//       notificationOptions);
// });