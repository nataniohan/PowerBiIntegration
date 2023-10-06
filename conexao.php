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

$numero = 1;
$descricao = "natan iohan";

$query = "insert into dados(idatendimento, codatendimento, codusuario, apelido, codcliente, nome, email, codempresa, codigooriginal, empresa, datasolicitacao, avaliacao, codavaliacao, iddepartamento, tempo, duracao) values('".$numero."', '".$descricao."')";
$res = mysqli_query($conexao,$query);

if($res){
    echo "inserido com sucessso";
}else{
    echo"falha ao inserir";
}

?>