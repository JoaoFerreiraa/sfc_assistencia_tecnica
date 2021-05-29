<?php
session_start();
require '_Class/Usuario.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

if ($objUsuario->getNivel() == 1) {
    header("Location:pages/administracao/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard | SFC</title>
</head>

<body>

    <?php
        $path ='';
        include './models/menu_pages.php';
    ?>

    </div>

    <div class="container">
        <div id="acoes">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-1">Bem vindo ao Shop Floor Control!</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <h2 class="text-muted">O que deseja fazer hoje?</h2>
            </div>
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-md-4">
                    <a href="pages/ver/folhasDeRosto.php">
                        <div class="btn btn-primary btn-block" style="font-size: 3rem !important; font-weight:300;">
                            Equipamentos
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-md-4">
                    <a href="pages/relatorios/dashboard.php">
                        <div class="btn btn-primary btn-block" style="font-size: 3rem !important; font-weight:300;">
                            Relatórios
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-md-4">
                    <a href="pages/administracao/dashboard.php">
                        <div class="btn btn-primary btn-block" style="font-size: 3rem !important; font-weight:300;">
                            Administração
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <footer style="position: relative;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="assets/js/jquery-3.5.1.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>