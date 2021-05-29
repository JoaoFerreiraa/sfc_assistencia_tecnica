<?php
require_once 'Conexao.php';

class FolhaDeRosto
{
    private $cod,
        $usuario,
        $lancamento_almoxarife,
        $entrada_laboratorio,
        $saida_laboratorio,
        $laudo_emitido,
        $saida_logistica,
        $tipo_solicitacao,
        $nome_cliente,
        $modelo,
        $numero_serie,
        $part_number,
        $reincidencia,
        $acompanha_fonte,
        $desc_estetica_equipamento,
        $desc_defeito_reclamado,
        $defeito_apresentado,
        $pecas_trocadas,
        $orcamento,
        $servicos_executados,
        $observacao,
        $tec_responsavel_old,
        $burnin_test,
        $causa_reincidencia;


    function getCod()
    {
        return $this->cod;
    }

    function getLancamento_almoxarife()
    {
        return $this->lancamento_almoxarife;
    }

    function getEntrada_laboratorio()
    {
        return $this->entrada_laboratorio;
    }

    function getSaida_laboratorio()
    {
        return $this->saida_laboratorio;
    }

    function getLaudo_emitido()
    {
        return $this->laudo_emitido;
    }

    function getSaida_logistica()
    {
        return $this->saida_logistica;
    }

    function getTipo_solicitacao()
    {
        return $this->tipo_solicitacao;
    }

    function getNome_cliente()
    {
        return $this->nome_cliente;
    }

    function getModelo()
    {
        return $this->modelo;
    }

    function getNumero_serie()
    {
        return $this->numero_serie;
    }

    function getPart_number()
    {
        return $this->part_number;
    }

    function getReincidencia()
    {
        return $this->reincidencia;
    }

    function getAcompanha_fonte()
    {
        return $this->acompanha_fonte;
    }

    function getDesc_estetica_equipamento()
    {
        return $this->desc_estetica_equipamento;
    }

    function getDesc_defeito_reclamado()
    {
        return $this->desc_defeito_reclamado;
    }

    function getDefeito_apresentado()
    {
        return $this->defeito_apresentado;
    }

    function getPecas_trocadas()
    {
        return $this->pecas_trocadas;
    }

    function getOrcamento()
    {
        return $this->orcamento;
    }

    function getServicos_executados()
    {
        return $this->servicos_executados;
    }

    function getUsuario()
    {
        return $this->usuario;
    }

    function getBurnin_test()
    {
        return $this->burnin_test;
    }

    function getCausa_reincidencia()
    {
        return $this->causa_reincidencia;
    }

    function getObservacao()
    {
        return $this->observacao;
    }

    function setObservacao($observacao)
    {
        $this->observacao = $observacao;
    }

    function setBurnin_test($burnin_test)
    {
        $this->burnin_test = $burnin_test;
    }


    function setCausa_reincidencia($causa_reincidencia)
    {
        $this->causa_reincidencia = $causa_reincidencia;
    }

    function setTec_responsavel_old($tec_responsavel_old)
    {
        $this->tec_responsavel_old = $tec_responsavel_old;
    }

    function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    function setCod($cod)
    {
        $this->cod = $cod;
    }

    function setLancamento_almoxarife($lancamento_almoxarife)
    {
        $this->lancamento_almoxarife = $lancamento_almoxarife;
    }

    function setEntrada_laboratorio($entrada_laboratorio)
    {
        $this->entrada_laboratorio = $entrada_laboratorio;
    }

    function setSaida_laboratorio($saida_laboratorio)
    {
        $this->saida_laboratorio = $saida_laboratorio;
    }

    function setLaudo_emitido($laudo_emitido)
    {
        $this->laudo_emitido = $laudo_emitido;
    }

    function setSaida_logistica($saida_logistica)
    {
        $this->saida_logistica = $saida_logistica;
    }

    function setTipo_solicitacao($tipo_solicitacao)
    {
        $this->tipo_solicitacao = $tipo_solicitacao;
    }

    function setNome_cliente($nome_cliente)
    {
        $this->nome_cliente = $nome_cliente;
    }

    function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    function setNumero_serie($numero_serie)
    {
        $this->numero_serie = $numero_serie;
    }

    function setPart_number($part_number)
    {
        $this->part_number = $part_number;
    }

    function setReincidencia($reincidencia)
    {
        $this->reincidencia = $reincidencia;
    }

    function setAcompanha_fonte($acompanha_fonte)
    {
        $this->acompanha_fonte = $acompanha_fonte;
    }

    function setDesc_estetica_equipamento($desc_estetica_equipamento)
    {
        $this->desc_estetica_equipamento = $desc_estetica_equipamento;
    }

    function setDesc_defeito_reclamado($desc_defeito_reclamado)
    {
        $this->desc_defeito_reclamado = $desc_defeito_reclamado;
    }

