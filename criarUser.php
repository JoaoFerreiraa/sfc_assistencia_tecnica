<?php
require '_Class/Usuario.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

if ($objUsuario->getNivel() < 4) {
    header("Location:dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="assets/css/login.css">
    <title>Criar Usuario | SFC</title>
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
                <h1 class="mt-5 text-danger">SFC</h1>
            </div>

            <!-- Login Form -->
            <form autocomplete="off">
                <input type="text" id="login" class="fadeIn second" name="nome" placeholder="Nome do usuário">
                <input type="text" id="login" class="fadeIn second" name="cargo" placeholder="Cargo do usuário">
                <div id="login" class="fadeIn second mt-1">
                    <label for="nivel">Nivel</label>
                    <select name="nivel" id="nivel">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                <input type="submit" class="fadeIn fourth" name="btnCriar" value="Criar">
            </form>

            <div class="m-2 alert alert-danger d-none" role="alert" id="message">
                <!-- mensagem de erro -->
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <?php

    if (isset($_GET['btnCriar'])) {
        $objUsuario->setNome($_GET['nome']);
        $objUsuario->setFuncao($_GET['cargo']);
        $objUsuario->setNivel($_GET['nivel']);
        $objUsuario->setSenha("sfc2020");
        // $objUsuario->setUsuario($_GET['usuario']);
        // $objUsuario->consulta_usuario_por_usuario();

        var_dump($objUsuario->criar());

        var_dump($objUsuario->getUsuario());
    }
    ?>

</body>

</html>