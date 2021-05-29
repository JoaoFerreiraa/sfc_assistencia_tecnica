<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.4">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Criar Folha de Rosto | SFC</title>



    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php'?>

    <!-- form para a folha de rosto -->

    <section>
        <div class="container">
            <!-- titulo para folha de rosto -->
            <div class="row">
                <div class="col-12">
                    <div class="row mt-2">
                        <div class="col-3">
                            <img src="../../assets/img/logo.png" alt="" width="150px">
                        </div>
                        <div class="col-9">
                            <h1 class=" text-muted">Assistencia Técnica | Folha de rosto</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-5">
                <?php
                if ($objUsuario->getNivel() > 1) {
                    echo '
                <div class="col">
                    <a href="administrativo.php?folha=' . $_GET['folha'] . '" class="btn btn-primary btn-block btn-lg">Inteira</a>
                </div>
                <div class="col">
                    <a href="at.php?folha=' . $_GET['folha'] . '" class="btn btn-primary btn-block btn-lg">Processos A.T.</a>
                </div>';
                } else {
                    echo '<div class="col">
                            <a href="administrativo.php?folha=' . $_GET['folha'] . '" class="btn btn-primary btn-block btn-lg">Administrativo</a>
                        </div>';
                }

                ?>
            </div>
        </div>
    </section>
</body>

</html>