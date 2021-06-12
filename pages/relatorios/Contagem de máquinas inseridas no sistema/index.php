<?php
session_start();
require '../../../_Class/Conexao.php';
require '../../../_Class/Usuario.php';


if (!isset($_SESSION['usuario'])) {
    header("../../../Location:index.php");
}
$objUsuario = new Usuario();
$objUsuario->setUsuario($_SESSION['usuario']['usuario']);
$objUsuario->consulta_usuario_por_usuario();


$objConexaoRelatorio = new Conexao();
if ($objUsuario->getNivel() == 1) {
    header("Location:../../../pages/administracao/dashboard.php");
}


if ($objUsuario->getNivel() < 4) {
    header("Location:../../../dashboard.php");
}
//DADOS GLOBAIS

include '../components/consultaData.php';


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../../assets/datatable/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="./style.css">
    <title>Dashboard Relátorios | SFC</title>
</head>

<body>

    <?php
    $path = '../../../';
    include '../../../models/menu_pages.php';
    include '../components/menuLateral.php';
    ?>
    </div>

    <div class="dashboard-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 mb-3 d-flex justify-content-center align-items-center flex-column ">
                    <div class="mychart">
                        <canvas id="myChart" width="400" height="400">
                        </canvas>
                        <a id="download" download="ContagemDeModelos.jpg" href="" class="btn btn-primary float-right bg-flat-color-1" title="Descargar Gráfico">

                            <!-- Download Icon -->
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 style">
                    <form>
                        <div class="filtros">
                            <div class="filtros-item">
                                <span>Ano</span>
                                <select id="selectAnosContagemModelo" onchange="setAnoContagemModelo(this.value)">
                                    <option value="">Todos os anos</option>
                                    <?php
                                    foreach ($anosSeparados as $anos) {
                                        echo '<option value="' . $anos . '">' . $anos . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="filtros-item">
                                <span>Mês</span>
                                <select id="selectMesesContagemModelo" onchange="setMesContagemModelo(this.value)">
                                    <option value="Selecionar">Selecionar</option>
                                    <option value="">Todos os meses</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <table class="table" id='table'>
                        <thead>
                            <tr id="tr-tabela">
                                <th scope="col">Data</th>
                                <th scope="col">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody id="tableContagemDeModelo">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <footer style="position: relative;bottom:0;width:100%;">
        <img class="card-img-bottom" style="width: 10% !important; float:right;" src="../../../assets/img/logo.png" alt="Card image cap">
    </footer>
    <script src="../../../assets/js/fontawesome.min.js"></script>
    <script src="../../../assets/js/Chart.min.js"></script>
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
        function getRandomColor() {
            var letters = "0123456789ABCDEF".split("");
            var color = "#";
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        var datatable = $("#table").DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'print', 'pdf', 'excel'
            ]
        });
        let contagemEntradaAssistencia = {
            mes: "",
            ano: "",
            jsonRetorno: "",
            labelChart: [],
            dataChart: []
        };
        var ctx = document.getElementById('myChart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Entradas',
                    data: [],

                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Contagem de máquinas inseridas no sistema"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                animation: {
                    duration: 1,
                    onComplete: function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function(dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            });
                        });
                    }
                }
            }
        });

        function setMesContagemModelo(m) {
            contagemEntradaAssistencia.mes = m;
            pesquisarContagemModelo();
        }

        function setAnoContagemModelo(a) {
            contagemEntradaAssistencia.ano = a;
            pesquisarContagemModelo();
        }

        function setModeloContagemModelo(modelo) {
            contagemEntradaAssistencia.modelo = modelo;
            pesquisarContagemModelo();
        }

        function pesquisarContagemModelo() {
            let data = {
                data: "",
                modelo: contagemEntradaAssistencia.modelo
            }
            if (contagemEntradaAssistencia.ano > 0) {
                    data.data += contagemEntradaAssistencia.ano;
                }
            if (contagemEntradaAssistencia.mes > 0) {
                data.data += "-0" + contagemEntradaAssistencia.mes + "-"
            }
            if (contagemEntradaAssistencia.mes < 10) {
                contagemEntradaAssistencia.mes += "0" + contagemEntradaAssistencia.mes
            }

            
            $.get('../../../webservice/pages/ContagemMaquinasInseridasSistema', data, (r) => {
                chart.data.datasets[0].backgroundColor = [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ];

                contagemEntradaAssistencia.jsonRetorno = (r);

                for (var i = 0; i < r.length; i++) {
                    chart.data.datasets[0].backgroundColor.push(getRandomColor());
                }


                montarTabelaContagemModelo();
            });

            data.data = "";
        }

        function montarTabelaContagemModelo() {
            let data = contagemEntradaAssistencia.jsonRetorno;
            let quantidade = [];
            let label = [];
            let total = 0;


            $("#tableContagemDeModelo").html("");
            $("#table").DataTable().clear().destroy();
            // console.log(data.get.length);
            let pecasArray = [];
            data.forEach((item) => {
                $("#tableContagemDeModelo").append(
                    '<tr>' +
                    '<th scope="row">' + item['datas'] + '</th>' +
                    '<td>' + item['contagem'] + '</td>' +
                    '</tr>'
                );
                total += parseInt(item['contagem'])
                contagemEntradaAssistencia.labelChart.push(item['datas']);
                contagemEntradaAssistencia.dataChart.push(item['contagem']);
            })
            $("#tableContagemDeModelo").append(
                    '<tr>' +
                    '<th scope="row">Total</th>' +
                    '<td>' + total + '</td>' +
                    '</tr>'
                );
            $("#table").DataTable({
                "bSort" : false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'print', 'pdf', 'excel'
                ]
            });

            removeData(chart);
            if (contagemEntradaAssistencia.jsonRetorno !== undefined) {
                addData(chart, contagemEntradaAssistencia.labelChart, contagemEntradaAssistencia.dataChart);
            }

            total = 0;
            contagemEntradaAssistencia.labelChart = [];
            contagemEntradaAssistencia.dataChart = [];
        }

        function addData(chart, label, datac) {
            chart.data.labels = label;
            chart.data.datasets.forEach((dataset) => {
                dataset.data = datac;
            });
            chart.update();
        }

        function removeData(chart) {
            chart.data.labels = [];
            chart.data.datasets.data = []
            chart.update();
        }


        document.getElementById("download").addEventListener('click', function() {
            /*Get image of canvas element*/
            var url_base64jp = document.getElementById("myChart").toDataURL("image/jpg");
            /*get download button (tag: <a></a>) */
            var a = document.getElementById("download");
            /*insert chart image url to download button (tag: <a></a>) */
            a.href = url_base64jp;
        });
    </script>
</body>

</html>