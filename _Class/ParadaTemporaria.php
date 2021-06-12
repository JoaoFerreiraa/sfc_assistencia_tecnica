<?php

class ParadaTemporaria
{
    private $cod,
        $cod_folha,
        $cod_tec,
        $motivo,
        $status_parada;

    public function getCod()
    {
        return $this->cod;
    }

    public function setCod($cod)
    {
        $this->cod = $cod;
    }

    public function getCod_folha()
    {
        return $this->cod_folha;
    }

    public function setCod_folha($cod_folha)
    {
        $this->cod_folha = $cod_folha;
    }

    public function getCod_Tecnico()
    {
        return $this->cod_tec;
    }

    public function setCod_Tecnico($cod_tec)
    {
        $this->cod_tec = $cod_tec;
    }

    public function getMotivo()
    {
        return $this->motivo;
    }

    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
    }

    public function getStatus_parada()
    {
        return $this->status_parada;
    }

    public function setStatus_parada($status_parada)
    {
        $this->status_parada = $status_parada;
    }

    function criar()
    {
        $objConexao = new Conexao();

        $cmdSql = "Call paradaTemporaria_criar(" . $this->cod_folha . "," . $this->cod_tec . ",'" . $this->motivo . "')";
        if ($objConexao->Inserir($cmdSql)) {
            $this->adicionar_log($_SESSION['usuario']['nome'], 'Colocou a máquina em parada temporária por falta de componente: Motivo: '.$this->motivo, 'parada_temporaria', $this->cod_folha);
            return true;
        } else
            return false;
    }

    function editar()
    {
        $objConexao = new Conexao();
        $cmdSql = "paradaTemporaria_editar()";

        $this->adicionar_log($_SESSION['usuario']['nome'], "Alterou o status de parada temporaria desta folha.", "parada_temporaria", $this->cod_folha);
        return $objConexao->Alterar($cmdSql);
    }

    function removerParada()
    {
        $objConexao = new Conexao();

        $cmdSql = "Call paradaTemporaria_remover(" . $this->cod_folha . ")";
        if ($objConexao->Deletar($cmdSql)) {
            $this->adicionar_log($_SESSION['usuario']['nome'], 'Removeu a parada temporária da máquina! Máquina em reparo', 'parada_temporaria', $this->cod_folha);
            return true;
        } else
            return false;
    }

    function consultarPorCodFolha()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL paradaTemporaria_consultarPorCodFolha(" . $this->cod_folha . ")";
        $return = $objConexao->Consultar($cmdSql);
        $return = $return != false ? $return[0] : false;

        if ($return != false) {
            $this->cod = $return['cod'];
            $this->cod_folha = $return['cod_folha'];
            $this->cod_tec = $return['cod_usuario'];
            $this->motivo = $return['motivo'];
            $this->status_parada = $return['status_parada'];
            return $return;
        } else
            return false;
    }

    function adicionar_log($usuario, $log, $tabela, $cod_folha)
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL logs_criar('" . $usuario . "','" . $log . "','" . $tabela . "', " . $cod_folha . ")";
        return $objConexao->Inserir($cmdSql);
    }
}
