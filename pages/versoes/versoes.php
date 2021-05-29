<?php
session_start();
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}


$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

$str = file_get_contents('../../assets/data/data.json');
$json = json_decode($str, true);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">

    <!-- bootstrap -->
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- DATA TABLE -->
    <link rel="stylesheet" href="../../assets/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/datatable/css/buttons.dataTables.min.css">
    <title>Consultar Logs | SFC</title>

    <style>

    </style>
</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>

    </div>

    <div class="container">
        <div id="acoes">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-5 mb-5">
                        Logs
                    </h1>
                </div>
            </div>
            <div class="row w-100" id="cards">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col">Versão</th>
                            <th scope="col">Data</th>
                            <th scope="col">Log</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($json as $log) {
                            echo '<tr>
                                    <th scope="row">' . $log['v'] . '</th>
                                    <td>' . $log['data'] . '</td>
                                    <td>' . $log['log'] . '</td>
                                </tr>';
                        }
                        ?>

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
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                order: [
                    [0, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>