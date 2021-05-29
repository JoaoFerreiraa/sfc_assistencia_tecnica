<?php
require_once 'Conexao.php';

Class Usuario{
    private $cod, $usuario, $nome, $funcao, $nivel, $senha;
    
    function getCod() {
        return $this->cod;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getNome() {
        return $this->nome;
    }

    function getFuncao() {
        return $this->funcao;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getSenha() {
        return $this->senha;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setSenhaSemCript($senha) {
        $this->senha = $senha;
    }
    
    function setSenha($senha) {
        $this->senha = password_hash($senha, 1);
    }

    private function decriptSenha($senha){
        return password_verify($senha, $this->senha);
    }

    function criar(){
        $objConexao = new Conexao();

        $hashNome = explode(" ", microtime());
        $hashNome = round((float) $hashNome[0]*10000,0);
        if($hashNome < 1000)
        $hashNome *= 10;
        $hashNome .= date("s");

        $nome = $this->getNome();
        $nome = strtoupper(substr($nome,0,2));
        $this->setUsuario($nome."".$hashNome);


        $hashNome = (int) ($hashNome + ($hashNome/2));
        $senha = $nome."".$hashNome;
        $this->setSenha($senha);

        echo '<script>alert("User:'.$this->getUsuario().' Senha:'.$senha.'")</script>';

        $cmdSql = "CALL usuario_criar('".$this->usuario."','".$this->nome."','".$this->funcao."','".$this->nivel."','".$this->senha."')";
        return $objConexao->Inserir($cmdSql);
    }

    function consulta_usuario_por_usuario(){
        $objConexao = new Conexao();
        $cmdSql = "CALL usuario_consultaPorUsuario('".$this->usuario."')";
        $retorno = $objConexao->Consultar($cmdSql)[0];
        
        if(isset($retorno)){
            $this->setNome($retorno['nome']);
            $this->setUsuario($retorno['usuario']);
            $this->setFuncao($retorno['funcao']);
            $this->setNivel($retorno['nivel']);
            $this->setSenhaSemCript($retorno['senha']);
            $this->setCod($retorno['cod']);
            return true;
        }else{
            return false;
        }
    }

    function consulta_usuario_por_cod(){
        $objConexao = new Conexao();
        $cmdSql = "CALL usuario_consultaPorcod('".$this->cod."')";
        $retorno = $objConexao->Consultar($cmdSql)[0];
        
        if(isset($retorno)){
            $this->setNome($retorno['nome']);
            $this->setUsuario($retorno['usuario']);
            $this->setFuncao($retorno['funcao']);
            $this->setNivel($retorno['nivel']);
            $this->setSenhaSemCript($retorno['senha']);
            $this->setCod($retorno['cod']);
            return true;
        }else{
            return false;
        }
    }

    function login($senha){
        if($this->consulta_usuario_por_usuario())
            if(password_verify($senha, $this->senha))
                return true;

        return false;
    }
}