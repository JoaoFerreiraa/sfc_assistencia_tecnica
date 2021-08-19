<?php
//folha_de_rosto

require_once dirname(__DIR__) . '/_Class/Conexao.php';
$objConexao =  new Conexao();
$query = "SELECT * FROM folha_de_rosto WHERE folha_de_rosto.usuario = 2021";
$v_folhasderosto_db = $objConexao->Consultar($query);



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700');

        $base-spacing-unit: 24px;
        $half-spacing-unit: $base-spacing-unit / 2;

        $color-alpha: #1772FF;
        $color-form-highlight: #EEEEEE;

        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        body {
            padding: $base-spacing-unit;
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 6pt;
            margin: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
        }

        .container {
            max-width: 98vw;
            margin-right: auto;
            margin-left: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .table {
            width: 100%;
            border: 1px solid $color-form-highlight;
        }

        .table-header {
            display: flex;
            width: 100%;
            background: #000;
            padding: ($half-spacing-unit * 1.5) 0;
        }

        .table-row {
            display: flex;
            width: 100%;
            padding: ($half-spacing-unit * 1.5) 0;

            &:nth-of-type(odd) {
                background: $color-form-highlight;
            }
        }

        .table-data,
        .header__item {
            flex: 1 1 20%;
            text-align: center;
        }

        .header__item {
            text-transform: uppercase;
        }

        .filter__link {
            color: white;
            text-decoration: none;
            position: relative;
            display: inline-block;
            padding-left: $base-spacing-unit;
            padding-right: $base-spacing-unit;

            &::after {
                content: '';
                position: absolute;
                right: -($half-spacing-unit * 1.5);
                color: white;
                
                top: 50%;
                transform: translateY(-50%);
            }

            &.desc::after {
                content: '(desc)';
            }

            &.asc::after {
                content: '(asc)';
            }

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="table">
            <div class="table-header">
                <div class="header__item"><a id="name" class="filter__link" href="#">cod</a></div>
                <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">dataCriacao</a></div>
                <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">usuario</a></div>
                <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">lancamento_almoxarife</a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">saida_laboratorio
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">laudo_emitido
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">saida_logistica
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">tipo_solicitacao
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">nome_cliente
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">modelo
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">numero_serie
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">part_number
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">reincidencia
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">acompanha_fonte
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">desc_estetica_equipamento
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">desc_defeito_reclamado
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">defeito_apresentado
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">pecas_trocadas
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">orcamento
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">servicos_executados
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">burnin_test
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">causa_reincidencia
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">observacao
                    </a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">tec_responsavel_old
                    </a></div>
            </div>
            <div class="table-content">
                <?php
                if ($v_folhasderosto_db != false):
                    foreach ($v_folhasderosto_db as $folha_de_rosto) : ?>
                        <div class="table-row">
                        <div class="table-data"><?=$folha_de_rosto['cod']?></div>
                        <div class="table-data"><?=$folha_de_rosto['dataCriacao']?></div>
                        <div class="table-data"><?=$folha_de_rosto['usuario']?></div>
                            <div class="table-data"><?=$folha_de_rosto['lancamento_almoxarife']?></div>
                            <div class="table-data"><?=$folha_de_rosto['saida_laboratorio']?></div>
                            <div class="table-data"><?=$folha_de_rosto['laudo_emitido']?></div>
                            <div class="table-data"><?=$folha_de_rosto['saida_logistica']?></div>
                            <div class="table-data"><?=$folha_de_rosto['tipo_solicitacao']?></div>
                            <div class="table-data"><?=$folha_de_rosto['nome_cliente']?></div>
                            <div class="table-data"><?=$folha_de_rosto['modelo']?></div>
                            <div class="table-data"><?=$folha_de_rosto['numero_serie']?></div>
                            <div class="table-data"><?=$folha_de_rosto['part_number']?></div>
                            <div class="table-data"><?=$folha_de_rosto['reincidencia']?></div>
                            <div class="table-data"><?=$folha_de_rosto['acompanha_fonte']?></div>
                            <div class="table-data"><?=$folha_de_rosto['desc_estetica_equipamento']?></div>
                            <div class="table-data"><?=$folha_de_rosto['desc_defeito_reclamado']?></div>
                            <div class="table-data"><?=$folha_de_rosto['defeito_apresentado']?></div>
                            <div class="table-data"><?=$folha_de_rosto['pecas_trocadas']?></div>
                            <div class="table-data"><?=$folha_de_rosto['orcamento']?></div>
                            <div class="table-data"><?=$folha_de_rosto['servicos_executados']?></div>
                            <div class="table-data"><?=$folha_de_rosto['burnin_test']?></div>
                            <div class="table-data"><?=$folha_de_rosto['causa_reincidencia']?></div>
                            <div class="table-data"><?=$folha_de_rosto['observacao']?></div>
                            <div class="table-data"><?=$folha_de_rosto['tec_responsavel_old']?></div>
                        </div>
                <?php 
                    endforeach; 
                endif;
                ?>
            </div>
        </div>
    </div>
</body>

</html>