<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrar IP</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style2.css">
</head>

<body>
	<div class="form-container">
		<?php
		$nombre = $_POST['nombre'];
		$cedula = $_POST['cedula'];
		$descrip = $nombre . " " . $cedula;
		$ip = $_POST['ip'];

		$params = array(
			"ip" => $ip,
			"permanent" => 'no',
			"description" => $descrip
		);

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://wv0068.wolkvox.com/api/v2/configuration.php?api=add_ip',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HTTPHEADER => array(
				'wolkvox-token: 7b69645f6469737472697d2d3230323430353135313133353335',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$data = json_decode($response, true);
		$code = $data['code'];

		if ($code == "201") {
			echo "<h2>Registro Exitoso</h2>";
			echo "<p>La IP <strong>" . htmlspecialchars($ip) . "</strong> fue registrada correctamente</p>";
		} elseif ($code == "404") {
			echo "<h2>¡Error!</h2>";
			echo "<p>La IP <strong>" . htmlspecialchars($ip) . "</strong> ya fue registrada anteriormente en el sistema</p>";
		} elseif ($code == "406") {
			echo "<h2>¡Error!</h2>";
			echo "<p>La IP <strong>" . htmlspecialchars($ip) . "</strong> no es una IP válida. Por favor, verifique los datos ingresados</p>";
		} else {
			echo "<h2>¡Error desconocido!</h2>";
			echo "<p>Ocurrió un problema al intentar registrar la IP. Intente nuevamente más tarde.</p>";
		}
		?>
		<div class="text-center mt-3">
			<a href="/" class="btn-link">Regresar</a>
		</div>
	</div>
</body>

</html>