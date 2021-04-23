<html>

<head>
    <title>Mapa</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</head>

<?php
include_once 'database.php';
$result = mysqli_query($conn, "SELECT * FROM tb_puntos_gps");
?>

<body>
    <div class="container body-content">
        <br>
        <h3>Listado de datos</h3>
        <a href="index.html" class="float-right mb-4" >Nuevo registro</a>

        <br>
        <?php
        if (mysqli_num_rows($result) > 0) {
        ?>
            <table class="table">

                <tr>
                    <td>Id</td>
                    <td>Latitud</td>
                    <td>Longitud</td>
                    <td></td>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["latitud"]; ?></td>
                        <td><?php echo $row["longitud"]; ?></td>
                        <td><a href="delete.php?id=<?php echo $row["id"]; ?>">Eliminar</a></td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </table>
        <?php
        } else {
            echo "No hay registros";
        }
        ?>
    </div>
</body>

</html>