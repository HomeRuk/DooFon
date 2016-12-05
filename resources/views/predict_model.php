<?php
$SerialNumber = "ZgkL2LfL0Q";
$db_con = mysqli_connect('localhost', 'root', 'Ruk31332', 'webservice') or die('ไม่สามารถติดต่อฐานข้อมูล MySQL ได้ ' . mysqli_connect_error());
$sql = "SELECT temp, humidity, dewpoint, pressure, light, rain 
			FROM weather 
			WHERE SerialNumber = 'ZgkL2LfL0Q' 
			ORDER BY id DESC LIMIT 1;";
$result = mysqli_query($db_con, $sql) or die('NO Connect to Database MySQL ได้ ' . mysqli_connect_error());
$fp = fopen(public_path().'/weka/arff/' . $SerialNumber . '.arff', 'w') or die("Unable to open file!");
$arff = "@relation $SerialNumber\r\n@attribute temp numeric\r\n@attribute humidity numeric\r\n@attribute dewpoint numeric\r\n@attribute pressure numeric\r\n@attribute light numeric\r\n@attribute rain {0, 1}\r\n\r\n@data\r\n";

fwrite($fp, $arff);
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($fp, $row);
}
//Disconnect to database
mysqli_close($db_con);
// Close file 
fclose($fp);
// run command shell
$shell = 'java -cp '
        .public_path().'/weka/weka.jar weka.classifiers.lazy.IBk -T '
        .public_path().'/weka/arff/'.$SerialNumber.'.arff -l '
        .public_path().'/weka/model/IBk_0.model -p 0 > '
        .public_path().'/weka/output/'.$SerialNumber.'.txt';
exec($shell);
dump($shell);
?>