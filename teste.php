<?php
$sigla = "ifls";
$senhaservice = "3cbc9297633c3b86da803adfb7ac4d0f";
$servicekey = md5($sigla . $senhaservice . date("Ymd"));
$wsdl = "http://www.mysuite1.com.br/empresas/ifls/webservices/
AtendimentoOnline.php?wsdl&sigla=ifls&servicekeywsdl=729e1542a2a67a2bb4cffe59d4b5ba3e";
try{
$client = new SoapClient($wsdl, array());


}catch(Exception $e){
    $e->getMessage();
}
$request = new stdclass();
$request->sigla = $sigla;
$request->servicekey = $servicekey;
$request->dados = new stdclass();
$request->dados->atendimentoinicio = "2016/06/07"; // Data a ser consultada
$request->dados->atendimentofinal = "2016/06/07"; // Data a ser consultada
$result = $client->obterListaAnonimo($request);
echo "<pre>" . $wsdl . "<br><br>" . print_r($result, true);
?>
--php -S localhost:8000
-- na web localhost:8000