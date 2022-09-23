<?php
header('Content-type: text/html; charset=utf-8; application/json');

if (session_status() !== PHP_SESSION_ACTIVE) {

    session_start();
}

require './Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//post de Autenticação - WEB - APP
$app->put('/authenticate(/)', function () use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $token = MD5(MD5('quaestum') . $jsonObj['email'] . date("dmy"));

    // conexao DB online
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");

    // Estabeleça o fuso horário
    date_default_timezone_set('America/Sao_Paulo');

    //query de login
    $query = "select * from usuarios_combustivel where email='" . $jsonObj['email'] . "' and senha = md5('" . $jsonObj['senha'] . "');";
    //Captura o Resultado
    $result = mysqli_query($conn, $query);

    $consulta_result = mysqli_fetch_assoc($result);
    //Conta as linhas que retornaram
    $row_cnt = $result->num_rows;

    if ($row_cnt > 0) {
        //Retorna status
        
        $_SESSION["autenticacao"] = 1;
        $_SESSION["email"] = $jsonObj['email'];
        $_SESSION["token"] = $token;
        $_SESSION["nome"] = $consulta_result['nome'];
        $_SESSION["id"] = $consulta_result['id'];
        $id =$consulta_result['email'];


        $q = "SELECT * FROM controle_comb_cadastro_funcionario WHERE email='$id'";
        $rt = mysqli_query($conn, $q);
        $ct = mysqli_fetch_assoc($rt);
        $rct = $rt->num_rows;
        if ($rct>0){

            $funcao = $ct['funcao'];


            if ($funcao ==6){
                echo '{
                    "autenticacao": 2
                }';
            }else if ($funcao == 7){
                echo '{
                    "autenticacao": 3
                }';
            }

        } else {
            echo '{
                "autenticacao": 1
            }';
        }
       
       
        //Retorna o Nivel de Acesso
        $_SESSION["acesso"] = $consulta_result['acesso'];
        //$jsonObj = json_decode($jsonbruto);
        //$_SESSION["acesso"] = $jsonObj->Web_BancoHoras[0]->nivel_acesso;

    } else {
        //Retorna status
        echo '{
            "autenticacao": 0
        }';
        $_SESSION["autenticacao"] = 0;
    }
});

$app->run();
