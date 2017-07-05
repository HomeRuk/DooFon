// [START get_messaging_object]
const messaging = firebase.messaging();
// [END get_messaging_object]

function requestPermission() {
// [START request_permission]
    console.log('Requesting permission...');
    messaging.requestPermission()
        .then(function () {
            console.log('Notification permission granted.');
            // TODO(developer): Retrieve an Instance ID token for use with FCM.
            // [START_EXCLUDE]
            getTokenFCM();
            // [END_EXCLUDE]
        })
        .catch(function (err) {
            console.log('Unable to get permission to notify.', err);
        });
// [END request_permission]
}

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
            getTokenFCM();
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

function getTokenFCM() {
    // [START get_token]
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
    // [END get_token]
}


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

function deleteToken() {
    // Delete Instance ID token.
    // [START delete_token]
    messaging.getToken()
        .then(function(currentToken) {
            messaging.deleteToken(currentToken)
                .then(function() {
                    console.log('Token deleted.');
                    setTokenSentToServer(false);
                    // [START_EXCLUDE]
                    // Once token is deleted update
                    getTokenFCM();
                    // [END_EXCLUDE]
                })
                .catch(function(err) {
                    console.log('Unable to delete token. ', err);
                });
            // [END delete_token]
        })
        .catch(function(err) {
            console.log('Error retrieving Instance ID token. ', err);
        });
}

// Save TokenFcm to DB
function saveTokenFCM(currentToken) {
    var user_id = this.user_id;
    var sid = 'Ruk';
    var obj = {
        'user_id': user_id,
        'FCMTokenweb': currentToken,
        'sid': sid
    };
    $.ajax({
        type: "post",
        url: url,
        contentType: "application/json;",
        data: JSON.stringify(obj),
        success: function (data) {
            console.log("Success : id -> " + user_id + " FCMtokenweb -> " + currentToken + " sid ->" + sid);
        },
        error: function (data) {
            console.log("Error :");
        }
    });
}
