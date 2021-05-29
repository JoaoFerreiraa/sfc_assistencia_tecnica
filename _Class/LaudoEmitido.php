
<?php
require_once 'Conexao.php';

Class LaudoEmitido{
    private $cod;	
    private $modelo_maquina;	
    private $serial_number;	
    private $pecas_trocadas;	
	private $tec_emissor;
	private $cod_folha;	

    public function getCod(){
		return $this->cod;
	}

	public function setCod($cod){
		$this->cod = $cod;
	}

	public function getModelo_maquina(){
		return $this->modelo_maquina;
	}

	public function setModelo_maquina($modelo_maquina){
		$this->modelo_maquina = $modelo_maquina;
	}

	public function getSerial_number(){
		return $this->serial_number;
	}

	public function setSerial_number($serial_number){
		$this->serial_number = $serial_number;
	}

	public function getCod_folha(){
		return $this->cod_folha;
	}

	public function setCod_folha($cod_folha){
		$this->cod_folha = $cod_folha;
	}

	public function getPecas_trocadas(){
		return $this->pecas_trocadas;
	}

	public function setPecas_trocadas($pecas_trocadas){
		$this->pecas_trocadas = $pecas_trocadas;
	}

	public function getTec_emissor(){
		return $this->tec_emissor;
	}

	public function setTec_emissor($tec_emissor){
		$this->tec_emissor = $tec_emissor;
    }
    
    public function criar(){
        $objConexao = new Conexao();
        $cmdSql = "Call laudoEmitido_criar('".$this->modelo_maquina."','".$this->serial_number."','".$this->pecas_trocadas."',".$this->tec_emissor.",".$this->cod_folha.")";
        return $objConexao->Inserir($cmdSql);
    }

    public function consultar_por_serial(){
        $objConexao = new Conexao();
        $cmdSql = "CALL laudoEmitido_consultarPorSerial('".$this->serial_number."')";
        $resultado = $objConexao->Consultar($cmdSql);
        if(isset($resultado)){
            return $resultado;
        }else
            return false;
    }

    function editar_por_serial(){
        $objConexao = new Conexao();
        $cmdSql = "CALL folhaDeRosto_editarPorCodAT('".$this->serial_number."',".$this->tec_emissor.",'".$this->modelo_maquina."','".$this->pecas_trocadas."')";
        return $objConexao->Alterar($cmdSql);
	}
	
	function consultar_por_folha(){
		$objConexao = new Conexao();
        $cmdSql = "CALL laudoEmitido_consultarPorFolha (".$this->cod_folha.")";
        return $objConexao->Consultar($cmdSql);
	}

}