    function setDefeito_apresentado($defeito_apresentado)
    {
        $this->defeito_apresentado = $defeito_apresentado;
    }

    function setPecas_trocadas($pecas_trocadas)
    {
        $this->pecas_trocadas = $pecas_trocadas;
    }

    function setOrcamento($orcamento)
    {
        $this->orcamento = $orcamento;
    }

    function setServicos_executados($servicos_executados)
    {
        $this->servicos_executados = $servicos_executados;
    }

    function importar()
    {
        $objConexao = new Conexao();
        $cmdSql = "Call folhaDeRosto_importarExcel('" . $this->usuario . "','" . $this->lancamento_almoxarife . "','" . $this->entrada_laboratorio . "','" . $this->tipo_solicitacao . "','" . $this->nome_cliente . "','" . $this->modelo . "','" . $this->numero_serie . "','" . $this->part_number . "','" . $this->reincidencia . "','" . $this->acompanha_fonte . "','" . $this->desc_estetica_equipamento . "','" . $this->desc_defeito_reclamado . "', '" . $this->observacao . "','" . $this->tec_responsavel_old . "','" . $this->pecas_trocadas . "','" . $this->servicos_executados . "','" . $this->defeito_apresentado . "','" . $this->laudo_emitido . "','" . $this->burnin_test . "', '" . $this->causa_reincidencia . "')";
        // var_dump($cmdSql);
        return $objConexao->Inserir($cmdSql);
    }

    function criar()
    {
        $objConexao = new Conexao();
        $cmdSql = "Call folhaDeRosto_criar('" . $this->usuario . "','" . $this->lancamento_almoxarife . "','" . $this->tipo_solicitacao . "','" . $this->nome_cliente . "','" . $this->modelo . "','" . $this->numero_serie . "','" . $this->part_number . "','" . $this->reincidencia . "','" . $this->acompanha_fonte . "','" . $this->desc_estetica_equipamento . "','" . $this->desc_defeito_reclamado . "', '" . $this->observacao . "')";

        $ultima_folha = $this->consultar_ultima();
        $this->adicionar_log($_SESSION['usuario']['nome'], "Criou uma folha de rosto", "Folha de Rosto", ($ultima_folha[0]['cod'] + 1));
        return $objConexao->Inserir($cmdSql);
    }

    function alterar_dataEntradaLab()
    {
        $objConexao = new Conexao();
        $cmdSql = "Call folhaDeRosto_mudarEntradaLaboratorio(" . $this->cod . ",'" . $this->entrada_laboratorio . "')";

        $this->adicionar_log($_SESSION['usuario']['nome'], "Atualizou a data de inicio do aging", "Folha de Rosto", $this->cod);

        return $objConexao->Alterar($cmdSql);
    }

