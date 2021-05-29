<?php
require_once 'Conexao.php';

Class TecnicoResponsavelFolha{
    private $cod, $cod_folha_de_rosto, $tec_responsavel;
    
    function getCod() {
        return $this->cod;
    }

    function getCod_folha_de_rosto() {
        return $this->cod_folha_de_rosto;
    }

    function getTec_responsavel() {
        return $this->tec_responsavel;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setCod_folha_de_rosto($cod_folha_de_rosto) {
        $this->cod_folha_de_rosto = $cod_folha_de_rosto;
    }

    function setTec_responsavel($tec_responsavel) {
        $this->tec_responsavel = $tec_responsavel;
    }

    function criar(){
        $objConexao = new Conexao();
        $cmdSql = "CALL tecnicoResponsavel_criar(".$this->cod_folha_de_rosto.",".$this->tec_responsavel.")";
        $this->adicionar_log($_SESSION['usuario']['nome'], 'O técnico se responsabilizou pela máquina! Maquina em reparo', 'tec_responsavel', $this->cod_folha_de_rosto);
        return $objConexao->Inserir($cmdSql);
    }

    function verificaResponsabilidadeDaFolha(){
        $objConexao = new Conexao();
        $cmdSql = "CALL tecnicoResponsavel_verificaResponsabilidadeDafolha(".$this->cod_folha_de_rosto.",".$this->tec_responsavel.")";
        $retorno = $objConexao->Consultar($cmdSql);
        if($retorno !== FALSE){
            return true;
        }else{
            return false;
        }
    }

    function consultarFolhas(){
        $objConexao = new Conexao();
        $cmdSql = "CALL tecnicoResponsavel_consultarFolhas(".$this->tec_responsavel.")";
        $retorno = $objConexao->Consultar($cmdSql);
        if(isset($retorno)){
            return $retorno;
        }else{
            return false;
        }
    }

    function consultaResponsaveis(){
        $objConexao = new Conexao();
        $cmdSql = "CALL tecnicoResponsavel_consultaResponsaveis(".$this->cod_folha_de_rosto.")";
        $retorno = $objConexao->Consultar($cmdSql);
        if(isset($retorno)){
            return $retorno;
        }else{
            return false;
        }
    }

    function adicionar_log($usuario, $log, $tabela, $cod_folha)
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL logs_criar('" . $usuario . "','" . $log . "','" . $tabela . "', " . $cod_folha . ")";
        return $objConexao->Inserir($cmdSql);
    }

    function editar(){
        $objConexao = new Conexao();
        $cmdSql = "CALL tecnicoResponsavel_editar(".$this->cod_folha_de_rosto.",".$this->tec_responsavel.")";
        $this->adicionar_log($_SESSION['usuario']['nome'], 'Outro técnico se responsabilizou pela máquina! Maquina em reparo', 'tec_responsavel', $this->cod_folha_de_rosto);
        return $objConexao->Alterar($cmdSql);
    }
}