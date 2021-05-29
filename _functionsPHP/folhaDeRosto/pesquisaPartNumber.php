<?php
if (isset($_GET['partNumber'])) {
    $partNumber = $_GET['partNumber'];

    //verificar se existe aquele partnumber

    //Pegando dados dos modelos com as peças
    $str = file_get_contents('../../assets/data/modelo.json');
    $json = json_decode($str, true);

    //pegandos o modelo de acordo com o part number
    $modelo = file_get_contents('../../assets/data/partNumber.json');
    $jsonModelo = json_decode($modelo, true);

    if (array_key_exists($partNumber, $jsonModelo)) {
       echo $jsonModelo[$partNumber];
        
    } else {
        echo '<option value="Sem seleção">Sem seleção</option>
        <optgroup label="NOTEBOOK">
            <option value="CQ-15">CQ-15</option>
            <option value="CQ-17">CQ-17</option>
            <option value="CQ-21">CQ-21</option>
            <option value="CQ-23">CQ-23</option>
            <option value="CQ-25">CQ-25</option>
            <option value="CQ-27">CQ-27</option>
            <option value="CQ-29">CQ-29</option>
            <option value="CQ-31">CQ-31</option>
            <option value="CQ-32">CQ-32</option>
            <option value="CQ-360">CQ-360</option>
        </optgroup>
        <optgroup label="DESKTOP">
            <option value="CQ-11">CQ-11</option>
            <option value="CQ-14">CQ-14</option>
        </optgroup>
        <optgroup label="ALL IN ONE">
            <option value="CQ-A1">CQ-A1</option>
        </optgroup>';
    }
}


// echo "O elemento '" . $partNumber . "' está na lista de Part Number!";
// //mostrando o modelo de acordo com o part number
// var_dump($jsonModelo[$partNumber]);
//mostrando as peças de acordo com o modelo e part number
// var_dump($json[$jsonModelo[$partNumber]][$partNumber]);