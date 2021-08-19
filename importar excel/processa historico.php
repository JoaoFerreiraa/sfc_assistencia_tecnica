<?php
require_once dirname(__DIR__) . '/_Class/FolhaDeRosto.php';
var_dump($_FILES['arquivo']);
if (!empty($_FILES['arquivo']['tmp_name'])) {
    $arquivo = new \DOMDocument();
    $arquivo->load($_FILES['arquivo']['tmp_name']);

    $linhas = $arquivo->getElementsByTagName("Row");


    echo '<table>
    <tr>
      <th>Data de Entrada na Assistência</th>
      <th>Tipo de Solicitação</th>
      <th>Cliente</th>
      <th>Reincidência</th>
      <th>Numero de serie</th>
      <th>Part Number</th>
      <th>Estética</th>
      <th>Falha Relatada</th>
      <th>Defeito encontrado</th>
      <th>Solução</th>
      <th>Peças / Ajustes</th>
      <th>Técnico Responsável</th>
      <th>Data Saida assistencia</th>
      <th>Burnin Test</th>
      <th>Causa Reincidencia</th>
      </tr>
    <tr>';

    foreach ($linhas as $linha) {
        $objFolhaDeRosto = new FolhaDeRosto();
        $objFolhaDeRosto->setUsuario(2021);
        
        
        $objFolhaDeRosto->setAcompanha_fonte('-');
        
        $modelo = file_get_contents('../assets/data/partNumber.json');
        $jsonModelo = json_decode($modelo, true);

    

        $objFolhaDeRosto->setModelo('-');
        $objFolhaDeRosto->setObservacao('-');
        
        echo '<tr>';
        $dados = $linha->getElementsByTagName("Data")->item(0);
        if (!empty($dados->nodeValue)) {
            $objFolhaDeRosto->setLancamento_almoxarife($dados->nodeValue);
            //ENTRADA ASSISTENCIA
            $objFolhaDeRosto->setEntrada_laboratorio($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(1);
        if (!empty($dados->nodeValue)) {
            //TIPO SOLICITACAO
            $objFolhaDeRosto->setTipo_solicitacao($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(2);
        if (!empty($dados->nodeValue)) {
            //CLIENTE
            $objFolhaDeRosto->setNome_cliente($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(3);
        if (!empty($dados->nodeValue)) {
            //REINCIDENCIA
            $objFolhaDeRosto->setReincidencia($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(4);
        if (!empty($dados->nodeValue)) {
            //NUMERO DE SERIE
            $objFolhaDeRosto->setNumero_serie($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(5);
        if (!empty($dados->nodeValue)) {
            //PART NUMBER
            $objFolhaDeRosto->setPart_number($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';

            if (array_key_exists($dados->nodeValue, $jsonModelo)) 
                $objFolhaDeRosto->setModelo($jsonModelo[$dados->nodeValue]);
            
        }
        $dados = $linha->getElementsByTagName("Data")->item(6);
        if (!empty($dados->nodeValue)) {
            //ESTETICA
            if(strlen($dados->nodeValue) > 4)
            $objFolhaDeRosto->setDesc_estetica_equipamento($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(7);
        if (!empty($dados->nodeValue)) {
            //FALHA RELATADA
            if(strlen($dados->nodeValue) > 4)
            $objFolhaDeRosto->setDesc_defeito_reclamado($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(8);
        if (!empty($dados->nodeValue)) {
            //DEFEITO ENCONTRADO
            $objFolhaDeRosto->setDefeito_apresentado($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(9);
        if (!empty($dados->nodeValue)) {
            //SOLUCAO
            if(strlen($dados->nodeValue) > 4)
            $objFolhaDeRosto->setServicos_executados($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(11);
        if (!empty($dados->nodeValue)) {
            //PECAS
            if(strlen($dados->nodeValue) > 4)
            $objFolhaDeRosto->setPecas_trocadas($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }
        $dados = $linha->getElementsByTagName("Data")->item(12);
        if (!empty($dados->nodeValue)) {
            //TECNICO RESPONSAVEL
            $objFolhaDeRosto->setTec_responsavel_old($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }

        $dados = $linha->getElementsByTagName("Data")->item(13);
        if (!empty($dados->nodeValue)) {
            //DATA SAIDA ASSISTENCIA
            $objFolhaDeRosto->setLaudo_emitido($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }

        $dados = $linha->getElementsByTagName("Data")->item(14);
        if (!empty($dados->nodeValue)) {
            //BURNIN TEST
            $objFolhaDeRosto->setBurnin_test($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }

        $dados = $linha->getElementsByTagName("Data")->item(15);
        if (!empty($dados->nodeValue)) {
            //CAUSA REINCIDENCIA
            $objFolhaDeRosto->setCausa_reincidencia($dados->nodeValue);
            echo '<td>' . $dados->nodeValue . '</td>';
        }

        var_dump($objFolhaDeRosto->importar());
        echo '</tr>';
    }

    echo '
    </tr>
  </table>';
}
