
<?php
require_once 'Conexao.php';

class Revisao
{
    private $cod;
    private $cod_folha;
    private $status;
    private $revisor;
    private $tec_destinatario;
    private $motivo;

    public function getCod(){
		return $this->cod;
	}

	public function setCod($cod){
		$this->cod = $cod;
	}

	public function getCod_folha(){
		return $this->cod_folha;
	}

	public function setCod_folha($cod_folha){
		$this->cod_folha = $cod_folha;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getRevisor(){
		return $this->revisor;
	}

	public function setRevisor($revisor){
		$this->revisor = $revisor;
	}

	public function getTec_destinatario(){
		return $this->tec_destinatario;
	}

	public function setTec_destinatario($tec_destinatario){
		$this->tec_destinatario = $tec_destinatario;
	}
	
	public function getMotivo(){
		return $this->motivo;
	}

	public function setMotivo($motivo){
		$this->motivo = $motivo;
    }
    
    public function criar(){
        $objConexao = new Conexao();

		$cmdSql = "Call revisao_criar(".$this->cod_folha.",".$this->status.")";

		$revisaoFolha = $this->consultar_porCodFolha($this->cod_folha);
		if($revisaoFolha !== false){
			return $this->editar_por_codigo_folha();
		}else{
			
			$this->adicionar_log($_SESSION['usuario']['cod'],"Máquina pronta para ser revisada","Revisao",$this->cod_folha);
			return $objConexao->Inserir($cmdSql);
		}
	}
	
	public function consultar_todos(){
		$objConexao = new Conexao();
		$cmdSql = "call revisao_consultarTodos()";
		$retorno = $objConexao->Consultar($cmdSql);
		if(isset($retorno)){
			return $retorno;
		}else{
			return false;
		}
	}

	public function consultar_porCodFolha(){
		$objConexao = new Conexao();
		$cmdSql = "call revisao_consultarPorCodFolha(".$this->cod_folha.")";
		$retorno = $objConexao->Consultar($cmdSql);
		if(isset($retorno)){
			return $retorno;
		}else{
			return false;
		}
	}

	public function consultar_maquinas_para_voltar(){
		$objConexao = new Conexao();
		$cmdSql = "call revisao_consultarMaquinasParaVoltar()";
		$retorno = $objConexao->Consultar($cmdSql);
		if(isset($retorno)){
			return $retorno;
		}else{
			return false;
		}
	}

	public function editar(){
		$objConexao = new Conexao();
		$cmdSql = "Call revisao_editar(".$this->cod.",".$this->status.",'".$this->motivo."',".$this->revisor.")";
		if($this->status == 2){
			$this->adicionar_log($_SESSION['usuario']['cod'],"A máquina voltou para o técnico","Revisao",$this->cod_folha);
		}else{
			$this->adicionar_log($_SESSION['usuario']['cod'],"Máquina pronta para geração de laudo","Revisao",$this->cod_folha);
		}
		
        return $objConexao->Alterar($cmdSql);
		
	}
	public function editar_por_codigo_folha(){
		$objConexao = new Conexao();
		$cmdSql = "Call revisao_editarPorCodigoFolha(".$this->cod_folha.",".$this->status.",'".$this->motivo."',".$this->revisor.")";
		$this->adicionar_log($_SESSION['usuario']['cod'],"Máquina pronta para geração de laudo","Revisao",$this->cod_folha);
        return $objConexao->Alterar($cmdSql);
		
	}

	function adicionar_log($usuario, $log, $tabela, $cod_folha){
        $objConexao = new Conexao();
		$cmdSql = "CALL logs_criar(".$usuario.",'".$log."','".$tabela."', ".$cod_folha.")";
        return $objConexao->Inserir($cmdSql);
    }
}
