<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/LaudoEmitido.php';
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location:../../index.php");
}
$objUsuario = new Usuario();
$objfolhaDeRosto = new FolhaDeRosto();
$objLaudoEmitido = new LaudoEmitido();


$objfolhaDeRosto->setCod($_GET['folha']);
$objfolhaDeRosto->consultar_por_codigo();

$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

$modelo = $objfolhaDeRosto->getModelo();
$numero_serie = $objfolhaDeRosto->getNumero_serie();

$pecasTrocadas = $objfolhaDeRosto->getPecas_trocadas();

$objLaudoEmitido->setCod_folha($objfolhaDeRosto->getCod());
$laudo_emitido = $objLaudoEmitido->consultar_por_folha()[0];


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
	<title>Escolher saída | SFC</title>



	<script src="../../assets/js/jquery-3.5.1.js"></script>
	<script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<style>
		body {
			font-size: 12pt;
			font-family: Arial, Helvetica, sans-serif;
		}

		#row {
			width: 50%;
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
		}

		.message {
			width: 100%;
			padding: 2rem;
			border-radius: 10px;
			box-shadow: 0px 8px 27px 0px rgba(0, 0, 0, 0.1);
			font-size: 22pt;
			margin-bottom: 2rem;
			color: #155624;
			transition: 0.3s;
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

		.etiqueta {
			width: 100%;
			padding: 1rem;
			border-radius: 10px;
			box-shadow: 0px 8px 27px 0px rgba(0, 0, 0, 0.1);
			font-size: 28pt;
			transition: 0.3s;
			margin-bottom: -2rem;

		}
	</style>
</head>

<body>
	<?php
	include '../../models/menu_pages.php';
	?>

	<section>
		<div class="container">
			<div class="row mt-3 mb-1 d-flex justify-content-center">
				<div class="col-12 etiqueta d-flex justify-content-between flex-column">

					<div style=" font-size:12pt; font-family: Arial, Helvetica, sans-serif;">
						<p><strong>Nome do cliente:</strong> <?=$objfolhaDeRosto->getNome_cliente()?></p>
						<p style="width:690px; margin-top: 30px;"><strong>Modelo:</strong> Presario <?=$objfolhaDeRosto->getModelo()?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<strong>Part Number:</strong><?=$objfolhaDeRosto->getPart_number()?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<strong>Nº de Série:</strong><?=$objfolhaDeRosto->getNumero_serie()?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container d-flex justify-content-center">

			<div class="row mt-5 d-flex justify-content-center flex-column" id="row">

				<?php
				if (isset($_GET['mensagem']) && $_GET['mensagem'] == "sucesso") {
					echo '<div class="col message bg-success">
						Informações salvas com sucesso!
					</div>';
				}
				?>
				</a>
				<a href="../../PDF/gerar_pdf.php?data=<?= $laudo_emitido['data'] ?>&numeroSerie=<?= $laudo_emitido['serial_number'] ?>&modelo=<?= $laudo_emitido['modelo_maquina'] ?>&pecas=<?= $laudo_emitido['pecas_trocadas'] ?>" target="_blank">
					<div class="col option d-flex justify-content-between align-items-center">
						<span>Laudo</span>
						<i class="icon-go"></i>
					</div>
				</a>
				<a href="../../PDF/folhaDeRosto.php?folha=<?= $_GET['folha'] ?>" target="_blank">
					<div class="col option d-flex justify-content-between align-items-center">
						<span>Folha de rosto</span>
						<i class="icon-go"></i>
					</div>
				</a>
				<a href="imprimirEtiqueta.php?folha=<?= $_GET['folha'] ?>">
					<div class="col option d-flex justify-content-between align-items-center">
						<span>Imprimir Etiqueta</span>
						<i class="icon-go"></i>
					</div>
				</a>
			</div>
		</div>
	</section>
</body>

</html>