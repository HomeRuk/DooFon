<link rel="manifest" href="{{ asset('/json/manifest.json') }}">
<!-- Import and configure the Firebase SDK -->
<!-- These scripts are made available when the app is served or deployed on Firebase Hosting -->
<!-- If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup -->
<script src="https://webdoofon.firebaseapp.com/__/firebase/3.9.0/firebase-app.js"></script>
<script src="https://webdoofon.firebaseapp.com/__/firebase/3.9.0/firebase-messaging.js"></script>
<script src="https://webdoofon.firebaseapp.com/__/firebase/init.js"></script>

<script>
    // [START get_messaging_object]
    // Retrieve Firebase Messaging object.
    const messaging = firebase.messaging();
    // [END get_messaging_object]

    console.log('Requesting permission...');
    // [START request_permission]
    messaging.requestPermission()
        .then(function () {
            console.log('Notification permission granted.');
            // TODO(developer): Retrieve an Instance ID token for use with FCM.
            // [START_EXCLUDE]
            // In many cases once an app has been granted notification permission, it
            // should update its UI reflecting this.
            resetUI();
            // [END_EXCLUDE]
        })
        .catch(function (err) {
            console.log('Unable to get permission to notify.', err);
        });

    // [END request_permission]

    // [START refresh_token]
    // Callback fired if Instance ID token is updated.
    messaging.onTokenRefresh(function () {
        messaging.getToken()
            .then(function (refreshedToken) {
                console.log('Token refreshed.');
                // Indicate that the new Instance ID token has not yet been sent to the
                // app server.
                setTokenSentToServer(false);
                // Send Instance ID token to app server.
                sendTokenToServer(refreshedToken);
                // [START_EXCLUDE]
                // Display new Instance ID token and clear UI of all previous messages.
                resetUI();
                // [END_EXCLUDE]
            })
            .catch(function (err) {
                console.log('Unable to retrieve refreshed token ', err);
            });
    });
    // [END refresh_token]

    messaging.onMessage(function (payload) {
        console.log("Message received. ", payload);
    });
    // [END receive_message]

    function resetUI() {
        // [START get_token]
        // Get Instance ID token. Initially this makes a network call, once retrieved
        // subsequent calls to getToken will return from cache.
        messaging.getToken()
            .then(function (currentToken) {
                if (currentToken) {
                    sendTokenToServer(currentToken);
                    saveTokenFCM(currentToken);
                } else {
                    // Show permission request.
                    console.log('No Instance ID token available. Request permission to generate one.');
                    // Show permission UI.
                    setTokenSentToServer(false);
                }
            })
            .catch(function (err) {
                console.log('An error occurred while retrieving token. ', err);
                setTokenSentToServer(false);
            });
    }
    // [END get_token]

    // Send the Instance ID token your application server, so that it can:
    // - send messages back to this app
    // - subscribe/unsubscribe the token from topics
    function sendTokenToServer(currentToken) {
        if (!isTokenSentToServer()) {
            console.log('Sending token to server...');
            // TODO(developer): Send the current token to your server.
            setTokenSentToServer(true);
        } else {
            console.log('Token already sent to server so won\'t send it again ' +
                'unless it changes');
        }

    }

    function isTokenSentToServer() {
        return window.localStorage.getItem('sentToServer') == 1;
    }

    function setTokenSentToServer(sent) {
        window.localStorage.setItem('sentToServer', sent ? 1 : 0);
    }

    function saveTokenFCM(currentToken) {
        var user_id = '1';
        var sid = 'Ruk';
        var token_fcmweb = currentToken;
        var obj = {
            'user_id': user_id,
            'token_fcmweb': token_fcmweb,
            'sid': sid,
        };
        $.ajax({
            type: "post",
            url: "http://localhost/DooFon/public/api/user/update/FCMtoken",
            contentType: "application/json;",
            data: JSON.stringify(obj),
            success: function (data) {
                console.log("Success");

            },
            error: function (data) {
                console.log("error ");
            }
        });
    }
    resetUI();
</script>