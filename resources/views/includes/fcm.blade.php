<link rel="manifest" href="{{ asset('/json/manifest.json') }}">

<!-- Import and configure the Firebase -->
<script src="https://webdoofon.firebaseapp.com/__/firebase/3.9.0/firebase-app.js"></script>
<script src="https://webdoofon.firebaseapp.com/__/firebase/3.9.0/firebase-messaging.js"></script>
<script src="https://webdoofon.firebaseapp.com/__/firebase/init.js"></script>
<script src="{{ asset('js/fcm.js')}}"></script>

<script type="text/javascript">
    var url = '{{ url('/api/user/update/FCMTokenweb') }}';
    var user_id = {{ (Auth::user()->status === 'User') ? Auth::user()->id : null }}
    requestPermission();
</script>


