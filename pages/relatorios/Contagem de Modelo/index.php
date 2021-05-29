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


//buscando os anos
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
                            <div class="filtros-item mb-2">
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
                            <tr>
                                <th scope="col">Rótulos de Linha</th>
                                <th scope="col">Contagem de modelos</th>
                            </tr>
                        </thead>
                        <tbody id="tableContagemDeModelo">

                        </tbody>
                    </table>
                    <strong>Total: <span id="totalContagemDeModelo"></span></strong>

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
        
        let colorArray = [];

        var datatable = $("#table").DataTable({
            order: [0, 'desc'],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'print', 'pdf', 'excel'
            ]
        });
        let contagemModelo = {
            mes: "",
            ano: "",
            jsonRetorno: "",
            labelChart: [],
            dataChart: []
        };
        var ctx = document.getElementById('myChart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    label: '# de Modelos',
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
                    text: "Contagem de Modelos"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        function setMesContagemModelo(m) {
            contagemModelo.mes = m;
            pesquisarContagemModelo();
        }

        function setAnoContagemModelo(a) {
            contagemModelo.ano = a;
            pesquisarContagemModelo();
        }

        function pesquisarContagemModelo() {
            let data = {
                data: ""
            }

            if (contagemModelo.mes < 10) {
                contagemModelo.mes = "0" + contagemModelo.mes
            }

            if (contagemModelo.mes > 0) {
                data.data = "/" + contagemModelo.mes + "/"
            }

            if (contagemModelo.ano > 0) {
                data.data += contagemModelo.ano;
            }
            $.get('../../../webservice/pages/contagemDeModelo', data, (r) => {
                chart.data.datasets[0].backgroundColor = [
                'rgba(255, 99, 132)',
                'rgba(54, 162, 235)',
                'rgba(255, 206, 86)',
                'rgba(75, 192, 192)',
                'rgba(153, 102, 255)',
                'rgba(255, 159, 64)'
            ];

                contagemModelo.jsonRetorno = JSON.parse(r)
                for(var i = 0; i <  contagemModelo.jsonRetorno.length; i++){
                    chart.data.datasets[0].backgroundColor.push(getRandomColor());
                }
                montarTabelaContagemModelo();
            });

            data.data = "";
        }

        function montarTabelaContagemModelo() {
            let data = contagemModelo.jsonRetorno;
            let total = 0;

            $("#tableContagemDeModelo").html("");
            if (data.length !== undefined) {
                data.forEach((item) => {
                    $("#tableContagemDeModelo").append(
                        '<tr>' +
                        '<th scope="row">' + item.modelo + '</th>' +
                        '<td>' + item.quantidade + '</td>' +
                        '</tr>'
                    );
                    total += parseInt(item.quantidade);
                    contagemModelo.labelChart.push(item.modelo);
                    contagemModelo.dataChart.push(item.quantidade);

                    datatable.clear();
                    datatable.rows.add(data);
                    datatable.draw();
                })
            }
            removeData(chart);
            if (contagemModelo.jsonRetorno !== undefined) {
                addData(chart, contagemModelo.labelChart, contagemModelo.dataChart);
            }

            $("#totalContagemDeModelo").text(total);
            total = 0;
            contagemModelo.labelChart = [];
            contagemModelo.dataChart = [];
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