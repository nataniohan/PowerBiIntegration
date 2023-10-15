<?php

$sigla = "ifls";
$senhaservice = "3cbc9297633c3b86da803adfb7ac4d0f";
$servicekey = md5($sigla . $senhaservice . date("Ymd"));
$wsdl="https://www.mysuite1.com.br/empresas/ifls/webservices/AtendimentoOnline.php?wsdl&sigla=ifls&servicekeywsdl=729e1542a2a67a2bb4cffe59d4b5ba3e";

try{
    $client = new SoapClient($wsdl,array());

    $request = new stdclass();
    $request->sigla = $sigla;
    $request->servicekey = $servicekey;
    
    $request->dados = new stdclass();
    $request->dados->atendimentoinicio = "2023/09/26"; // Data a ser consultada
    $request->dados->atendimentofinal = "2023/09/29"; // Data a ser consultada
   


    $response = $client->obterListaIdentificado($request);
    echo "<pre>" . $wsdl . "<br><br>" . print_r($response, true);

    $recebe = get_object_vars($response);
    $dados = $recebe["dados"];
    $arrayTranform = [];

    foreach($dados as $dadosTransfom){
        $arrayTranformLocal = get_object_vars($dadosTransfom);
        array_push($arrayTranform, $arrayTranformLocal);
    };
    
    foreach($arrayTranform as $percorre){
    /*nao tem [idatendimentoorigem], [idatendimentogerado], [unidade]*/
        $idatendimento = (int) $percorre['idatendimento'];
        $codatendimento = (int) $percorre['codatendimento'];
        $codusuario = (int) $percorre['codusuario'];
        $apelido = (string) $percorre['apelido'];
        $codcliente = (int) $percorre['codcliente'];
        $nome = (string) $percorre['nome'];
        $email = (string) $percorre['email'];
        $codempresa = (string) $percorre['codempresa'];
        $codigooriginal = (int) $percorre['codigooriginal'];
        $empresa = (string) $percorre['empresa'];
        $dataSolicitacao = date('Y-m-d H:i:s', $percorre['datasolicitacao']);
        $dataSolicitacaoCon = strtotime($dataSolicitacao);
        $hrSolicitacao = date('H:i:s', $percorre['datasolicitacao']);
        $dataAtendimento = date('Y-m-d H:i:s', $percorre['dataatendimento']);
        $dataAtendimentoCon = strtotime($dataAtendimento);
        $hrAtendimento = date('H:i:s', $percorre['dataatendimento']);
        $dataClienteSaiu = date('d-m-Y', $percorre['dataclientesaiu']);
        $HrClienteSaiu = date('H:i:s', $percorre['dataclientesaiu']);
        $dataFinalizacao = date('d-m-Y', $percorre['datafinalizacao']);
        $hrFinalizacao = date('H:i:s', $percorre['datafinalizacao']);
        $classificacao = (string) $percorre['classificacao'];
        $departamento = (string) $percorre['departamento'];
        $avaliacao = (string) $percorre['avaliacao'];
        $codavaliacao = (string) $percorre['codavaliacao'];
        $iddepartamento = (int) $percorre['iddepartamento'];
        $tempo = gmdate ('H:i:s',$percorre['tempo']);
        $duracao = gmdate ('H:i:s',$percorre['duracao']);

        $diferenca = ($dataAtendimentoCon - $dataSolicitacaoCon)/60;

        /*echo 'Data solicitacao: '.$dataSolicitacao.' Hora solicitacao: '.$hrSolicitacao.'<br><br>'.' data do atendimento: '.$dataAtendimento.'hora do atendimento:
         '.$hrAtendimento.'<br><br> data cliente saiu:: '.$dataClienteSaiu.' hora cliente saiu: '.$HrClienteSaiu.'<br><br> data finalizacao: '.$dataFinalizacao.' hr finalizacao: '.$hrFinalizacao.'tempo: '.
         $tempo.'duracao: '.$duracao.'<hr>';*/

         echo 'data solicitacao: '.$dataSolicitacao.'<br>'.' data atendimento'.$dataAtendimento.'diferenteca: '.'<br><br>'.$diferenca.'<br>';
    }


    }catch(Exception $e){
        $e->getMessage();
    };
    ?>