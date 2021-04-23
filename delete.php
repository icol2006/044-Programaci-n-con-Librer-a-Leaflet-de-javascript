<?php
include_once 'database.php';
$sql = "DELETE FROM tb_puntos_gps WHERE id='" . $_GET["id"] . "'";
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
header("Location: list.php");
?>
