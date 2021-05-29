<?php
session_start();
require '../../../_Class/Usuario.php';
require '../../../_Class/FolhaDeRosto.php';
require '../../../_Class/TecnicoResponsavelFolha.php';
require '../../../_Class/LaudoEmitido.php';
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
}


$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();

if($objUsuario->getNivel() < 4){
    header("Location:../../../dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="../../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- DATA TABLE -->
    <link rel="stylesheet" href="../../../assets/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../../assets/datatable/css/buttons.dataTables.min.css">
    <title>Relatorio todas as folhas | SFC</title>

</head>

<body>
    <!-- ADICIONANDO MENU -->
    <?php $path="../../../"; include '../../../models/menu_pages.php'; ?>


    <div class="container d-flex justify-content-center">


        <div id="acoes">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1 class="text-muted mt-5">
                        Todas as máquinas
                    </h1>
                </div>
            </div>
            

            <div class="row" id="cards">
                <table class="table" id="table" style="zoom:0.7 !important;">
                    <thead>
                        <tr>
                            <th scope="col">Data Entrada Logistica</th>
                            <th scope="col">Data de Entrada na Assistência</th>
                            <th scope="col">Tipo de Solicitação</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Reincidência</th>
                            <th scope="col">Numero de serie</th>
                            <th scope="col">Part Number</th>
                            <th scope="col">Estética</th>
                            <th scope="col">Falha Relatada</th>
                            <th scope="col">Defeito encontrado</th>
                            <th scope="col">Solução</th>
                            <th scope="col">Peças / Ajustes</th>
                            <th scope="col">Técnico Responsável</th>
                            <th scope="col">Data de Saída Assistência</th>
                            <th scope="col">Burnin test falha</th>
                            <th scope="col">Causa Reincidência/Anotações</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $objFolhaDeRosto = new FolhaDeRosto();
                        $todasAsFolhas =$objFolhaDeRosto->consultar_todas();

                        if($todasAsFolhas != false){
                            foreach($todasAsFolhas as $folha){
                                //consuta os tecnicos responsaveis por aquela folha
                                $objTecResponsavel = new TecnicoResponsavelFolha();
                                $objTecResponsavel->setCod_folha_de_rosto($folha['cod']);
                                $tecnicoDaFolha = $objTecResponsavel->consultaResponsaveis()[0][0];
                                
                                //Consulta o nome do tecnico responsavel
                                $objUsuarioAux = new Usuario();
                                $objUsuarioAux->setCod($tecnicoDaFolha);
                                $objUsuarioAux->consulta_usuario_por_cod();
                                echo '
                                <tr>
                                    <th scope="row">'.$folha['lancamento_almoxarife'].'</th>
                                    <td>'.$folha['entrada_laboratorio'].'</td>
                                    <td>'.$folha['tipo_solicitacao'].'</td>
                                    <td>'.$folha['nome_cliente'].'</td>
                                    <td>'.$folha['reincidencia'].'</td>
                                    <td>'.$folha['numero_serie'].'</td>
                                    <td>'.$folha['part_number'].'</td>
                                    <td>'.$folha['desc_estetica_equipamento'].'</td>
                                    <td>'.$folha['desc_defeito_reclamado'].'</td>
                                    <td>'.$folha['defeito_apresentado'].'</td>
                                    <td>'.$folha['servicos_executados'].'</td>
                                    <td>'.$folha['pecas_trocadas'].'</td>
                                    <td>'.$folha['tec_responsavel_old'] .' '. $objUsuarioAux->getNome(). '</td>
                                    <td>'.$folha['laudo_emitido'].'</td>
                                    <td>'.$folha['burnin_test'].'</td>
                                    <td>'.$folha['causa_reincidencia'].'</td>
                                </tr>';
                            }
                        }
                         ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <footer style="position: relative;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="../../../assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="../../../assets/js/jquery-3.5.1.js"></script>
    <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../../assets/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../../../assets/datatable/js/dataTables.buttons.min.js"></script>
    <script src="../../../assets/datatable/js/buttons.flash.min.js"></script>
    <script src="../../../assets/datatable/js/jszip.min.js"></script>
    <script src="../../../assets/datatable/js/pdfmake.min.js"></script>
    <script src="../../../assets/datatable/js/vfs_fonts.js"></script>
    <script src="../../../assets/datatable/js/buttons.html5.min.js"></script>
    <script src="../../../assets/datatable/js/buttons.print.min.js"></script>
    <script>
        
        $(document).ready(function() {

            $('#table').DataTable({
                order: [0, 'desc'],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>