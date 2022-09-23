<?php
header('Content-type: text/html; charset=utf-8; application/json');

session_start();

require './Slim/Slim.php';
\Slim\Slim::registerAutoloader();



$app = new \Slim\Slim();

$app->get('/retornacliente(/)', function () use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    // conexao DB online
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $query = "SELECT id, nome, plano, DATE_FORMAT(`vencimento`,'%d/%m/%Y') AS 'vencimento' FROM fvblocadora.usuarios_combustivel
    WHERE acesso<=2;";

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["id"] =  $consulta_result['id'];
            $arr[$i]["nome"] =  $consulta_result['nome'];
            $arr[$i]["plano"] =  $consulta_result['plano'];
            $arr[$i]["vencimento"] = $consulta_result['vencimento'];
            $i++;
        }

        echo json_encode($arr);
    } else {
        echo 0;
    }
});




//get de Listar Usuarios
$app->post('/criarusuario(/)', function () use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    // conexao DB online
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $nome = $jsonObj['nome'];
    $email = $jsonObj['email'];
    $plano = $jsonObj['plano'];
    $vencimento = $jsonObj['vencimento'];
    $senha = $jsonObj['senha'];
    $nivel = $jsonObj['nivel'];


    // $token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy"));

    $query = "INSERT INTO `fvblocadora`.`usuarios_combustivel` (`nome`, `email`, `plano`, `vencimento`, `senha`, `acesso`) VALUES 
            ('$nome', '$email', '$plano', '$vencimento', MD5('$senha'), '$nivel' )";

    $result = mysqli_query($conn, $query);
    
    if ($nivel ==2){
        $select = "SELECT id FROM  usuarios_combustivel WHERE email='$email'";
        $result = mysqli_query($conn, $select);
        $cr = mysqli_fetch_assoc($result);

        $id = $cr['id'];

        $query2 = "INSERT INTO `fvblocadora`.`controle_comb_cadastro_cliente` (`nome`, `email`, `nivelAcesso`) VALUES 
        ('$nome', '$email', '$id' )";
        mysqli_query($conn, $query2);
    }
    echo $result;
});



$app->get('/listaEditarCliente/:id', function ($id) use ($app) {

    date_default_timezone_set('America/Sao_Paulo');
    
    // conexao DB online
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $querySelectInfo = "SELECT * FROM fvblocadora.usuarios_combustivel
    WHERE id = $id  ";

    $result = mysqli_query($conn, $querySelectInfo);

    //Contas as linhas que retornaram 
    $arr = array();
    $i = 0;
    if ($result <> null) {
        if ($result->num_rows >= 0) {
            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["id"] =  $linha_result['id'];
                $arr[$i]["nome"] =  $linha_result['nome'];
                $arr[$i]["email"] =  $linha_result['email'];
                $arr[$i]["plano"] = $linha_result['plano'];
                $arr[$i]["vencimento"] = $linha_result['vencimento'];
                $arr[$i]["senha"] = $linha_result['senha'];
                $arr[$i]["acesso"] = $linha_result['acesso'];
                $i++;
            }
            echo json_encode($arr);
        } else {
            echo json_encode(null);
        }
    } else {
        echo json_encode(null);
    }
});


$app->POST('/alterarCliente(/)', function () use ($app) {

    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $id = $jsonObj['id'];
    $nome = $jsonObj['nome'];
    $email = $jsonObj['email'];
    $plano = $jsonObj['plano'];
    $vencimento = $jsonObj['vencimento'];
    $senha = $jsonObj['senha'];
    $acesso = $jsonObj['nivel'];

    $query = 'UPDATE fvblocadora.usuarios_combustivel SET `nome`= "' . $nome . '" ,`email`= "' . $email . '" ,  `plano`= "' . $plano . '" ,  `vencimento`= "' . $vencimento . '" ,  `senha`= "' . $senha . '"  ,  `acesso`= "' . $acesso . '"  WHERE `id` ="' . $id . '";';

    $result =  mysqli_query($conn, $query);

    echo json_encode($result);
});

$app->put('/deletarUsuario/:id', function ($id) use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    $idDeletar = $id;

    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $query = 'DELETE FROM fvblocadora.usuarios_combustivel WHERE `id` = ' . $idDeletar . ';';
    $result = mysqli_query($conn, $query);

    echo json_encode($conn->error);
});

$app->run();
