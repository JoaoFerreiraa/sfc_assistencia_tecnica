<?php
session_start();
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
require '../../_Class/Revisao.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}


$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();


if ($objUsuario->getNivel() < 3) {
    header("Location:../../dashboard.php");
}
$objConexao = new Conexao();


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- DATA TABLE -->
    <link rel="stylesheet" href="../../assets/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/datatable/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Administração de Máquinas | SFC</title>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>


    <div class="container d-flex justify-content-center">
        <div id="acoes">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-5 pb-5">
                        Administração de máquinas
                    </h1>
                </div>
            </div>

            <div class="row style d-flex justify-content-center align-items-center text-center" id="cards">
                <form class="w-100 pb-3" autocomplete="off">
                    <div class="form-group">
                        <label for="numeroSerie">Numero de série: </label>
                        <input class="form-control" type="text" name="numeroSerie" id="numeroSerie">
                    </div>
                    <button type="submit" class="btn btn-primary">Procurar</button>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Téc Responsável</th>
                            <th scope="col">Ultimo log</th>
                            <th scope="col">Voltar para:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            if (isset($_GET['numeroSerie']) && !empty($_GET['numeroSerie'])) {
                                $objFolhaDeRosto = new FolhaDeRosto();
                                $objTecResponsavel = new TecnicoResponsavelFolha();
                                $objUsuarioConsulta = new Usuario();
                                $objRevisao = new Revisao();


                                $objFolhaDeRosto->setNumero_serie($_GET['numeroSerie']);
                                $dadosFolha = $objFolhaDeRosto->consultar_por_serial();

                                $cmdSql = "CALL logs_consultarPorFolhaUltimo(" . $objFolhaDeRosto->getCod() . ")";


                                $ultimoLog = $objConexao->Consultar($cmdSql)[0];
                                $ultimoLog = $ultimoLog['usuario'] . " -> " . $ultimoLog['log'];

                                $objTecResponsavel->setCod_folha_de_rosto((int) $objFolhaDeRosto->getCod());
                                $dadosTecnicoResponsavel = $objTecResponsavel->consultaResponsaveis();

                                $objUsuarioConsulta->setCod($dadosTecnicoResponsavel[0]['tec_responsavel']);
                                $objUsuarioConsulta->consulta_usuario_por_cod();

                                $objRevisao->setCod_folha($objFolhaDeRosto->getCod());
                                $dadosRevisao = $objRevisao->consultar_porCodFolha()[0];

                                if ($dadosFolha) {
                                    if (empty($objUsuarioConsulta->getNome())) {
                                        $objUsuarioConsulta->setNome("Nenhum técnico se responsabilizou pela folha");
                                        $msgAcoes = "Nenhuma ação disponível";
                                    } else {
                                        if ($dadosRevisao) {
                                            $msgAcoes = "
                                            <a class='badge badge-danger' href='../../_functionsPHP/Revisao/revisao_admin.php?status=2&revisao=" . $dadosRevisao['cod'] . "&codFolha=" . $dadosRevisao['cod_folha'] . "'>Técnico</a>
                                            | 
                                            <a class='badge badge-danger' href='../../_functionsPHP/Revisao/revisao_admin.php?status=1&revisao=" . $dadosRevisao['cod'] . "&codFolha=" . $dadosRevisao['cod_folha'] . "'>Revisão</a>";
                                        } else
                                            $msgAcoes = "A folha ainda não passou pela revisão";
                                    }

                                    echo '<th scope="row">' . $objFolhaDeRosto->getCod() . '</th>
                                    <td>' . $objFolhaDeRosto->getNome_cliente() . '</td>
                                    <td>' . $objUsuarioConsulta->getNome() . '</td>
                                    <td>' . $ultimoLog . '</td>
                                    <td>
                                        ' . $msgAcoes . '
                                    </td>';
                                } else {
                                    echo '<th scope="row">#</th>
                                    <td>Não foi possivel encontrar essa máquina</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>';
                                }
                            }
                            ?>
                            <a href="../../_functionsPHP/Revisao/revisao_admin.php?status=2&revisao=    &codFolha=   "></a>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <footer style="position: relative;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="../../assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../../assets/datatable/js/buttons.flash.min.js"></script>
    <script src="../../assets/datatable/js/jszip.min.js"></script>
    <script src="../../assets/datatable/js/pdfmake.min.js"></script>
    <script src="../../assets/datatable/js/vfs_fonts.js"></script>
    <script src="../../assets/datatable/js/buttons.html5.min.js"></script>
    <script src="../../assets/datatable/js/buttons.print.min.js"></script>
</body>

</html>