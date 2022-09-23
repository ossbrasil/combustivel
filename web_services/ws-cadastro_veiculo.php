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
    $conn = conexaBD();
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

function conexaBD()
{
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

$app->get('/retornaEmpresas(/)', function () use ($app) {
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

//get de Obter veiculos
$app->get('/retornaVeiculos(/)', function () use ($app) {

    $empresa = userEmpresa();
    $conn = conexaBD();
    $query = null;
    if ($empresa == 'Admin'){
        $query = "SELECT * FROM `controle_comb_cadastro_veiculos`";
    }else {
        $query = "SELECT * FROM `controle_comb_cadastro_veiculos` WHERE empresa = $empresa"; 
    }
    

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;
    $cont = 0;
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["id"] =  $consulta_result['id'];
            $arr[$i]["marca"] =  $consulta_result['marca'];
            $arr[$i]["modelo"] =  $consulta_result['modelo'];
            $arr[$i]["placa"] = $consulta_result['placa'];
            $arr[$i]["prefixo"] = $consulta_result['prefixo'];
            $arr[$i]["ano"] = $consulta_result['ano'];
            $arr[$i]["empresa"] = $consulta_result['terceiros'];
            $arr[$i]["cont"] = $cont + 1;
            $i++;
        }

        echo json_encode($arr);
    } else {
        echo 0;
    }
});

//set de Criar Veiculos
$app->post('/criarVeiculos(/)', function () use ($app) {
    $empresa = userEmpresa();
    date_default_timezone_set('America/Sao_Paulo');

    $conn = conexaBD();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $marca = $jsonObj['marca'];
    $modelo = $jsonObj['modelo'];
    $placa = $jsonObj['placa'];
    $prefixo = $jsonObj['prefixo'];
    $ano = $jsonObj['ano'];
    $comb = $jsonObj['tpComb'];
    $ldia = $jsonObj['qtdDia'];
    $total = $jsonObj['qtdTotal'];
    $km = $jsonObj['km'];
    $empresa = userEmpresa();

    // $token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy")); , '$empresa'
    $query2 = "INSERT INTO `controle_comb_cadastro_veiculos` (`marca`, `modelo`, `km`, `placa`,`prefixo`,`ano`,`empresa`,`combustivel`,`limit_dia`,`limit_tanque`) VALUES 
            ('$marca', '$modelo','$km', '$placa','$prefixo','$ano', '$empresa','$comb','$ldia','$total') "; // `nivel_acesso`,`empresa`

    $result2 = mysqli_query($conn, $query2);
    echo $result2;
});

$app->get('/listaEditarVeiculo/:id', function ($id) use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    // conexao DB online
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $querySelectInfo = "SELECT * FROM fvblocadora.controle_comb_cadastro_veiculos
    WHERE id = $id";

    $result = mysqli_query($conn, $querySelectInfo);

    //Contas as linhas que retornaram 
    $arr = array();
    $i = 0;
    if ($result <> null) {
        if ($result->num_rows >= 0) {
            while ($linha_result = mysqli_fetch_assoc($result)) {
                $arr[$i]["id"] =  $linha_result['id'];
                $arr[$i]["placa"] =  $linha_result['placa'];
                $arr[$i]["prefixo"] =  $linha_result['prefixo'];
                $arr[$i]["modelo"] =  $linha_result['modelo'];
                $arr[$i]["marca"] = $linha_result['marca'];
                $arr[$i]["ano"] = $linha_result['ano'];
                $arr[$i]["combustivel"] = $linha_result['combustivel'];
                $arr[$i]["empresa"] = $linha_result['terceiros'];
                $arr[$i]["limit_dia"] = $linha_result['limit_dia'];
                $arr[$i]["limit_tanque"] = $linha_result['limit_tanque'];
                
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


$app->POST('/alterarVeiculo(/)', function () use ($app) {

    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $id = $jsonObj['id'];
    $placa = $jsonObj['placa'];
    $prefixo = $jsonObj['prefixo'];
    $marca = $jsonObj['marca'];
    $modelo = $jsonObj['modelo'];
    $ano = $jsonObj['ano'];
    $comb = $jsonObj['tpComb'];
    $ldia = $jsonObj['qtdDia'];
    $total = $jsonObj['qtdTotal'];


    $query = 'UPDATE fvblocadora.controle_comb_cadastro_veiculos SET `combustivel`="'.$comb.'",`limit_dia`"'.$ldia.'",`limit_tanque`="'.$total.'", `placa`= "' . $placa . '" , `prefixo`= "' . $prefixo . '" ,`modelo`= "' . $modelo . '" ,  `marca`= "' . $marca . '", `ano`= "' . $ano . '"   WHERE `id` ="' . $id . '";';

    $result =  mysqli_query($conn, $query);

    echo json_encode($result);
});

$app->delete('/deletarVeiculo/:id', function ($id) use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    $idDeletar = $id;

    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    echo $idDeletar;

    $query = 'DELETE FROM fvblocadora.controle_comb_cadastro_veiculos WHERE `id` = ' . $idDeletar . '';
    $result = mysqli_query($conn, $query);

    echo json_encode($result);
});

$app->run();
