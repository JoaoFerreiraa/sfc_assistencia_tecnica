<?php
session_start();
require '../../_Class/Conexao.php';
require '../../_Class/Usuario.php';


if (!isset($_SESSION['usuario'])) {
    header("../../Location:index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();


$objConexaoRelatorio = new Conexao();
if ($objUsuario->getNivel() == 1) {
    header("Location:../../pages/administracao/dashboard.php");
}

if($objUsuario->getNivel() < 4){
    header("Location:../../dashboard.php");
}

//DADOS GLOBAIS

$todasAsFolhas = $objConexaoRelatorio->Consultar("select * from folha_de_rosto");

//where folha_de_rosto.entrada_laboratorio like '%/01/2021%' SCRIPT PARA PODER CONSULTAR E FAZER O FITLRO

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./dashboard.css">
    <title>Dashboard Relátorios | SFC</title>
</head>

<body>

    <?php
    $page = 'dashboard';
    include '../../models/menu_pages.php';
    include './components/menuLateral.php';

    ?>
    </div>

    <div class="dashboard-body">
        <div class="container">
            <div class="row">
                <?php
                $path = "./";
                $diretorio = dir($path);

                while ($arquivo = $diretorio->read()) {
                    if (strpos($arquivo, '.') !== false) {
                    } else {
                        if ($arquivo !== "components") {
                            $desc = file_get_contents($path.$arquivo."/desc.txt");
                            echo '<div class="col-sm-12 col-md-3 m-2 style d-flex justify-content-center align-items-center flex-column">
                            <div class="titulo">
                                <h6>'.$arquivo.'</h6>
                            </div>
                            <div class="corpo text-center">
                                <p style="margin: 1rem 2rem 2rem 2rem;">'.$desc.'</p>
                            </div>
                            <div class="footer w-100">
                                <a href="'.$path.$arquivo.'" class="btn btn-primary w-100">Acessar relatório</a>
                            </div>
                        </div>';
                        }
                    }
                }
                $diretorio->close();
                ?>
               
            </div>
        </div>
    </div>

    <footer style="position: relative;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="../../assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="../../assets/js/fontawesome.min.js"></script>
    <script src="../../assets/js/Chart.min.js"></script>
    <script src="../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>

    </script>
</body>

</html>