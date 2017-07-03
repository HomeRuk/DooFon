<?php
header('Content-Type: application/json; charset=utf-8');
$json = json_decode($serialnumbers);
echo json_encode($json, JSON_PRETTY_PRINT);
//{{$devices}}
?>

