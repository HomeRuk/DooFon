<html>
<head>
    <meta charset="utf-8">
    <title>{{$model->file}}</title>
    <link rel="stylesheet" href="{{ asset('css/kv-mpdf-bootstrap.css') }}"/>
    <style>
        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>
<body>

<h4><b>FileName: </b> {{$model->modelname}}</h4>
@foreach($texts as $text)
    {{$text}}<br>
@endforeach

<htmlpagefooter name="page-footer">
    <p class="text-left"><b>Create At:</b> {{date("d/m/Y H:i:s")}}</p>
    <p class="text-right">Page: {PAGENO}</p>
</htmlpagefooter>
</body>
</html>


