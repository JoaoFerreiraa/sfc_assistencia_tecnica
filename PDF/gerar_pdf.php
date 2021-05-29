<?php

require_once __DIR__ . '/vendor/autoload.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$dataSistema = date('Y/m/d');
// $data = explode("/", $data);


if (isset($_GET['data'])) {
	//pega data da url e transforma de Y/m/d para Y-m-d para mostrar no laudo
	$dataUrl = explode(" ",$_GET['data']);
	$dataUrl = date("Y-m-d", strtotime($dataUrl[0]));

	$msgData = "Sorocaba, " . strftime('%d de %B de %Y', strtotime($dataUrl));

} else {
	$msgData = "Sorocaba, " . strftime('%d de %B de %Y', strtotime($dataSistema));
}

$html = '
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
		body{
			font-size: 12pt;
			font-family: Arial, Helvetica, sans-serif;
		}
		p{
			margin-left:50px;
			margin-right:50px;
		}
		.footer{
			position: absolute;
			bottom: 0;
			text-align: center;
			margin-right: 50px;
		}
		.agradecimentos{
			font-size: 9.5pt;
			width: 100vw;
			position: fixed;
			
		}
		.agradecimentos small{
			position: fixed;
			top: 0;
			width: 210px;
			right: 0;

		}
		.agradecimentos img{
			position: fixed;
			top: 0;
			right: 0;

		}
	</style>
	<title>' . $_GET['numeroSerie'] . ' - ' . $_GET['modelo'] . '</title>
</head>

<body>
	<p>' . $msgData . '</p>
	<p>Após análise realizada no notebook <strong>' . $_GET['modelo'] . '</strong> de Número de Série: <strong>' . $_GET['numeroSerie'] . '</strong>, evidenciamos que:</p>
	<p>' . nl2br($_GET['pecas']) . '</p>
	<p>Todos os testes acima foram 100% aprovados conforme resultado abaixo.</p>
	<p style="text-align: center;"><img src="img.png" height="325" alt=""></p>
	<p style="margin-left: 110px;">Resultado dos testes executados:</p>
	<p style="margin-left: 90px;margin-top: 55px;margin-bottom: 120px;"><img src="logo.png" height="55" alt=""></p>
	<p>Sendo assim, esperamos que possa desfrutar desta unidade <strong>' . $_GET['modelo'] . '</strong></p>

	<div class="footer">
		<div class="agradecimentos">
			<columns column-count="n" vAlign="justify" column-gap="n" />
			<div style="position: absolute; bottom: 26mm; right: 34mm;width: 150px; font-size: 9.5pt; font-family: Arial, Helvetica, sans-serif;">
					<small style="">Atenciosamente, Centro de Reparo Compaq</small>
			</div>
			<div style="position: absolute; bottom: 5mm; right: 5mm;">
				<img src="logo small.png" alt="" height="60">
			</div>
			
		</div>
	</div>
</body>

</html>';

$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();


//echo $html;
 // I - Abre no navegador
// F - Salva o arquivo no servido
// D - Salva o arquivo no computador do usuário