<?php
    session_start();
    
    require '../../_Class/Usuario.php';
    $objUsuario = new Usuario();
    $objUsuario->setUsuario($_POST['usuario']);
    if($objUsuario->login($_POST['senha'])){
        $_SESSION['usuario']['usuario'] = $objUsuario->getUsuario();
        $_SESSION['usuario']['cod'] = $objUsuario->getCod();
        $_SESSION['usuario']['nome'] = $objUsuario->getNome();
        echo true;
    }else{
        echo false;
    }
