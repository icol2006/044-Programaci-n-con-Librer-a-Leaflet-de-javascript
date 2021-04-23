<?php
include_once 'database.php';
if(isset($_POST['save']))
{	 
	 $latitud = $_POST['lat'];
	 $longitud = $_POST['lon'];
	 $sql = "INSERT INTO tb_puntos_gps (latitud,longitud)
	 VALUES ('$latitud','$longitud')";
	 if (mysqli_query($conn, $sql)) {
		echo "New record created successfully !";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);

	 header("Location: index.html");
die();
}
?>