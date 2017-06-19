<?php
header('Content-Type: application/json; charset=utf-8');
$json = json_decode($Dserialnumbers);
echo json_encode($json, JSON_PRETTY_PRINT);
//{{$devices}}
?>

