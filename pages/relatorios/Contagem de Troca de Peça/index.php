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
                                <th scope="col">Peças Trocadas</th>
                                <th scope="col">Peças não Trocadas</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableContagemDeModelo">

                        </tbody>
                    </table>

                    <!-- http://shoopfloorcontrol.ddns.net:2020/sfc/_dev_version/webserviceRelatorios/pages/contagemDeModelo/?query=01/01/ -->
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
            order: [0, 'desc'],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'print', 'pdf', 'excel'
            ]
        });

        let contagemPeças = {
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
                    label: '# de Peças',
                    data: [],
                    backgroundColor: [],
                    borderColor: 'rgba(200, 200, 200, 0.75)',
                    hoverBorderColor: 'rgba(200, 200, 200, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Contagem de Troca de Peça"
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
            contagemPeças.mes = m;
            pesquisarContagemModelo();
        }

        function setAnoContagemModelo(a) {
            contagemPeças.ano = a;
            pesquisarContagemModelo();
        }

        function pesquisarContagemModelo() {
            let data = {
                data: ""
            }

            if (contagemPeças.mes < 10) {
                contagemPeças.mes = "0" + contagemPeças.mes
            }

            if (contagemPeças.mes > 0) {
                data.data = "/" + contagemPeças.mes + "/"
            }

            if (contagemPeças.ano > 0) {
                data.data += contagemPeças.ano;
            }
            $.get('../../../webservice/pages/contagemDeTrocaDePeca', data, (r) => {
                let pecasArray = [
                    []
                ];
                chart.data.datasets[0].backgroundColor = [
                'rgba(255, 99, 132)',
                'rgba(54, 162, 235)',
                'rgba(255, 206, 86)',
                'rgba(75, 192, 192)',
                'rgba(153, 102, 255)',
                'rgba(255, 159, 64)'
            ];

                contagemPeças.jsonRetorno = JSON.parse(r);

                for (var i = 0; i < 2; i++) {
                    chart.data.datasets[0].backgroundColor.push(getRandomColor());
                }


                pecasArray[0].push(contagemPeças.jsonRetorno.pecasNaoTrocadas);
                pecasArray[0].push(contagemPeças.jsonRetorno.pecasTrocas);
                pecasArray[0].push(contagemPeças.jsonRetorno.pecasNaoTrocadas + contagemPeças.jsonRetorno.pecasTrocas);



                montarTabelaContagemModelo();
                datatable.clear();


                if (contagemPeças.jsonRetorno !== undefined) {
                    datatable.rows.add(pecasArray);
                    datatable.draw();
                }
            });

            data.data = "";
        }

        function montarTabelaContagemModelo() {
            let data = contagemPeças.jsonRetorno;
            let total = parseInt(data.pecasTrocas) + parseInt(data.pecasNaoTrocadas);
            $("#tableContagemDeModelo").html("");
            $("#tableContagemDeModelo").append(
                '<tr>' +
                '<th scope="row">' + data.pecasTrocas + '</th>' +
                '<td>' + data.pecasNaoTrocadas + '</td>' +
                '<td>' + total + '</td>' +
                '</tr>'
            );
            contagemPeças.labelChart.push('Peças não trocadas');
            contagemPeças.labelChart.push('Peças trocadas');
            contagemPeças.dataChart.push(data.pecasNaoTrocadas, data.pecasTrocas);
            
            removeData(chart);
            if (contagemPeças.jsonRetorno !== undefined) {
                addData(chart, contagemPeças.labelChart, contagemPeças.dataChart);
                console.log(chart.data.labels);
            }

            total = 0;
            contagemPeças.labelChart = [];
            contagemPeças.dataChart = [];
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