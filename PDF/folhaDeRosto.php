<?php
require_once '../_Class/FolhaDeRosto.php';
require_once '../_Class/TecnicoResponsavelFolha.php';
require_once '../_Class/Usuario.php';
require_once __DIR__ . '/vendor/autoload.php';

$objFolhaDeRosto = new FolhaDeRosto();
$objTecResponsavel = new TecnicoResponsavelFolha();
$objUsuario = new Usuario();

$objFolhaDeRosto->setCod($_GET['folha']);

$folha = $objFolhaDeRosto->consultar_por_codigo();
$objTecResponsavel->setCod_folha_de_rosto($objFolhaDeRosto->getCod());

$tec = $objTecResponsavel->consultaResponsaveis()[0][0];
if ($tec == false)
    $tec = $folha['tec_responsavel_old'];
else {
    $objUsuario->setCod($tec);
    $objUsuario->consulta_usuario_por_cod();
    $tec = $objUsuario->getNome();
}

$obs = $objFolhaDeRosto->getObservacao();
if(strlen($obs) < 5 )
$obs = "Sem observação";

$html = '
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
		*{
            
        }
	</style>
	<title>' . $objFolhaDeRosto->getNome_cliente() . '</title>
</head>

<body>
    <div style="position: absolute; padding:0; width:690px;">
        <div style="border: 1px solid black; padding: 7px; width: 200px;">
            <img src="../assets/img/logo.png" alt="logoCompaq" width="200">
        </div>
        <div style="font-size:12pt;font-family: Arial, Helvetica, sans-serif; color:white; background-color: grey; border: 1px solid black; padding: 7px;padding-left: 50px; padding-right: 10px; width: 400px; height:32px;position: absolute; margin-top: -46px;margin-left: 214px; font-size: 16pt;">
            Folha de Rosto - Assistência Técnica
        </div>
        <div style=" font-size:12pt; font-family: Arial, Helvetica, sans-serif;position: absolute;margin-top: 40px;">
            <p><strong>Nome do cliente:</strong> ' . $objFolhaDeRosto->getNome_cliente() . '</p>
            <p style="width:690px; position: absolute; margin-top: 30px;"><strong>Modelo:</strong> Presario ' . $objFolhaDeRosto->getModelo() . ' 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Part Number:</strong>' . $objFolhaDeRosto->getPart_number() . '
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Nº de Série:</strong>' . $objFolhaDeRosto->getNumero_serie() . '</p>
        </div>
        <div style="font-size:12pt; font-family: Arial, Helvetica, sans-serif;position: absolute;margin-top: 40px;">
            <p style="position: absolute; margin-top: 30px;"><strong>Tipo de Solicitação:</strong> ' . $objFolhaDeRosto->getTipo_solicitacao() . '</p>
            <p style="position: absolute; margin-top: 30px;"><strong>Reincidência:</strong> ' . $objFolhaDeRosto->getReincidencia() . '</p>
            <p style="position: absolute; margin-top: 30px;"><strong>Acompanha Fonte:</strong> ' . $objFolhaDeRosto->getAcompanha_fonte() . '</p>
        </div>
        <div style="font-size:12pt; font-family: Arial, Helvetica, sans-serif;position: absolute;margin-top: 40px;">
            <p style="position: absolute; margin-top: 30px;"><strong>Descrição Estética:</strong> ' . $objFolhaDeRosto->getDesc_estetica_equipamento() . '</p>
            <p style="position: absolute; margin-top: 30px;"><strong>Detalhes:</strong> ' . $obs . '</p>
        </div>
        <div style="font-size:12pt; font-family: Arial, Helvetica, sans-serif;position: absolute;margin-top: 40px; line-height: 25pt; padding-right: 30px;">
            <p style="position: absolute; margin-top: 30px;"><strong>Defeito Reclamado:</strong> ' . $objFolhaDeRosto->getDesc_defeito_reclamado() . '</p>
            <p style="position: absolute; margin-top: 30px;"><strong>Defeito Apresentado:</strong> ' . $objFolhaDeRosto->getDefeito_apresentado() . '</p>
            <p style="position: absolute; margin-top: 30px;"><strong>Serviços executado:</strong> ' . $objFolhaDeRosto->getServicos_executados() . '</p>
        </div>
        <div style="font-size:12pt; font-family: Arial, Helvetica, sans-serif;position: absolute;margin-top: 40px; padding-right: 30px;">
            <p style="position: absolute; margin-top: 30px;"><strong>Data de Entrada – Logistica:</strong> ' . $objFolhaDeRosto->getLancamento_almoxarife() . '</p>
            <p style="position: absolute; margin-top: 30px;"><strong>Data de Entrada – Assistência Técnica:</strong> ' . $objFolhaDeRosto->getEntrada_laboratorio() . '</p>
            <p style="position: absolute; margin-top: 30px;"><strong>Data de Saída – Assistência Técnica:</strong> ' . $objFolhaDeRosto->getLaudo_emitido() . '</p>
        </div>
        <div style="font-size:12pt; font-family: Arial, Helvetica, sans-serif;position: absolute;margin-top: 40px; padding-right: 30px;">
            <div style="right:80px;position: absolute; text-align: right;"><strong>Técnico responsável pelo reparo:</strong></div>
            <div style="position: absolute; text-align: right;"><span>'.$tec.'</span></div>
        </div>
    </div>
</body>

</html>';


$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output("Folha de Rosto - " . $objFolhaDeRosto->getNome_cliente(), "I");


//echo $html;
 // I - Abre no navegador
// F - Salva o arquivo no servido
// D - Salva o arquivo no computador do usuário