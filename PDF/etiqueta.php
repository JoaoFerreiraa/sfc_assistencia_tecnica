<?php
require_once '../_Class/FolhaDeRosto.php';
require_once '../_Class/TecnicoResponsavelFolha.php';
require_once '../_Class/Usuario.php';

$objFolhaDeRosto = new FolhaDeRosto();
$objTecResponsavel = new TecnicoResponsavelFolha();
$objUsuario = new Usuario();

$objFolhaDeRosto->setCod($_GET['folha']);

$folha = $objFolhaDeRosto->consultar_por_codigo();

$nome = $objFolhaDeRosto->getNome_cliente();
$nomeLimitado = substr($nome, 0, 38);


if (strlen($nome) > 38)

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
    <title></title>
</head>

<body>
    <h1>Dados para a etiqueta</h1>
    <hr>
    <h2>Nome 38 caracteres:</h2>
    <strong><?= $nomeLimitado ?></strong>
    <br>
    <h2>Numero de serie:</h2>
    <strong><?= $objFolhaDeRosto->getNumero_serie() ?></strong>
    <br>
    <h2>Nome TODOS caracteres:</h2>
    <strong><?= $objFolhaDeRosto->getNome_cliente() ?></strong>
    <br>
</body>

</html>