<?php
if (!isset($path)) {
    $path = '../../';
}

if (!isset($_SESSION))
    session_start();

require_once $path . '_Class/Usuario.php';
require_once $path . '_Class/FolhaDeRosto.php';
require_once $path . '_Class/TecnicoResponsavelFolha.php';
require_once $path . '_Class/Revisao.php';
require_once $path . '_Class/LaudoEmitido.php';

$objRevisao = new Revisao();

$objConexao = new Conexao();
$cmdSql = "SELECT * FROM logs WHERE log like '%Laudo emitido%' and logs.data BETWEEN ";
//montar o cmdSql para fazer o filtro

if (!empty($_GET['dataEntrada'])) :
    //data de entreda -> formato que virá -> 2021-03-17T10:54
    //explode em T
    //[0]21-03-17
    //[1] 10:54
    //dentro da variavel cmdSql atribui [0] [1]:00'
    $dataEntrada = explode('T', $_GET['dataEntrada']);

    $cmdSql .= "'" . $dataEntrada[0] . " " . $dataEntrada[1] . ":00' ";
endif;

if (!empty($_GET['dataSaida'])) :
    //data de entreda -> formato que virá -> 2021-03-17T10:54
    //explode em T
    //[0]21-03-17
    //[1] 10:54
    //dentro da variavel cmdSql atribui [0] [1]:00'
    $dataSaida = explode('T', $_GET['dataSaida']);

    $cmdSql .= "AND '" . $dataSaida[0] . " " . $dataSaida[1] . ":00' ";
endif;

$cmdSql .= " GROUP by codFolha";

$objFolhaDeRosto = new FolhaDeRosto();
$objUsuarioAux = new Usuario();


$logs = $objConexao->Consultar($cmdSql);
if ($logs !== false) {
    foreach ($logs as $log) {
        $objFolhaDeRosto->setCod($log['codFolha']);
        $folha = $objFolhaDeRosto->consultar_por_codigo();

        echo '
                    <tr class="">
                
                    <th scope="row">' . $folha['cod'] . '</th>
                    <td>' . $log['data'] . '</td>
                    <td>' . $folha['lancamento_almoxarife'] . '</td>
                    <td>' . $folha['nome_cliente'] . '</td>
                    <td>' . $folha['tipo_solicitacao'] . '</td>
                    <td>' . $folha['modelo'] . '</td>
                    <td>' . $folha['numero_serie'] . '</td>
                    <td>' . $folha['reincidencia'] . '</td>
                    <td>' . $folha['entrada_laboratorio'] . '</td>
                    <td>' . $folha['laudo_emitido'] . '</td>
                </tr>';
    }
}
