<?php
require '../_Class/Usuario.php';
require '../_Class/FolhaDeRosto.php';
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location:../index.php");
}
$objUsuario = new Usuario();
$objfolhaDeRosto = new FolhaDeRosto();


$objfolhaDeRosto->setCod($_GET['folha']);
$objfolhaDeRosto->consultar_por_codigo();

$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

$modelo = $objfolhaDeRosto->getModelo();
$numero_serie = $objfolhaDeRosto->getNumero_serie();

$pecasTrocadas = $objfolhaDeRosto->getPecas_trocadas();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<title>Emissao de Laudo | SFC</title>



	<script src="../assets/js/jquery-3.5.1.js"></script>
	<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<style>
		@media (max-width: 1700px) {
			.container {
				margin-right: 0 !important;
			}
		}
	</style>
	<style>
		body {
			font-size: 12pt;
			font-family: Arial, Helvetica, sans-serif;
		}

		p {
			margin-left: 50px;
			margin-right: 50px;
		}

		.footer_1 {
			text-align: center;
			margin-right: 50px;
		}

		.agradecimentos {
			font-size: 9.5pt;

		}
	</style>
</head>

<body>
	<?php
		include '../models/menu_pages.php';
	?>

	<!-- form para a folha de rosto -->

	<section>
		<div class="container">
			<!-- titulo para folha de rosto -->
			<div class="row">
				<div class="col-12">
					<div class="row mt-2">
						<div class="col-3">
							<img src="../assets/img/logo.png" alt="" width="150px">
						</div>
						<div class="col-9">
							<h1 class=" text-muted">Assistencia Técnica | Emissão de Laudo</h1>
						</div>
					</div>
				</div>
			</div>
			<!-- corpo para folha de rosto -->
			<div class="row mt-5">
				<div class="col-11">
					<form>
						<input type="text" name='tecEmissor' disabled value="<?php echo $_SESSION['usuario']['cod'] ?>">
						<p>...</p>
						<p>Após análise realizada no notebook <strong><input type="text" id="modelo" name="modelo" value="COMPAQ Presario <?php echo $modelo ?>"></strong> de Número de Série: <strong><input type="text" name="numeroSerie" readonly value="<?php echo $numero_serie ?>"></strong>, evidenciamos que:</p>
						<textarea class="ml-5" name="pecas" id="" cols="90" rows="5">Na unidade em questão constava uma característica funcional indevida no <?= $pecasTrocadas ?> sendo necessário sua troca.
Após substituição da peça defeituosa, conforme a imagem abaixo o equipamento foi testado durante 5h executando: “loops” de teste de CPU, FPU, HD, Memória, Gráficos 2D e 3D, incluindo testes funcionais como portas USB, HDMI, Leitor de cartão SD, Teclado e Touchpad.</textarea>
						<p>Todos os testes acima foram 100% aprovados conforme resultado abaixo.</p>
						<p style="text-align: center;"><img src="img.png" height="325" alt=""></p>
						<p style="margin-left: 110px;">Resultado dos testes executados:</p>
						<p style="margin-left: 90px;margin-top: 55px;margin-bottom: 120px;"><img src="logo.png" height="55" alt=""></p>
						<p>Sendo assim, esperamos que possa desfrutar desta unidade <strong><input type="text" id="modelo2" name="modelo2" readonly value="COMPAQ Presario <?php echo $modelo ?>"></strong></p>



						<input class="btn btn-danger btn-block btn-lg mt-5 mb-5" type="button" value="Gerar Laudo">
					</form>
				</div>
			</div>

		</div>
	</section>
	<script>
		$("input[type='button']").click(function() {

			//RECUPERAR OS DADOS DO FORMULARIO
			var dadosEnviados = {
				pecasTrocadas: $("textarea[name='pecas']").val(),
				serialNumber: $("input[name='numeroSerie']").val(),
				tecEmissor: $("input[name='tecEmissor']").val(),
				modelo: $("input[name='modelo']").val(),
				folha: "<?php echo $objfolhaDeRosto->getCod() ?>"
			};



			//ENVIAR UM GET PARA CADASTRAR O LAUDO EMITIDO
			$.get("../_functionsPHP/laudos/cadastrarLaudo.php", dadosEnviados, function(retorno) {
				if (retorno == 1) {
					//ABRE A JANELDA DA FOLHA DE ROSTO
					// window.open('./folhaDeRosto.php?folha=<?= $_GET['folha'] ?>', '_blank');
					//ABRE A JANELDA DOS DADOS DE ETIQUETA
					// window.open('./etiqueta.php?folha=<?= $_GET['folha'] ?>', "Etiqueta", "width=800,height=600,directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,resizable=yes")
					window.location.href = '../pages/saida/escolher.php?folha=<?= $_GET['folha']?>&mensagem=sucesso';
				} else {
					alert(retorno);
				}
			})
			//SE FOR CADASTRADO, AI REDIRECIONA A PAGINA E GERA O LAUDO
		})



		$("#modelo").keydown(() => {
			setTimeout(() => {
				$("#modelo2").val($("#modelo").val());
			}, 200);
		})
	</script>
</body>

</html>