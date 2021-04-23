<?php
include_once 'database.php';
if(isset($_POST['save']))
{	 
	 $latitud = $_POST['lat'];
	 $longitud = $_POST['lon'];
	 $sql ="UPDATE inmuebles set latitud='" . $_POST['lat'] . "', longitud='" . $_POST['lon'] . "'";
	 if (mysqli_query($conn, $sql)) {
		echo "Registro actualizado!";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);

	 //header("Location: index.php");
die();
}
?>