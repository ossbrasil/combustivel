<?php
header('Content-type: text/html; charset=utf-8; application/json');

session_start();

require './Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

function userEmpresa (){
    $user = $_SESSION['email'];

    $empresa = null; 

    $query= "SELECT * FROM fvblocadora.controle_comb_cadastro_funcionario WHERE email='$user'";
    $conn =  conexaBD ();
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;
    if ($row_cnt > 0) {
        $cr = mysqli_fetch_assoc($result);
        $empresa = $cr['empresa'];
    }
    else if ($empresa == null) {
        $query2= "SELECT * FROM fvblocadora.controle_comb_cadastro_cliente WHERE email='$user'";
        $result = mysqli_query($conn, $query2);
        $row_cnt = $result->num_rows;
        if ($row_cnt > 0) {
            $cr = mysqli_fetch_assoc($result);
            $empresa = $cr['id'];      
        }
        else {
            $query3= "SELECT * FROM fvblocadora.usuarios_combustivel WHERE email='$user'"; 
            $result = mysqli_query($conn, $query3);
            $row_cnt = $result->num_rows;
            if ($row_cnt > 0) {
            $cr = mysqli_fetch_assoc($result);
            $empresa = "Admin"; 
            }  
              
        }
        
    }
    return $empresa;

};

function conexaBD () {
    date_default_timezone_set('America/Sao_Paulo');

    // conexao DB online
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    return $conn;

};

//get de Obter Funcionario
$app->get('/retornafuncQR(/)', function () use ($app) {

    $empresa = userEmpresa();
    $conn = conexaBD();
    $email= $_SESSION['email'];
    $query = "SELECT id FROM fvblocadora.controle_comb_cadastro_funcionario WHERE email = '$email'";
    
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;
    $id=0;

    if ($row_cnt > 0) {
        $consulta_result = mysqli_fetch_assoc($result);
            $id =  $consulta_result['id'];

        echo json_encode($id);
    } else {
        echo 0;
    }
});

//get de Obter Funcionarios
$app->get('/retornaEmpresa(/)', function () use ($app) {

    $empresa = userEmpresa();
    $conn = conexaBD();
    $query = null;

    if ($empresa == "Admin"){
        $query = "SELECT * FROM fvblocadora.controle_comb_cadastro_empresa";
    }else {
        $query = "SELECT * FROM fvblocadora.controle_comb_cadastro_empresa WHERE cliente = $empresa";
    }
    
    
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["id"] =  $consulta_result['id'];
            $arr[$i]["nome"] =  $consulta_result['nome'];
            $i++;
        }

        echo json_encode($arr);
    } else {
        echo 0;
    }
});

//set de Criar Funcionario
$app->post('/criarEmpresa(/)', function () use ($app) {
    $empresa = userEmpresa();
    date_default_timezone_set('America/Sao_Paulo');

    $conn = conexaBD();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $nome = $jsonObj['nome'];

    $empresa = userEmpresa();

    // $token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy")); , '$empresa'

   

    $query2 = "INSERT INTO `controle_comb_cadastro_empresa` (`nome`, `cliente`) VALUES 
            ('$nome',  '$empresa') "; // `nivel_acesso`,`empresa`

    $result2 = mysqli_query($conn, $query2);
    echo $result2;
});

$app->get('/listaEditarFuncionario/:id', function ($id) use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    // conexao DB online
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $querySelectInfo = "SELECT * FROM fvblocadora.controle_comb_cadastro_funcionario
    WHERE id = $id";

    $result = mysqli_query($conn, $querySelectInfo);

    //Contas as linhas que retornaram 
    $arr = array();
    $i = 0;
    if ($result <> null) {
        if ($result->num_rows >= 0) {
            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["id"] =  $linha_result['id'];
                $arr[$i]["nome"] =  $linha_result['nome'];
                $arr[$i]["matricula"] =  $linha_result['matricula'];
                $arr[$i]["email"] =  $linha_result['email'];
                $arr[$i]["nivel_acesso"] = $linha_result['funcao'];
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

$app->PUT('/alterarEmpresa(/)', function () use ($app) {

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
    

    $query = 'UPDATE fvblocadora.controle_comb_cadastro_empresa SET `nome`= "' . $nome . '" WHERE `id` ="' . $id . '";';

    $result =  mysqli_query($conn, $query);

    echo json_encode($result);
});



$app->delete('/deletarEmpresa/:id', function ($id) use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    $idDeletar = $id;

    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    echo $idDeletar;
    
    $query = 'DELETE FROM fvblocadora.controle_comb_cadastro_empresa WHERE `id` = ' . $idDeletar . '';
    $result = mysqli_query($conn, $query);

    echo json_encode($result);
});

$app->run();
