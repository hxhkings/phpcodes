<?php

print_r(PDO::getAvailableDrivers());
try{


$pdo = new PDO('sqlsrv:server=DESKTOP-V2LVG5L\SQLEXPRESS17;Database=first;ConnectionPooling=0;TraceOn=1;','sa','hunter1hunter');
$q = "SELECT * FROM mytable";
$query = $pdo->prepare($q);
$query->execute();
$results = $query->fetchall(PDO::FETCH_ASSOC);

var_dump($pdo);
echo 'Connected! <br>';
print_r($results);
foreach($results as $result){
	echo "<br>I'm " . $result['firstname'] . ' ' . $result['lastname'];
}
}
catch (PDOException $e)
{
	echo $e->getMessage();
}

?>