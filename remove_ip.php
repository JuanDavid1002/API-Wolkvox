<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Eliminar IP</title>
	<!-- Vincula el archivo CSS global -->
	<link rel="stylesheet" type="text/css" href="css/style2.css">
</head>

<body>
	<div class="form-container">
		<?php
		$ip = $_POST['ip'];

		$params = [
			"ip" => $ip
		];

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://wv0068.wolkvox.com/api/v2/configuration.php?api=remove_ip',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'DELETE',
			CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HTTPHEADER => [
				'wolkvox-token: 7b69645f6469737472697d2d3230323430353135313133353335',
				'Content-Type: application/json'
			],
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$data = json_decode($response, true);
		$code = $data['code'];

		switch ($code) {
			case "202":
				echo "<h2>Eliminación Exitosa</h2>";
				echo "<p>La IP <strong>" . htmlspecialchars($ip) . "</strong> fue eliminada correctamente.</p>";
				break;
			case "404":
				echo "<h2>¡Error!</h2>";
				echo "<p>La IP <strong>" . htmlspecialchars($ip) . "</strong> no se encuentra registrada en Wolkvox. Por favor, registrela primero.</p>";
				break;
			case "406":
				echo "<h2>¡Error!</h2>";
				echo "<p>La IP <strong>" . htmlspecialchars($ip) . "</strong> no es válida. Verifique los datos ingresados.</p>";
				break;
			default:
				echo "<h2>¡Error desconocido!</h2>";
				echo "<p>Ocurrió un problema al intentar eliminar la IP. Intente nuevamente más tarde.</p>";
				break;
		}
		?>
		<div class="text-center mt-3">
			<!-- Botón de regreso -->
			<a href="remove_ip.html" class="btn-link">Regresar</a>
		</div>
	</div>
</body>

</html>