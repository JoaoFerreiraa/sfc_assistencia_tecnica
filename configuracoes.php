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
    <title>Configuracões | SFC</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">SFC | </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Assistencia Técnica
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="pages/ver/folhasDeRosto.php">Folhas de rosto</a>
                        <a class="dropdown-item" href="pages/ver/minhasFolhas.php">Minhas folhas de rosto</a>
                        <?php if ($objUsuario->getNivel() > 1) echo '<a class="dropdown-item" href="pages/administracao/revisao.php">Revisao de máquinas</a>' ?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="pages/administracao/dashboard.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administração
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="pages/criar/folhaDeRosto.php">Criar uma folha de rosto</a>
                        <a class="dropdown-item" href="pages/administracao/visualizarMaquinas.php">Visualizar folhas</a>
                        <a class="dropdown-item" href="pages/administracao/laudos.php">Emitir Laudos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages/administracao/dashboard.php">Dashboard</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="pages/versoes/versoes.php" id="navbarDropdown">
                        Logs de versões do sistema
                    </a>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0 text-light">
                <span><?= 'Bem vindo(a) ' . $objUsuario->getNome() . " | Nivel: " . $objUsuario->getNivel() ?> |</span>
                <span>
                    <a href="./configuracoes.php"><img class="nav-item ml-2" width="20" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDUxOC40NTIgNTE4LjQ1MiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGc+PGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJtMjU5LjIyNiAxMjQuMTk5Yy03NC41NzQgMC0xMzUuMDI3IDYwLjQ1NC0xMzUuMDI3IDEzNS4wMjcgMCA3NC41NzQgNjAuNDU0IDEzNS4wMjcgMTM1LjAyNyAxMzUuMDI3czEzNS4wMjctNjAuNDUzIDEzNS4wMjctMTM1LjAyNy02MC40NTMtMTM1LjAyNy0xMzUuMDI3LTEzNS4wMjd6bTAgMjI1LjA1NGMtNDkuNjQxIDAtOTAuMDI3LTQwLjM4Ni05MC4wMjctOTAuMDI3czQwLjM4Ni05MC4wMjcgOTAuMDI3LTkwLjAyNyA5MC4wMjcgNDAuMzg2IDkwLjAyNyA5MC4wMjctNDAuMzg2IDkwLjAyNy05MC4wMjcgOTAuMDI3eiIgZmlsbD0iI2ZmZmZmZiIgZGF0YS1vcmlnaW5hbD0iIzAwMDAwMCIgc3R5bGU9IiI+PC9wYXRoPjxjaXJjbGUgY3g9IjI1OS4yMjYiIGN5PSIyNTkuMjI2IiByPSI2MC4wMjciIGZpbGw9IiNmZmZmZmYiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiPjwvY2lyY2xlPjxwYXRoIGQ9Im00NzMuNDE2IDI1OS4yMjZjMC0yMy4xNzEgMTEuOTgtNDMuOTIxIDMyLjA0Ni01NS41MDdsMTIuOTktNy41LTc1LjA0OC0xMjkuOTg2LTEyLjk5IDcuNWMtMjAuMDY3IDExLjU4NS00NC4wMjYgMTEuNTg2LTY0LjA5MyAwLTIwLjA2Ni0xMS41ODYtMzIuMDQ3LTMyLjMzNi0zMi4wNDctNTUuNTA3di0xNWgtMTUwLjA5NnYxNWMwIDIzLjE3MS0xMS45OCA0My45MjEtMzIuMDQ3IDU1LjUwN3MtNDQuMDI2IDExLjU4Ny02NC4wOTMgMGwtMTIuOTktNy41LTc1LjA0OCAxMjkuOTg2IDEyLjk5IDcuNWMyMC4wNjYgMTEuNTg2IDMyLjA0NyAzMi4zMzYgMzIuMDQ3IDU1LjUwN3MtMTEuOTggNDMuOTIxLTMyLjA0NyA1NS41MDdsLTEyLjk5IDcuNSA3NS4wNDggMTI5Ljk4NiAxMi45OS03LjVjMjAuMDY3LTExLjU4NCA0NC4wMjctMTEuNTg1IDY0LjA5MyAwIDIwLjA2NyAxMS41ODUgMzIuMDQ3IDMyLjMzNiAzMi4wNDcgNTUuNTA3djE1aDE1MC4wOTZ2LTE1YzAtMjMuMTcxIDExLjk4LTQzLjkyMiAzMi4wNDctNTUuNTA3IDIwLjA2Ni0xMS41ODUgNDQuMDI3LTExLjU4NSA2NC4wOTMgMGwxMi45OSA3LjUgNzUuMDQ4LTEyOS45ODYtMTIuOTktNy41Yy0yMC4wNjYtMTEuNTg2LTMyLjA0Ni0zMi4zMzYtMzIuMDQ2LTU1LjUwN3ptLTQ5LjE2MyAwYzAgMjIuMjY1LTQuMzY3IDQzLjg4MS0xMi45ODEgNjQuMjQ1LTguMzEzIDE5LjY1NS0yMC4yMDggMzcuMy0zNS4zNTQgNTIuNDQ3LTE1LjE0NiAxNS4xNDYtMzIuNzkyIDI3LjA0MS01Mi40NDcgMzUuMzU0LTIwLjM2NSA4LjYxNC00MS45OCAxMi45ODEtNjQuMjQ1IDEyLjk4MXMtNDMuODgxLTQuMzY3LTY0LjI0NS0xMi45ODFjLTE5LjY1NS04LjMxMy0zNy4zLTIwLjIwOC01Mi40NDctMzUuMzU0LTE1LjE0Ni0xNS4xNDYtMjcuMDQxLTMyLjc5Mi0zNS4zNTQtNTIuNDQ3LTguNjE0LTIwLjM2NS0xMi45ODEtNDEuOTgtMTIuOTgxLTY0LjI0NXM0LjM2Ny00My44OCAxMi45ODEtNjQuMjQ1YzguMzEzLTE5LjY1NSAyMC4yMDgtMzcuMzAxIDM1LjM1NC01Mi40NDdzMzIuNzkyLTI3LjA0MSA1Mi40NDctMzUuMzU0YzIwLjM2NS04LjYxNCA0MS45OC0xMi45ODEgNjQuMjQ1LTEyLjk4MXM0My44ODEgNC4zNjcgNjQuMjQ1IDEyLjk4MWMxOS42NTUgOC4zMTMgMzcuMyAyMC4yMDggNTIuNDQ3IDM1LjM1NCAxNS4xNDYgMTUuMTQ2IDI3LjA0MSAzMi43OTIgMzUuMzU0IDUyLjQ0NyA4LjYxNCAyMC4zNjQgMTIuOTgxIDQxLjk4IDEyLjk4MSA2NC4yNDV6IiBmaWxsPSIjZmZmZmZmIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIj48L3BhdGg+PC9nPjwvZz48L3N2Zz4=" /></a>
                </span>
                <a href="index.php" class="p-1 text-light nav-link">  |  Sair</a>
            </div>
        </div>
    </nav>

    </div>

    <div class="container">
        <div id="acoes">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-1">Configuracões</h1>
                </div>
            </div>
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-md-4">
                    <a href="pages/adicionarMaquinas/adicionar.php">
                        <div class="btn btn-primary btn-block" style="font-size: 1.5rem !important; font-weight:300;">
                            Adicionar máquinas e peças
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mt-5 d-flex justify-content-center">
                <div class="col-md-4">
                    <a href="pages/versoes/versoes.php">
                        <div class="btn btn-primary btn-block" style="font-size: 1.5rem !important; font-weight:300;">
                            Versões do sistema
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