<h4>คลิกที่นี่เพื่อกู้คืนรหัสผ่านของคุณ: <a href="{{ url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> คลิกที่นี่ </a></h4>
<br/>
<h4>หรือ</h4>
<br/>
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
