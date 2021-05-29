<?php
if (isset($_GET['partNumber']) && !empty($_GET['partNumber'])) {
    $partNumber = $_GET['partNumber'];

    //verificar se existe aquele partnumber

    //Pegando dados dos modelos com as peças
    $str = file_get_contents('../../assets/data/modelo.json');
    $json = json_decode($str, true);

    //pegandos o modelo de acordo com o part number
    $modelo = file_get_contents('../../assets/data/partNumber.json');
    $jsonModelo = json_decode($modelo, true);

    if (array_key_exists($partNumber, $jsonModelo)) {
        $opcaoDePecasTrocadas = $json[$jsonModelo[$partNumber]][$partNumber];

        //monta o corpo do modal primeiro
        echo '<div class="form-group">
    <span>Peças Trocadas:</span>
    <br>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Abrir opções
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Opções de peças trocadas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body" style="height: 475px;overflow-y: scroll;">
                    <div class="form-group">
                        <div class="ml-2 text-muted">
                        <input type="checkbox" value="Sem peças trocadas" name="pecasTrocadas[]" class="pecasTrocadasInput" >
            <span>Sem peças trocadas</span>
            <br>';


        foreach ($opcaoDePecasTrocadas as &$opcao) {
            echo '<input type="checkbox" value="' . $opcao . '" name="pecasTrocadas[]" class="pecasTrocadasInput" >
            <span>' . $opcao . '</span>
            <br>';
        }


        echo '</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="inserirTags()">Aplicar peças</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- peças trocadas -->';
    }else{
        echo '<span>Peças Trocadas:</span>
        <br>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
            Part Number inexistente...
        </button>';
    }
} else {
    echo '<span>Peças Trocadas:</span>
    <br>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Adicione um partNumber e atualize a folha primeiro!
    </button>';
}


// echo "O elemento '" . $partNumber . "' está na lista de Part Number!";
// //mostrando o modelo de acordo com o part number
// var_dump($jsonModelo[$partNumber]);
//mostrando as peças de acordo com o modelo e part number
// var_dump($json[$jsonModelo[$partNumber]][$partNumber]);