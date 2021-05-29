<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location:../../index.php");
}
$objUsuario = new Usuario();
$objFolhaDeRosto = new FolhaDeRosto();


$objFolhaDeRosto->setCod($_GET['folha']);
$folha = $objFolhaDeRosto->consultar_por_codigo();

$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();


$nome = $objFolhaDeRosto->getNome_cliente();
$nomeLimitado = substr($nome, 0, 38);

//separa as palavras por espaço
$nomeSemFormatacao = preg_split("/[\s,]+/", $nome);

$nome1 = "";
$nome2 = "";
//percorre toda a array do nomeSemFormatacao e adiciona ao nome1 e nome2
foreach ($nomeSemFormatacao as $nome) {
	if (strlen($nome1) < 45 && (strlen($nome1) + strlen($nome)) < 45) $nome1 .= $nome . " ";
	else if (strlen($nome2) < 48 && (strlen($nome2) + strlen($nome)) < 48) $nome2 .= $nome . " ";
}
if(empty($nome1)) $nome1 = $nomeLimitado;

$etiqueta = "^XA^FX TEXTO.^CFA,10^FO220,25^ADN,18,10^FD" . $nomeLimitado . "^FS^FX TEXTO.^BY1,2,50^FO220,50^BC^FD" . $nomeLimitado . "^FS^FX CÓDIGO DE BARRAS.^BY2,2,50^FO220,150^BC^FD" . $objFolhaDeRosto->getNumero_serie() . "^FS^FO220,250^BC^FD" . $objFolhaDeRosto->getPart_number() . "^FS^FX TEXTO.^CFA,10^FO220,360^ADN,18,10^FDNome completo^FS^FO220,400^ADN,18,10^FD" . $nome1 . "^FS^FO220,420^ADN,18,10^FD" . $nome2 . "^FS^XZ";

//laudo -> consultar por laudo e passar as informações por url
//folha de rosto -> passar só a folha por url
//etiqueta -> passar só a folha por url
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<title>Imprimir etiqueta | SFC</title>



	<script src="../../assets/js/jquery-3.5.1.js"></script>
	<script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="../../assets/js/BrowserPrint-3.0.216.min.js"></script>

	<style>
		@font-face {
			font-family: barcode;
			src: url('../../assets/fonts/BarcodeFont.ttf');
		}

		body {
			font-size: 12pt;
			font-family: Arial, Helvetica, sans-serif;
		}

		.row {
			width: 70%;
		}

		a {
			text-decoration: none !important;
		}

		.option {
			width: 100%;
			padding: 2rem;
			border-radius: 10px;
			box-shadow: 0px 8px 27px 0px rgba(0, 0, 0, 0.1);
			font-size: 28pt;
			color: var(--primary);
			margin-bottom: 2rem;
			transition: 0.3s;
			cursor: pointer;
		}

		.option:hover {
			background: var(--primary);
			color: white;
		}

		.option:hover .icon-go {
			background-color: white;
		}

		.icon-go {
			-webkit-mask-size: cover;
			mask-size: cover;
			transition: 0.3s;

			background: var(--primary);

			-webkit-mask-image: url('../../assets/svg/Arrow.svg');
			mask-image: url('../../assets/svg/Arrow.svg');
			width: 88px;
			height: 54px;
			zoom: 0.5;
		}

		#impressora_Status {
			position: absolute;
			bottom: 0;
		}

		select {
			width: 100%;
			padding: 2rem;
			border-radius: 10px;
			box-shadow: 0px 8px 27px 0px rgba(0, 0, 0, 0.1);
			font-size: 28pt;
			color: var(--primary);
			margin-bottom: 2rem;
			transition: 0.3s;
			border: none;
		}

		.etiqueta {
			width: 100%;
			padding: 1rem;
			border-radius: 10px;
			box-shadow: 0px 8px 27px 0px rgba(0, 0, 0, 0.1);
			font-size: 28pt;
			margin-bottom: 2rem;
			transition: 0.3s;
		}

		.etiqueta h1 {
			font-size: 48pt;
		}

		.barcode {
			font-family: barcode !important;
			margin-bottom: 1rem;
		}
	</style>
</head>

