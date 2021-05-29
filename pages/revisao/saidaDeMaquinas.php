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


if ($objUsuario->getNivel() < 2) {
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
    <title>Saída de Máquinas | SFC</title>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>


    <div class="container d-flex justify-content-center">
        <div id="acoes">

            <div class="row style d-flex justify-content-start align-items-start text-center" id="cards">
                <div class="filtros">
                    <form class="w-100 pb-3" autocomplete="off" id="filtro" onsubmit="event.preventDefault()">
                        <div class="form-group">
                            <small>Data de entrada:</small>
                            <input class="form-control" type="datetime-local" name="dataEntrada">
                        </div>
                        <div class="form-group">
                            <small>Data de saída:</small>
                            <input class="form-control" type="datetime-local" name="dataSaida">
                        </div>
                        <button type="submit" onclick="getDadosForm()" class="btn btn-primary">Procurar</button>
                    </form>
                </div>
                <div class="corpo p-2">
                    <table class="table" id="tableSearch">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Laudo emitido</th>
                                <th scope="col">Data entrada</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Tipo Solicitação</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Nº Série</th>
                                <th scope="col">Reincidência</th>
                                <th scope="col">Data inicio de reparo</th>
                                <th scope="col">Data Saida</th>
                            </tr>
                        </thead>
                        <tbody id="tbodySearch">

                            <?php
                            $cargo = 'EmitirLaudo';
                            include '../../_functionsPHP/pesquisa/pesquisarPeloLog.php';
                            ?>

                        </tbody>
                    </table>
                </div>
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
    <script>
        let dadosForm = null;
        $('#tableSearch').DataTable({
            order: [0, 'desc'],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });


        //funcao para pegar os dados do formulario
        function getDadosForm() {
            dadosForm = {
                dataEntrada: $('input[name="dataEntrada"]').val(),
                dataSaida: $('input[name="dataSaida"]').val(),
                cargo: 'saidaDeMaquinas'
            }
            pesquisar(dadosForm);

        }

        function pesquisar(data) {
            $('#tableSearch').DataTable().clear().destroy();
            $.get("../../_functionsPHP/pesquisa/pesquisarPeloLog.php", data, function(retorno) {
                $("#tbodySearch").html(retorno);
                $('#tableSearch').DataTable({
                    order: [0, 'desc'],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            })
        }

        // datatableLogs.clear();
        // datatableLogs.rows.add(retorno);
        // datatableLogs.draw();
    </script>
</body>

</html>