<?php
$hostname = "localhost";
$bancodedados = "powerbi";
$usuario = "root";
$senha="";

$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
if ($mysqli->connect_errno){
    echo "Falha ao conectar: (" .$mysqli->connect_errno. ")";
}
else
    echo "Conectado ao banco de dados";

$conexao = mysqli_connect($hostname, $usuario, $senha, $bancodedados);

$sigla = "ifls";
$senhaservice = "3cbc9297633c3b86da803adfb7ac4d0f";
$servicekey = md5($sigla . $senhaservice . date("Ymd"));
$wsdl="https://www.mysuite1.com.br/empresas/ifls/webservices/AtendimentoOnline.php?wsdl&sigla=ifls&servicekeywsdl=729e1542a2a67a2bb4cffe59d4b5ba3e";


try{
    $hoje = date('Y/m/d');

    $client = new SoapClient($wsdl,array());

    $request = new stdclass();
    $request->sigla = $sigla;
    $request->servicekey = $servicekey;

    $request->dados = new stdclass();
    $request->dados->atendimentoinicio = "2023/09/01"; // Data a ser consultada
    $request->dados->atendimentofinal = $hoje; // Data a ser consultada
    /*$request->dados->codclassificacao = "1";*/


    $response = $client->obterListaIdentificado($request);
    $verifica = gettype($response);
    echo $verifica;
    $recebe = get_object_vars($response);
    /*echo var_dump($recebe);*/
    $verifica2 = gettype($recebe);
    echo $verifica2;


    /*echo $recebe["dados"][0]["idatendimento".];*/
    echo "<pre>" . $wsdl . "<br><br>" . print_r($response, true);
    /*var_dump($recebe["dados"][20]);*/
    /*print_r($recebe["dados"][0]["apelido"]);*/


    $dados = $recebe["dados"];//obtendo os objetos do array dados
    /*print_r($dados);*/
    $arrayTranform = []; //array vazio para receber os dados tranformados

    //loop para tranformar os dados e inserir eles na ultima posicao do array
    foreach($dados as $dadosTransfom){
        $arrayTranformLocal = get_object_vars($dadosTransfom);
        array_push($arrayTranform, $arrayTranformLocal);
    };
    /*print_r($arrayTranform);
    /*var_dump($novoArray);*/

    foreach($arrayTranform as $percorre){
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
        $datasolicitacao = (int) $percorre['datasolicitacao'];
        $avaliacao = (string) $percorre['avaliacao'];
        $codavaliacao = (string) $percorre['codavaliacao'];
        $iddepartamento = (int) $percorre['iddepartamento'];
        $temp = (int) $percorre['tempo'];
        $duracao = (int) $percorre['duracao'];

        $query = "insert into dados(idatendimento, codatendimento, codusuario, apelido, codcliente, nome, email, codempresa, codigooriginal, empresa, datasolicitacao, avaliacao, codavaliacao, iddepartamento, tempo, duracao) values('".$idatendimento."', '".$codatendimento."', '".$codusuario."', '".$apelido."', '".$codcliente."', '".$nome."', '".$email."', '".$codempresa."', '".$codigooriginal."', '".$empresa."', '".$datasolicitacao."', '".$avaliacao."', '".$codavaliacao."', '".$iddepartamento."', '".$temp."', '".$duracao."')";
        /*print_r(gettype($percorre['tempo']));*/

        $res = mysqli_query($conexao,$query);

        if($res){
            echo "inserido com sucesso";
        }else{
            echo"falha ao inserir";
        };
    }



    }catch(Exception $e){
        $e->getMessage();
    }

?>