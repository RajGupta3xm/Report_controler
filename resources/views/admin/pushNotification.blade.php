<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel Firebase Push Notification to Android and IOS App Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  
<br/>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
     
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
    
                    <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body"></textarea>
                          </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>
    
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

    <!-- <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase.js"></script>
    <script src = "https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js" > </script> 
<script src = "https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js" > </script>

    <script>
/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/


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
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});

            // messaging.onMessage(function(payload) {
            //     const noteTitle = payload.notification.title;
            //     const noteOptions = {
            //         body: payload.notification.body,
            //         icon: payload.notification.icon,
            //     };
            //     new Notification(noteTitle, noteOptions);
            // });
</script> -->