<?php
require_once 'Conexao.php';

class CriacaoFolhaDeRosto
{
    private $cod, $cod_folha_de_rosto, $usuario, $data_criacao;
    
    function getCod() {
        return $this->cod;
    }

    function getCod_folha_de_rosto() {
        return $this->cod_folha_de_rosto;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getData_criacao() {
        return $this->data_criacao;
    }

    function setCod($cod): void {
        $this->cod = $cod;
    }

    function setCod_folha_de_rosto($cod_folha_de_rosto): void {
        $this->cod_folha_de_rosto = $cod_folha_de_rosto;
    }

    function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }

    function setData_criacao($data_criacao): void {
        $this->data_criacao = $data_criacao;
    }

    function criar(){
        $objConexao = new Conexao();
        $cmdSql = "Call criacaoFolhaDeRosto_inserir(".$this->cod_folha_de_rosto.",".$this->usuario.",'".$this->data_criacao."')";
        return $objConexao->Inserir($cmdSql);
    }
}
