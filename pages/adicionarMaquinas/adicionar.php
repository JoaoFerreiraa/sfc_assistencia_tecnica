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

    <!-- DATA TABLE -->
    <link rel="stylesheet" href="../../assets/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../assets/datatable/css/buttons.dataTables.min.css">
    <title>Adicionar máquina | SFC</title>
</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php include '../../models/menu_pages.php' ?>

    <div class="container">
        <div id="acoes">

            <center>
                <h1 class="text-muted mt-2">Adicionar Máquinas</h1>
            </center>
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="alteraModal('Adicionar')">Adicionar máquina</button>
                </div>
                <div class="col d-flex justify-content-center">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="alteraModal('Remover')">Remover máquina</button>
                </div>
            </div>
            <div class="row mt-5 d-flex justify-content-center">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col">Modelo</th>
                            <th scope="col">Part Number</th>
                            <th scope="col">Peças</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        //Pegando dados dos modelos com as peças
                        $str = file_get_contents('../../assets/data/modelo.json');
                        $json = json_decode($str, true);

                        //pegandos o modelo de acordo com o part number
                        $modelo = file_get_contents('../../assets/data/partNumber.json');
                        $jsonModelo = json_decode($modelo, true);

                        //descontruo o json e pego apenas o modelo
                        foreach ($json as $modelo => $maquina) {
                            //Descontruo o restante das informações e atraves do partnumber procuro o modelo em outro json
                            foreach ($maquina as $partNumber => $maquina) {
                                if (array_key_exists($partNumber, $jsonModelo)) {
                                    echo '
                                <tr>
                                <th scope="row">' . $jsonModelo[$partNumber] . '</th>
                                <td>' . $partNumber . '</td>
                                <td>';
                                    for ($i = 0; $i < count($maquina); $i++) {
                                        echo $maquina[$i] . ", ";
                                    }
                                    echo '</td>
                                </tr>';
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <div class="form-group add">
                            <label for="modelo">Modelo</label>
                            <input class="form-control" type="text" name="modelo" id="modelo">
                        </div>
                        <div class="form-group">
                            <label for="partNumber">Part Number</label>
                            <input class="form-control" type="text" name="partNumber" id="partNumber">
                        </div>
                        <div class="form-group add">
                            <label for="pecas">Peças</label>
                            <textarea class="form-control" type="text" name="pecas" id="pecas" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <input type="submit" name="btn" for="form" class="btn btn-primary" value="..." />
                    </div>
                </form>
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
    <script>
        function alteraModal(tipo) {

            switch (tipo) {
                case 'Adicionar':
                    $(".add").removeClass("d-none");
                    $("#exampleModalLabel").text("Adicionar");
                    $(".modal-footer input").val("Adicionar");
                    break;
                case 'Remover':
                    $(".add").addClass("d-none");
                    $("#exampleModalLabel").text("Remover");
                    $(".modal-footer input").val("Remover");
                    break;
                default:
                    alert("me parece que voce nao adicionou um tipo");
                    break;
            }
        }

        //SCRIPT PARA DEIXAR TODAS AS LETRAS MAIUSCULAS
        $("input[name='partNumber']").keyup(function(event) {
            $("input[name='partNumber']").val($("input[name='partNumber']").val().toUpperCase());
        })

        $("input[name='modelo']").keyup(function(event) {
            $("input[name='modelo']").val($("input[name='modelo']").val().toUpperCase());
        })
    </script>

    <?php

    if (isset($_GET['btn']) && $_GET['btn'] === 'Adicionar') {
        if (!empty($_GET['modelo'] && !empty($_GET['partNumber']) && !empty($_GET['pecas']))) {
            $modelo = $_GET['modelo'];
            $partNumber = $_GET['partNumber'];
            $pecas = explode(',', $_GET['pecas']);

            $pecasArray = [];
            foreach ($pecas as $key => $peca) {
                $peca = str_replace("\r\n", "", $peca);
                array_push($pecasArray, $peca);
            }


            //Pegando dados dos modelos com as peças
            $str = file_get_contents('../../assets/data/modelo.json');
            $json = json_decode($str, true);

            //pegandos o modelo de acordo com o part number


            //verificando se o modelo ja existe no JSON
            if (array_key_exists($modelo, $json)) {

                //adicionando item na array
                array_push($json[$modelo], $pecasArray);
                $json[$modelo][$partNumber] = $json[$modelo][0];
                unset($json[$modelo][0]);
            } else {
                //criando json para o modelo e adicionando partnumber / peças
                $json[$modelo][$partNumber] = $pecasArray;
            }

            //salvando dados no arquivo json
            $json = json_encode($json);
            $file = fopen('../../assets/data/modelo.json', 'w');
            fwrite($file, $json);
            fclose($file);

            //pegandos o modelo de acordo com o part number
            $jsonPartNumber = file_get_contents('../../assets/data/partNumber.json');
            $jsonPartNumber = json_decode($jsonPartNumber, true);


            //adicionando item na array
            array_push($jsonPartNumber, $modelo);

            //trocando key de 0 para o nome do modelo
            $jsonPartNumber[$partNumber] = $jsonPartNumber[0];
            unset($jsonPartNumber[0]);

            $json = json_encode($jsonPartNumber);
            $file = fopen('../../assets/data/partNumber.json', 'w');
            fwrite($file, $json);
            fclose($file);

            echo '<script>alert("Máquina adicionada com sucesso!")</script>';
            echo '<script>window.location.href = "adicionar.php";</script>';
        } else {
            echo '<script>alert("Preencha todos os campos!")</script>';
        }
    } else if (isset($_GET['btn']) && $_GET['btn'] === 'Remover') {
        if (!empty($_GET['partNumber'])) {
            $partNumber = $_GET['partNumber'];

            //pegandos o modelo de acordo com o part number
            $jsonPartNumber = file_get_contents('../../assets/data/partNumber.json');
            $jsonPartNumber = json_decode($jsonPartNumber, true);

            //verifica se o partnumber existe no JSON e remove
            if (array_key_exists($partNumber, $jsonPartNumber)) {
                //Pegando dados dos modelos com as peças
                $str = file_get_contents('../../assets/data/modelo.json');
                $json = json_decode($str, true);

                unset($json[$jsonPartNumber[$partNumber]][$partNumber]);
                unset($jsonPartNumber[$partNumber]);

                //salvando dados no arquivo json
                $json = json_encode($json);
                $file = fopen('../../assets/data/modelo.json', 'w');
                fwrite($file, $json);
                fclose($file);

                $json = json_encode($jsonPartNumber);
                $file = fopen('../../assets/data/partNumber.json', 'w');
                fwrite($file, $json);
                fclose($file);
                echo '<script>alert("Máquina excluída com sucesso!")</script>';
                echo '<script>window.location.href = "adicionar.php";</script>';
            } else {
                echo '<script>alert("Esse part number não está cadastrado")</script>';
            }
        } else {
            echo '<script>alert("Preencha todos os campos!")</script>';
        }
    }

    ?>
</body>

</html>