<?php
include('conexion.php');
$mensaje = '';
$listPer=$conexion->query("SELECT * FROM animales ORDER BY id_animal");

if(isset($_POST['insertar'])) {
    $cargar_imgAnt_animal = ($_FILES['imgAnt_animal']['tmp_name']);
    $imgAnt_animal = fopen($cargar_imgAnt_animal, 'rb');

    $cargar_imgPost_animal = ($_FILES['imgPost_animal']['tmp_name']);
    $imgPost_animal = fopen($cargar_imgPost_animal, 'rb');

    $nomEsp_animal = $_POST['nomEsp_animal'];
    $nomEng_animal = $_POST['nomEng_animal'];

    $cargar_audio_animal = ($_FILES['audio_animal']['tmp_name']);
    $audio_animal = fopen($cargar_audio_animal, 'rb');

    $pronunciacion_animal = $_POST['pronunciacion_animal'];

    $insertarAni = $conexion->prepare("INSERT INTO animales(imgAnt_animal,imgPost_animal,nomEsp_animal,nomEng_animal,audio_animal,pronunciacion_animal) VALUES(:imgAnt_animal,:imgPost_animal,:nomEsp_animal,:nomEng_animal,:audio_animal,:pronunciacion_animal)");

    $insertarAni->bindParam(':imgAnt_animal', $imgAnt_animal, PDO::PARAM_LOB);
    $insertarAni->bindParam(':imgPost_animal', $imgPost_animal, PDO::PARAM_LOB);
    $insertarAni->bindParam(':nomEsp_animal', $nomEsp_animal, PDO::PARAM_STR);
    $insertarAni->bindParam(':nomEng_animal', $nomEng_animal, PDO::PARAM_STR);
    $insertarAni->bindParam(':audio_animal', $audio_animal, PDO::PARAM_LOB);
    $insertarAni->bindParam(':pronunciacion_animal', $pronunciacion_animal, PDO::PARAM_STR);

    $insertarAni->execute();
    if($insertarAni) {
        $mensaje = "<div class='col-md-offset-4 col-md-4 alert-success text-center'>
        !ANIMAL AGREGADO CORRECTAMENTE! <a href='index.php'>VER AQUI</a></div>";
    } else {
        $mensaje = "<div class='col-md-offset-4 col-md-4 alert-sucess text-center'>
        !ANIMAL NO SE PUDO REGISTRAR!</div>";
    }
}
?>

<html lang="es">
    <head>
        <title>ANIMALES REGISTRO></title>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="stylesheet" href="boostrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/estilos.css">
        <link rel="stylesheet" href="style.css">
    </head>
	<body>
		<header>
			<div class="alert alert-info">
			<h3>Insertar/Mostrar</h3>
			</div>
		</header>
        <section>
		<?php echo $mensaje; ?>
		<table class="table">
			<tr class="bg-primary">
			<th>ID</th>
			<th>IMAGEN ANTERIOR</th>
			<th>IMAGEN POSTERIOR</th>
			<th>ESPAÑOL</th>
            <th>INGLES</th>
			<th>AUDIO</th>
            <th>PRONUNCIACION</th>
			</tr>
			<?php
                while ($perFila=$listPer->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
						<td>'.$perFila['id_animal'].'</td>
						<td><img src="data:image/png;base64, '.base64_encode($perFila['imgAnt_animal']).'"></td>
                        <td><img src="data:image/png;base64, '.base64_encode($perFila['imgPost_animal']).'"></td>
						<td>'.$perFila['nomEsp_animal'].'</td>
                        <td>'.$perFila['nomEng_animal'].'</td>
						<td><audio controls><source src="data:audio/mp3;base64,'.base64_encode($perFila['audio_animal']).'"></audio controls></td>
						<td>'.$perFila['pronunciacion_animal'].'</td>
					</tr>';
                }
                ?>
        </table>
                <form method="POST" enctype="multipart/form-data">
                    <table class="table">
                        <tr><th colspan="6" class="bg-primary text-center" >NUEVO ANIMAL</th></tr>
                        <tr class="bg-primary">
                        <th>IMAGEN ANTERIOR</th>
				        <th>IMAGEN POSTERIOR</th>
				        <th>ESPAÑOL</th>
                        <th>INGLES</th>
				        <th>AUDIO</th>
                        <th>PRONUNCIACION</th>
                        </tr>
                        <tr class="bg-info">
                        <td><input name="imgAnt_animal" type="file" class="form-control"></td>
                        <td><input name="imgPost_animal" type="file" class="form-control"></td>
                        <td><input name="nomEsp_animal" type="text" class="form-control" placeholder="Nombre Animal Español"></td>
                        <td><input name="nomEng_animal" type="text" class="form-control" placeholder="Nombre Animal Ingles"></td>
                        <td><input name="audio_animal" type="file" class="form-control"></td>
                        <td><input name="pronunciacion_animal" type="text" class="form-control" placeholder="Pronunciacion animal"></td>
                        <td><input name="insertar" type="submit" class="btn btn-success" value="Insertar Animal" ></td>
                        </tr>
                        </table>
                        <br>
                        <br>                       
                </form>
        </section>
    </body>
</html>