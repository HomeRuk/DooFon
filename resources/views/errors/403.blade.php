<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Error 403<br>คุณไม่มีสิทธ์ในการเข้าหน้านี้</div>
                <h2><a href="{{ url('/') }}">หน้าหลัก</a></h2>
                <h2><a href="{{ url('/logout') }}">ออกจากระบบ</a></h2>
            </div>
        </div>
    </body>
</html>
