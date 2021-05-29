<?php
session_start();
require '../../_Class/Usuario.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard | SFC</title>
</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>

    <div class="container">
        <div id="acoes">

            <center>
                <h1>Administração</h1>
            </center>
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col">
                    <a href="../criar/folhaDeRosto.php">
                        <div class="btn btn-primary btn-block" style="font-size: 2rem !important; font-weight:300;">
                            Criar Folha de Rosto
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="laudos.php">
                        <div class="btn btn-primary btn-block" style="font-size: 2rem !important; font-weight:300;">
                            Emitir laudos
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="visualizarMaquinas.php">
                        <div class="btn btn-primary btn-block" style="font-size: 2rem !important; font-weight:300;">
                            Visualizar Máquinas
                        </div>
                    </a>
                </div>
                <?php

                if ($objUsuario->getNivel() > 1) {
                    echo '<div class="col">
                    <a href="revisao.php">
                        <div class="btn btn-primary btn-block" style="font-size: 2rem !important; font-weight:300;">
                            Revisão de máquinas
                        </div>
                    </a>
                </div>';
                }

                ?>
            </div>
        </div>
    </div>
    <footer style="position: absolute;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="../../assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>