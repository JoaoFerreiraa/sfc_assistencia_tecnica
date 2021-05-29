<?php
require '../../_Class/Usuario.php';
require '../../_Class/FolhaDeRosto.php';
require '../../_Class/TecnicoResponsavelFolha.php';
session_start();


if (isset($_GET['codFolha'])) {
    $responsaveis = null;
    $objTecnicoResponsavelFolha = new TecnicoResponsavelFolha();
    $objTecnicoResponsavelFolha->setCod_folha_de_rosto($_GET['codFolha']);
    $responsaveisRetorno = $objTecnicoResponsavelFolha->consultaResponsaveis();

    if ($responsaveisRetorno !== false) {
        foreach ($responsaveisRetorno as $val) {
            $objUsuarioAuxResponsavel = new Usuario();
            $objUsuarioAuxResponsavel->setCod((int) $val['tec_responsavel']);
            $objUsuarioAuxResponsavel->consulta_usuario_por_cod();
            $responsaveis .= $objUsuarioAuxResponsavel->getNome() . " / ";
        }
    }
    echo $responsaveis;
}
