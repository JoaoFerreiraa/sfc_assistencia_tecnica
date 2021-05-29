<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="assets/css/login.css">
    <title>Entrar | SFC</title>
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
                <input type="text" id="login" class="fadeIn second" name="usuario" placeholder="Usuario">
                <input type="password" id="password" class="fadeIn third" name="senha" placeholder="Senha">
                <input type="button" class="fadeIn fourth" name="btnEntrar" value="Entrar">
                <br>
                <a href="visualizacaoGeral.php" class="btn btn-primary text-light mb-5">Pesquisar rápida</a>
            </form>

            <div class="m-2 alert alert-danger d-none" role="alert" id="message">
                <!-- mensagem de erro -->
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("input[name='btnEntrar']").click(function() {
                dados = {
                    usuario: $("input[name='usuario']").val(),
                    senha: $("input[name='senha']").val()
                }
                if ($("input[name='usuario']").val() != "") {
                    $.post("_functionsPHP/usuario/logar.php", dados, function(retorno) {
                        if (retorno == '1') {
                            window.location.href = "dashboard.php";
                        } else {
                            $("#message").html("Usuario ou senhas nao conferem! Acione o administrador.");
                            $("#message").removeClass("d-none");
                            setTimeout(function() {
                                $("#message").addClass("d-none");
                            }, 3 * 1000)
                        }

                    });
                } else {
                    alert("Preencha todos os campos corretamente, por favor.");
                }
            })
        })
    </script>
</body>

</html>