<body>
	<?php
	include '../../models/menu_pages.php';
	?>

	<section>
		<div class="container d-flex justify-content-center">
			<!-- titulo para folha de rosto -->
			<div class="row mt-5 d-flex justify-content-center flex-column">
				<div class="row w-100 mb-3">
					<div class="col-4">
						<img src="../../assets/img/printer.png" width="150">
						<img src="../../assets/img/multiply.png" id="impressora_Status" width="50">
					</div>
					<div class="col">
						<select id="selected_device" onchange=onDeviceSelected(this);></select> <!--  <input type="button" value="Change" onclick="changeDevice();">--> <br /><br />
					</div>
				</div>

				<div class="row w-100 mb-1 d-flex justify-content-center">
					<div class="col-7 etiqueta d-flex justify-content-between flex-column">
						<h5 class="font-normal"><?= $nomeLimitado ?></h5>
						<h1 class="barcode"><?= $nomeLimitado ?></h1>
						<h1 class="barcode"><?= $objFolhaDeRosto->getNumero_serie() ?></h1>
						<h1 class="barcode"><?= $objFolhaDeRosto->getPart_number() ?></h1>
						<h5>Nome Completo:</h5>
						<!-- ----------------------- FAZER SISTEMA QUE QUEBRA O NOME -------------------------- -->
						<h5><?= $nome1 ?></h5>
						<h5><?= $nome2 ?></h5>
					</div>
				</div>

				<div class="row w-100 mb-1 d-flex justify-content-center">
					
					<div class="col-10 option d-flex justify-content-between align-items-center" onclick="writeToSelectedPrinter(<?php echo "'".$etiqueta."'" ?>)" >
						<span>Imprimir Etiqueta</span>
						<i class="icon-go"></i>
					</div>
				</div>

				<!-- <input type="button" value="Get Application Configuration" onclick="getConfig()"><br /><br />
				<input type="button" value="Send Config Label" onclick="writeToSelectedPrinter('~wc')"><br /><br />
				<input type="button" value="Send ZPL Label" onclick="writeToSelectedPrinter('^XA^FO200,200^A0N36,36^FDTest Label^FS^XZ')"><br /><br />
				<input type="button" value="Get Status" onclick="writeToSelectedPrinter('~hs'); readFromSelectedPrinter()"><br /><br />
				<input type="button" value="Get Local Devices" onclick="BrowserPrint.getLocalDevices(getDeviceCallback, errorCallback);"><br /><br />
				<input type="text" name="write_text" id="write_text"><input type="button" value="Write" onclick="writeToSelectedPrinter(document.getElementById('write_text').value)"><br /><br />
				<input type="button" value="Read" onclick="readFromSelectedPrinter()"><br /><br />
				<input type="button" value="Send BMP" onclick="sendImage('Zebra_logobox.bmp');"><br /><br />
				<input type="button" value="Send JPG" onclick="sendImage('ZebraGray.jpg');"><br /><br />
				<input type="button" value="Send File" onclick="sendFile('wc.zpl');"><br /><br /> -->
			</div>
		</div>
	</section>
	<script src="../../assets/js/jquery-3.5.1.js"></script>
	<script type="text/javascript">
		var selected_device;
		var devices = [];

		function setup() {
			//Get the default device from the application as a first step. Discovery takes longer to complete.
			BrowserPrint.getDefaultDevice("printer", function(device) {

				//Add device to list of devices and to html select element
				selected_device = device;
				devices.push(device);
				var html_select = document.getElementById("selected_device");
				var option = document.createElement("option");
				option.text = device.name;
				html_select.add(option);

				//----------------------------- ACIMA, É O MOMENTO EM QUE PEGA O DISPOSITIVO PADRAO -----------------------------

				if (device.name !== undefined) {
					$("#impressora_Status").attr("src", "../../assets/img/check.png");
				}

				//Discover any other devices available to the application
				BrowserPrint.getLocalDevices(function(device_list) {
					for (var i = 0; i < device_list.length; i++) {
						//Add device to list of devices and to html select element
						var device = device_list[i];
						if (!selected_device || device.uid != selected_device.uid) {
							devices.push(device);
							var option = document.createElement("option");
							option.text = device.name;
							option.value = device.uid;
							html_select.add(option);
						}
					}

				}, function() {
					alert("Error getting local devices")
				}, "printer");

			}, function(error) {
				alert(error);
			})
		}

		function getConfig() {
			BrowserPrint.getApplicationConfiguration(function(config) {
				alert(JSON.stringify(config))
			}, function(error) {
				alert(JSON.stringify(new BrowserPrint.ApplicationConfiguration()));
			})
		}

		function writeToSelectedPrinter(dataToWrite) {
			selected_device.send(dataToWrite, undefined, errorCallback);
		}
		var readCallback = function(readData) {
			if (readData === undefined || readData === null || readData === "") {
				alert("No Response from Device");
			} else {
				alert(readData);
			}

		}
		var errorCallback = function(errorMessage) {
			alert("Error: " + errorMessage);
		}

		function readFromSelectedPrinter() {

			selected_device.read(readCallback, errorCallback);

		}

		function getDeviceCallback(deviceList) {
			alert("Devices: \n" + JSON.stringify(deviceList, null, 4))
		}

		function sendImage(imageUrl) {
			url = window.location.href.substring(0, window.location.href.lastIndexOf("/"));
			url = url + "/" + imageUrl;
			selected_device.convertAndSendFile(url, undefined, errorCallback)
		}

		function sendFile(fileUrl) {
			url = window.location.href.substring(0, window.location.href.lastIndexOf("/"));
			url = url + "/" + fileUrl;
			selected_device.sendFile(url, undefined, errorCallback)
		}

		function onDeviceSelected(selected) {
			if (selected.value !== "undefined") {
				$("#impressora_Status").attr("src", "../../assets/img/check.png");
			} else {
				$("#impressora_Status").attr("src", "../../assets/img/multiply.png");
			}
			for (var i = 0; i < devices.length; ++i) {
				if (selected.value == devices[i].uid) {
					selected_device = devices[i];
					return;
				}
			}
		}
		window.onload = setup;
	</script>
</body>

</html>