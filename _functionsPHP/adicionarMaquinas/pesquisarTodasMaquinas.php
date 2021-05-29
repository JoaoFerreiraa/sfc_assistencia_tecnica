<?php

//Pegando dados dos modelos com as peças
$str = file_get_contents('../../assets/data/modelo.json');
$json = json_decode($str, true);

//pegandos o modelo de acordo com o part number
$modelo = file_get_contents('../../assets/data/partNumber.json');
$jsonModelo = json_decode($modelo, true);



// echo "O elemento '" . $partNumber . "' está na lista de Part Number!";
// //mostrando o modelo de acordo com o part number
// var_dump($jsonModelo[$partNumber]);
//mostrando as peças de acordo com o modelo e part number
// var_dump($json[$jsonModelo[$partNumber]][$partNumber]);