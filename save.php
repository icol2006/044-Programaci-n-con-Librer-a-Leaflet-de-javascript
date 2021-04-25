<?php
include_once 'database.php';

if (isset($_POST['save'])) {
	$res="undone";
	$latitud = $_POST['lat'];
	$longitud = $_POST['lon'];
	$sql = "UPDATE inmuebles set latitud='" . $_POST['lat'] . "', longitud='" . $_POST['lon'] . "' where codigo=" . $_POST['id'];
	if (mysqli_query($conn, $sql) === TRUE) {
		echo "Registro actualizado!";
		$res="done";
	} else {
		echo "Registro no fue actualizado";
	}
	mysqli_close($conn);

	header(
		"Location: index.php?" .
			"id=" . $_POST['id'] .
			"&direccion=" . $_POST['direccion'] .
			"&lat=" . $_POST['lat']  .
			"&lon=" . $_POST['lon'] . 
			"&res=" . $res);
	die();
}