    function consultar_todas_limitada()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_consultarTodasLimitada()";
        $resultado = $objConexao->Consultar($cmdSql);
        if (isset($resultado)) {
            return $resultado;
        } else
            return false;
    }


    function consultar_todas_limitada_ext()
    {
        $objConexao = new Conexao();
        $cmdSql = "SELECT * FROM `folha_de_rosto` order by folha_de_rosto.cod DESC LIMIT 400";
        $resultado = $objConexao->Consultar($cmdSql);
        if (isset($resultado)) {
            return $resultado;
        } else
            return false;
    }

    function consultar_todas()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_consultarTodas()";
        $resultado = $objConexao->Consultar($cmdSql);
        if (isset($resultado)) {
            return $resultado;
        } else
            return false;
    }
    function consultar_por_codigo()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_consultarPorCodigo(" . $this->cod . ")";
        $resultado = $objConexao->Consultar($cmdSql)[0];
        if (isset($resultado)) {
            $this->cod = $resultado['cod'];
            $this->usuario = $resultado['usuario'];
            $this->lancamento_almoxarife = $resultado['lancamento_almoxarife'];
            $this->entrada_laboratorio = $resultado['entrada_laboratorio'];
            $this->saida_laboratorio = $resultado['saida_laboratorio'];
            $this->laudo_emitido = $resultado['laudo_emitido'];
            $this->saida_logistica = $resultado['saida_logistica'];
            $this->tipo_solicitacao = $resultado['tipo_solicitacao'];
            $this->nome_cliente = $resultado['nome_cliente'];
            $this->modelo = $resultado['modelo'];
            $this->numero_serie = $resultado['numero_serie'];
            $this->part_number = $resultado['part_number'];
            $this->reincidencia = $resultado['reincidencia'];
            $this->acompanha_fonte = $resultado['acompanha_fonte'];
            $this->desc_estetica_equipamento = $resultado['desc_estetica_equipamento'];
            $this->desc_defeito_reclamado = $resultado['desc_defeito_reclamado'];
            $this->defeito_apresentado = $resultado['defeito_apresentado'];
            $this->pecas_trocadas = $resultado['pecas_trocadas'];
            $this->orcamento = $resultado['orcamento'];
            $this->servicos_executados = $resultado['servicos_executados'];
            $this->burnin_test = $resultado['burnin_test'];
            $this->causa_reincidencia = $resultado['causa_reincidencia'];
            $this->observacao = $resultado['observacao'];
            return $resultado;
        } else
            return false;
    }

    function consultar_por_serial()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_consultarPorSerial('" . $this->numero_serie . "')";
        $resultado = $objConexao->Consultar($cmdSql)[0];
        if (isset($resultado)) {
            $this->cod = $resultado['cod'];
            $this->usuario = $resultado['usuario'];
            $this->lancamento_almoxarife = $resultado['lancamento_almoxarife'];
            $this->entrada_laboratorio = $resultado['entrada_laboratorio'];
            $this->saida_laboratorio = $resultado['saida_laboratorio'];
            $this->laudo_emitido = $resultado['laudo_emitido'];
            $this->saida_logistica = $resultado['saida_logistica'];
            $this->tipo_solicitacao = $resultado['tipo_solicitacao'];
            $this->nome_cliente = $resultado['nome_cliente'];
            $this->modelo = $resultado['modelo'];
            $this->numero_serie = $resultado['numero_serie'];
            $this->part_number = $resultado['part_number'];
            $this->reincidencia = $resultado['reincidencia'];
            $this->acompanha_fonte = $resultado['acompanha_fonte'];
            $this->desc_estetica_equipamento = $resultado['desc_estetica_equipamento'];
            $this->desc_defeito_reclamado = $resultado['desc_defeito_reclamado'];
            $this->defeito_apresentado = $resultado['defeito_apresentado'];
            $this->pecas_trocadas = $resultado['pecas_trocadas'];
            $this->orcamento = $resultado['orcamento'];
            $this->servicos_executados = $resultado['servicos_executados'];
            $this->burnin_test = $resultado['burnin_test'];
            $this->causa_reincidencia = $resultado['causa_reincidencia'];
            $this->observacao = $resultado['observacao'];
            return $resultado;
        } else
            return false;
    }

    function consultar_reincidencia()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_consultarReincidencias('" . $this->numero_serie . "')";
        $resultado = $objConexao->Consultar($cmdSql);
        if (isset($resultado)) {
            return $resultado;
        } else
            return false;
    }

    function consultar_por_usuario()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_consultarPorUsuario('" . $this->usuario . "')";
        $resultado = $objConexao->Consultar($cmdSql);
        if (isset($resultado)) {
            return $resultado;
        } else
            return false;
    }

    function consultar_ultima()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_consultaUltimaFolha()";
        $resultado = $objConexao->Consultar($cmdSql);
        if (isset($resultado)) {
            return $resultado;
        } else
            return 0;
    }

    function editar_por_cod_AT()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_editarPorCodAT(" . $this->cod . ",'" . $this->part_number . "','" . $this->modelo . "','" . $this->entrada_laboratorio . "','" . $this->tipo_solicitacao . "','" . $this->reincidencia . "','" . $this->defeito_apresentado . "','" . $this->pecas_trocadas . "','" . $this->servicos_executados . "', '" . $this->numero_serie . "','" . $this->burnin_test . "','" . $this->causa_reincidencia . "')";
        $this->adicionar_log($_SESSION['usuario']['nome'], "Atualizou a folha de rosto", "Folha de Rosto", $this->cod);

        return $objConexao->Alterar($cmdSql);
    }

    function editar_administrativo()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_editarAdministrativo(" . $this->cod . ",'" . $this->lancamento_almoxarife . "','" . $this->tipo_solicitacao . "','" . $this->nome_cliente . "','" . $this->modelo . "','" . $this->numero_serie . "','" . $this->part_number . "','" . $this->reincidencia . "','" . $this->acompanha_fonte . "','" . $this->desc_estetica_equipamento . "','" . $this->desc_defeito_reclamado . "','" . $this->observacao . "')";
        $this->adicionar_log($_SESSION['usuario']['nome'], "Atualizou a folha de rosto", "Folha de Rosto", $this->cod);
        return $objConexao->Alterar($cmdSql);
    }

    function editar_laudo_emitido()
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_editarLaudoEmitido(" . $this->cod . ",'" . $this->laudo_emitido . "')";

        $this->adicionar_log($_SESSION['usuario']['nome'], "Finalizou o aging da maquina. Laudo emitido.", "Laudo Emitido e Folha de Rosto", $this->cod);

        return $objConexao->Alterar($cmdSql);
    }

    function adicionar_log($usuario, $log, $tabela, $cod_folha)
    {
        $objConexao = new Conexao();
        $cmdSql = "CALL logs_criar('" . $usuario . "','" . $log . "','" . $tabela . "', " . $cod_folha . ")";
        return $objConexao->Inserir($cmdSql);
    }
}
