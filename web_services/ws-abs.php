
<?php
header('Content-type: text/html; charset=utf-8; application/json');



require './Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$app = new \Slim\Slim();

function userEmpresa()
{
    $user = $_SESSION['email'];

    $empresa = null;

    $query = "SELECT * FROM fvblocadora.controle_comb_cadastro_funcionario WHERE email='$user'";
    $conn =  getConnection();
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;
    if ($row_cnt > 0) {
        $cr = mysqli_fetch_assoc($result);
        $empresa = $cr['empresa'];
    } else if ($empresa == null) {
        $query2 = "SELECT * FROM fvblocadora.controle_comb_cadastro_cliente WHERE email='$user'";
        $result = mysqli_query($conn, $query2);
        $row_cnt = $result->num_rows;
        if ($row_cnt > 0) {
            $cr = mysqli_fetch_assoc($result);
            $empresa = $cr['id'];
        } else {
            $query3 = "SELECT * FROM fvblocadora.usuarios_combustivel WHERE email='$user'";
            $result = mysqli_query($conn, $query3);
            $row_cnt = $result->num_rows;
            if ($row_cnt > 0) {
                $cr = mysqli_fetch_assoc($result);
                $empresa = "0";
            }
        }
    }
    return $empresa;
};
//Function que cria a conexão da Base de Dados
function getConnection()
{
    // Padrões
    $servidor = "34.151.252.46";
    $usuario = "root";
    $senha = "abc123**";
    $dbname = "fvblocadora";
    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    $conn->set_charset("utf8");
    return $conn;
}
//Retorna o valor armazenado do combustivel 
$app->get('/retornaCombs(/)', function () use ($app) {

    $empresa = userEmpresa();
    $conn = getConnection();
    // $query = "SELECT * FROM `controle_comb_abastecimento` WHERE empresa = $empresa";
    $query = null;
    if ($empresa == 'Admin') {
        $query = "SELECT * FROM `controle_comb_combustivel` as a  WHERE a.empresa>0";
    } else {
        $query = "SELECT * FROM `controle_comb_combustivel` as a  WHERE a.empresa=$empresa ";
    }

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;
    $cont = 0;
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]['id'] =  $consulta_result['id'];
            $arr[$i]['tipo'] =  $consulta_result['tipo'];
            $arr[$i]['quantidade_total'] = $consulta_result['quantidade_total'];
            $arr[$i]['quantidade_atual'] = $consulta_result['quantidade_atual'];
            $d = new DateTime($consulta_result['data']);
            $arr[$i]['data'] = $d->format('d/m/Y');
            $arr[$i]['hora'] = $consulta_result['hora'];
            $i++;
        }
    } else {
    }
    echo json_encode($arr);
});

$app->get('/infoCombs/:id', function ($id) use ($app) {

    $empresa = userEmpresa();
    $conn = getConnection();
    // $query = "SELECT * FROM `controle_comb_abastecimento` WHERE empresa = $empresa";
    $query = null;
    if ($empresa == 'Admin') {
        $query = "SELECT * FROM `controle_comb_combustivel` as a  WHERE a.empresa>0 id=$id";
    } else {
        $query = "SELECT * FROM `controle_comb_combustivel` as a  WHERE a.empresa=$empresa AND id=$id";
    }

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;
    $cont = 0;
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]['id'] =  $consulta_result['id'];
            $arr[$i]['tipo'] =  $consulta_result['tipo'];
            $arr[$i]['quantidade_total'] = $consulta_result['quantidade_total'];
            $arr[$i]['quantidade_atual'] = $consulta_result['quantidade_atual'];
            $d = new DateTime($consulta_result['data']);
            $arr[$i]['data'] = $d->format('d/m/Y');
            $arr[$i]['hora'] = $consulta_result['hora'];
            $arr[$i]['valor'] = $consulta_result['valor'];
            $arr[$i]['nota_fiscal'] = $consulta_result['nota_fiscal'];
            $arr[$i]['assinatura'] = $consulta_result['assinatura'];
            $i++;
        }
    } else {
    }
    echo json_encode($arr);
});
//get de Obter Abastecimentos
$app->get('/retornaAbs(/)', function () use ($app) {

    $empresa = userEmpresa();
    $conn = getConnection();
    // $query = "SELECT * FROM `controle_comb_abastecimento` WHERE empresa = $empresa";
    $query = null;
    if ($empresa == 'Admin') {
        $query = "SELECT *, a.id as idAbs, c.nome as empresaNome, f.nome as NomeMot
        FROM `controle_comb_abastecimento` as a 
        LEFT JOIN `controle_comb_cadastro_cliente` as c ON c.id = a.empresa 
        LEFT JOIN `controle_comb_cadastro_funcionario` as f ON f.id = a.motorista
        LEFT JOIN `controle_comb_cadastro_veiculos` as v ON v.id = a.veiculo
        WHERE a.empresa>0 order by a.id desc";
    } else {
        $query = "SELECT *, a.id as idAbs, c.nome as empresaNome, f.nome as NomeMot
        FROM `controle_comb_abastecimento` as a 
        LEFT JOIN `controle_comb_cadastro_cliente` as c ON c.id = a.empresa 
        LEFT JOIN `controle_comb_cadastro_funcionario` as f ON f.id = a.motorista
        LEFT JOIN `controle_comb_cadastro_veiculos` as v ON v.id = a.veiculo
        WHERE a.empresa=$empresa order by a.id desc ";
    }

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;
    $cont = 0;
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]['id'] =  $consulta_result['idAbs'];
            $arr[$i]['nomeMot'] =  $consulta_result['NomeMot'];
            $arr[$i]['empresaNome'] =  $consulta_result['empresa'];
            $arr[$i]['placa'] = $consulta_result['placa'];
            $arr[$i]['prefixo'] = $consulta_result['prefixo'];
            $arr[$i]['modelo'] = $consulta_result['modelo'];
            $arr[$i]['marca'] = $consulta_result['marca'];
            $arr[$i]['ano'] = $consulta_result['ano'];
            $arr[$i]['abastecimento_litros'] = $consulta_result['abastecimento_litros'];
            $arr[$i]['abastecimento_tipo_comb'] = $consulta_result['abastecimento_tipo_comb'];
            $arr[$i]['abastecimento_hora'] = $consulta_result['abastecimento_hora'];
            $date = new DateTime($consulta_result['abastecimento_data']);
            $arr[$i]['abastecimento_data'] = $date->format('d/m/Y');
      
            $arr[$i]["url_motorista"] =  $consulta_result['url_motorista'];
            // $query1 = "SELECT f.nome as motorista, c.nome as empresa, v.marca, v.modelo,v.placa,v.prefixo,v.ano
            // FROM `controle_comb_cadastro_funcionario` as f, `controle_comb_cadastro_veiculos` as v, `controle_comb_cadastro_cliente` as c
            //  WHERE f.id = $idfunc AND v.id = $idcarro AND c.id = $idempresa ";

            // $rt = mysqli_query($conn, $query1);
            // $rct = $rt->num_rows;
            // if ($rct > 0){
            //     while ($cr = mysqli_fetch_assoc($rt)) {

            //         $i++;
            //     }
            // }
            $i++;
        }
    } else {
    }
    echo json_encode($arr);
});

//Retorna a somatória do comb por cada dia (durante 7 dias)
$app->put('/retornaGrap(/)', function () use ($app) {

    $empresa = userEmpresa();
    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $data = array();
    $data = $jsonObj['data'];
    $c = 0;
    $arr = array();
    $i = 0;

    // $query = "SELECT * FROM `controle_comb_abastecimento` WHERE empresa = $empresa";
    foreach ($data as $d) {
        if ($d != null) {
            $dat = new DateTime($d);
            $dat1 = $dat->format('Y-m-d');
            $query = null;
            if ($empresa == "Admin") {
                $query = "SELECT SUM(abastecimento_litros) as total  FROM `controle_comb_abastecimento`
            WHERE abastecimento_data='$dat1'";
            } else {
                $query = "SELECT SUM(abastecimento_litros) as total  FROM `controle_comb_abastecimento`
            WHERE empresa=$empresa and abastecimento_data='$dat1'";
            }

            $result = mysqli_query($conn, $query);
            if ($result == null) {
                echo $conn->error;
            } else {
                $row_cnt = $result->num_rows;
                $c++;
                if ($row_cnt > 0) {
                    while ($consulta_result = mysqli_fetch_assoc($result)) {
                        $arr[$i]['soma'] =  $consulta_result['total'];
                        $i++;
                    }
                }
            }
        }
    }
    echo json_encode($arr);
});

//Retorna a somatória do tipo de comb durante 1 dia
$app->put('/retornaGrap2(/)', function () use ($app) {

    $empresa = userEmpresa();
    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $data = array('GASOLINA', 'ETANOL', 'DIESEL');
    $c = 0;
    $arr = array();
    $i = 0;
    $query = null;
    // $query = "SELECT * FROM `controle_comb_abastecimento` WHERE empresa = $empresa";
    foreach ($data as $d) {
        if ($d != null) {
            $dat = new DateTime();
            $dat1 = $dat->format('Y-m-d');
            if ($empresa == "Admin") {
                $query = "SELECT SUM(abastecimento_litros) as total  FROM `controle_comb_abastecimento`
            WHERE abastecimento_data='$dat1'and abastecimento_tipo_comb='$d'";
            } else {
                $query = "SELECT SUM(abastecimento_litros) as total  FROM `controle_comb_abastecimento`
        WHERE empresa=$empresa and abastecimento_data='$dat1'and abastecimento_tipo_comb='$d'";
            }



            $result = mysqli_query($conn, $query);
            if ($result == null) {
                echo $conn->error;
            } else {
                $row_cnt = $result->num_rows;
                $c++;
                if ($row_cnt > 0) {
                    while ($consulta_result = mysqli_fetch_assoc($result)) {
                        $arr[$i]['soma'] =  $consulta_result['total'];
                        $i++;
                    }
                }
            }
        }
    }


    echo json_encode($arr);
});

$app->get('/retornaAbsFunc/:tp', function ($tp) use ($app) {

    $empresa = userEmpresa();
    $user = $_SESSION['email'];
    $conn = getConnection();
    // $query = "SELECT * FROM `controle_comb_abastecimento` WHERE empresa = $empresa";

    if ($tp == 1) {
        $query = "SELECT *, a.id as idAbs, c.nome as empresaNome, f.nome as NomeMot
        FROM `controle_comb_abastecimento` as a 
        LEFT JOIN `controle_comb_cadastro_cliente` as c ON c.id = a.empresa 
        LEFT JOIN `controle_comb_cadastro_funcionario` as f ON f.id = a.motorista
        LEFT JOIN `controle_comb_cadastro_veiculos` as v ON v.id = a.veiculo
        WHERE a.motorista= (SELECT ID FROM `controle_comb_cadastro_funcionario` WHERE email= '$user') order by a.id desc";
    } else {
        $query = "SELECT *, a.id as idAbs, c.nome as empresaNome, f.nome as NomeMot
        FROM `controle_comb_abastecimento` as a 
        LEFT JOIN `controle_comb_cadastro_cliente` as c ON c.id = a.empresa 
        LEFT JOIN `controle_comb_cadastro_funcionario` as f ON f.id = a.motorista
        LEFT JOIN `controle_comb_cadastro_veiculos` as v ON v.id = a.veiculo
        WHERE a.frentista= (SELECT ID FROM `controle_comb_cadastro_funcionario` WHERE email= '$user') order by a.id desc";
    }

    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;
    $cont = 0;
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]['id'] =  $consulta_result['idAbs'];
            $arr[$i]['nomeMot'] =  $consulta_result['NomeMot'];
            $arr[$i]['empresaNome'] =  $consulta_result['empresa'];
            $arr[$i]['placa'] = $consulta_result['placa'];
            $arr[$i]['prefixo'] = $consulta_result['prefixo'];
            $arr[$i]['modelo'] = $consulta_result['modelo'];
            $arr[$i]['marca'] = $consulta_result['marca'];
            $arr[$i]['ano'] = $consulta_result['ano'];
            $arr[$i]['url_motorista'] = $consulta_result['url_motorista'];
         
            $arr[$i]['abastecimento_litros'] = $consulta_result['abastecimento_litros'];
            $arr[$i]['abastecimento_tipo_comb'] = $consulta_result['abastecimento_tipo_comb'];
            $arr[$i]['abastecimento_hora'] = $consulta_result['abastecimento_hora'];
            $date = new DateTime($consulta_result['abastecimento_data']);
            $arr[$i]['abastecimento_data'] = $date->format('d/m/Y');;
            // $query1 = "SELECT f.nome as motorista, c.nome as empresa, v.marca, v.modelo,v.placa,v.prefixo,v.ano
            // FROM `controle_comb_cadastro_funcionario` as f, `controle_comb_cadastro_veiculos` as v, `controle_comb_cadastro_cliente` as c
            //  WHERE f.id = $idfunc AND v.id = $idcarro AND c.id = $idempresa ";

            // $rt = mysqli_query($conn, $query1);
            // $rct = $rt->num_rows;
            // if ($rct > 0){
            //     while ($cr = mysqli_fetch_assoc($rt)) {

            //         $i++;
            //     }
            // }
            $i++;
        }
    } else {
    }
    echo json_encode($arr);
});
$app->get('/listaPlacaVeiculo(/)', function () use ($app) {
    //$empresa = userEmpresa();
    $conn = getConnection();

    // if (token() == $_SESSION['token']) {
    $query = "SELECT placa FROM `controle_comb_cadastro_veiculos` ORDER BY PLACA ASC ";
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["placa"] =  $consulta_result['placa'];
            $i++;
        }
        echo json_encode($arr);
    } else {
        echo 0;
    }
    // }
});

$app->get('/retorna/:id', function ($id) use ($app) {

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $val = $id;


    $query = "SELECT * FROM `controle_comb_cadastro_veiculos` WHERE placa = '" . $val . "'";
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;

    $check = null;

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["prefixo"] =  $consulta_result['prefixo'];
            $arr[$i]["marca"] =  $consulta_result['marca'];
            $arr[$i]["modelo"] =  $consulta_result['modelo'];
            $arr[$i]["placa"] =  $consulta_result['placa'];
            $arr[$i]["combustivel"] =  $consulta_result['combustivel'];
            $arr[$i]["ano"] =  $consulta_result['ano'];
            $i++;
        }
        echo json_encode($arr);
    } else {
        echo "$check";
    }
});

$app->get('/listarInfos/:id', function ($id) use ($app) {

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $id = $id;
    $date = '';

    $query = "SELECT *, a.id as idAbs, v.modelo as modelo, c.nome as empresaNome, f.nome as nomeMot, f2.nome as nomeFre
    FROM controle_comb_abastecimento as a 
    LEFT JOIN controle_comb_cadastro_cliente as c ON c.id = a.empresa 
    LEFT JOIN controle_comb_cadastro_funcionario as f ON f.id = a.motorista
    LEFT JOIN controle_comb_cadastro_funcionario as f2 ON f2.id = a.frentista
    LEFT JOIN controle_comb_cadastro_veiculos as v ON v.id = a.veiculo
    WHERE a.id = '$id'";
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;


    $check = null;

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["nomeFre"] =  $consulta_result['nomeFre'];
            $arr[$i]["modelo"] =  $consulta_result['modelo'];
            $arr[$i]["nomeMot"] =  $consulta_result['nomeMot'];
            $arr[$i]["abastecimento_litros"] =  $consulta_result['abastecimento_litros'];
            $arr[$i]["abastecimento_tipo_comb"] =  $consulta_result['abastecimento_tipo_comb'];
            $date = new DateTime($consulta_result['abastecimento_data']);
            $arr[$i]["abastecimento_data"] = $date->format('d/m/Y');
            $arr[$i]["abastecimento_hora"] =  $consulta_result['abastecimento_hora'];
            $arr[$i]["valor_total"] =  $consulta_result['valor_total'];
            $arr[$i]["nota_fiscal"] =  $consulta_result['nota_fiscal'];
            $arr[$i]["url_frentista"] =  $consulta_result['url_frentista'];
            $arr[$i]["url_motorista"] =  $consulta_result['url_motorista'];
            $i++;
        }
        echo json_encode($arr);
    } else {
        echo "$check";
    }
});
$app->get('/retornaQR/:id', function ($id) use ($app) {

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $val = $id;


    $query = "SELECT * FROM `controle_comb_cadastro_veiculos` WHERE id = '" . $val . "'";
    $result = mysqli_query($conn, $query);
    $row_cnt = $result->num_rows;

    $arr = array();
    $i = 0;

    $check = null;

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $arr[$i]["prefixo"] =  $consulta_result['prefixo'];
            $arr[$i]["marca"] =  $consulta_result['marca'];
            $arr[$i]["modelo"] =  $consulta_result['modelo'];
            $arr[$i]["placa"] =  $consulta_result['placa'];
            $arr[$i]["combustivel"] =  $consulta_result['combustivel'];
            $arr[$i]["ano"] =  $consulta_result['ano'];
            $i++;
        }
        echo json_encode($arr);
    } else {
        echo "$check";
    }
});

//Frentista informa o Pedido de Abastecimento 
$app->put('/gerarAbs(/)', function () use ($app) {
    $empresa = userEmpresa();
    date_default_timezone_set('America/Sao_Paulo');

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $user = $_SESSION['email'];
    $idMot = $jsonObj['idMot'];
    $idCar = $jsonObj['idCar'];
    $nota = $jsonObj['nota'];
    $val = $jsonObj['val'];
    $litros = $jsonObj['litro'];
    $tipo = $jsonObj['comb'];
    $url = $jsonObj['url'];
    $frentista = $_SESSION['email'];
    $km = $jsonObj['km'];
    $today = date("Y-m-d");
    $hour = date("h:i");
    $empresa = userEmpresa();

    $disp = "UPDATE`controle_comb_combustivel` set quantidade_atual = quantidade_atual-$litros  WHERE tipo='$tipo' and empresa=$empresa order by id DESC LIMIT 1; ";
    $kmdisp = "UPDATE `controle_comb_cadastro_veiculos` set km =$km  WHERE id=$idCar; ";
    // $token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy")); , '$empresa'

    $query = "INSERT INTO `controle_comb_abastecimento` (`veiculo`, `motorista`, `empresa`, 
    `abastecimento_litros`, `abastecimento_tipo_comb`,`frentista`,`abastecimento_hora`,`abastecimento_data`, `valor_total`, `nota_fiscal`, `url_frentista`) 
    VALUES 
    ($idCar,$idMot,$empresa,'$litros','$tipo',
    (SELECT id from controle_comb_cadastro_funcionario where email= '$frentista'),
    '$hour','$today','$val','$nota', '$url');";



    mysqli_query($conn, $query);
    mysqli_query($conn, $disp);
    mysqli_query($conn, $kmdisp);


    echo $conn->error;
});

$app->put('/consMot/:id', function ($id) use ($app) {
    $empresa = userEmpresa();
    date_default_timezone_set('America/Sao_Paulo');

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $user = $_SESSION['email'];


    $query = "SELECT * FROM `controle_comb_cadastro_funcionario` WHERE id = $id";
    $erro = $conn->error;
    if ($erro != null) {
    } else {
        $result = mysqli_query($conn, $query);
        $row_cnt = $result->num_rows;

        $arr = array();
        $i = 0;

        if ($row_cnt > 0) {
            while ($consulta_result = mysqli_fetch_assoc($result)) {
                $arr[$i]['id'] =  $consulta_result['id'];
                $arr[$i]['nome'] =  $consulta_result['nome'];
                $arr[$i]['url_foto'] =  $consulta_result['url_foto'];
                $i++;
            }
            echo json_encode($arr);
        } else {
            echo false;
        }
    }
});

//Frentista Consulta o QR-CODE do carro
$app->put('/consCar/:id', function ($id) use ($app) {
    $empresa = userEmpresa();
    date_default_timezone_set('America/Sao_Paulo');

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    $user = $_SESSION['email'];

    // $empresa = userEmpresa();

    // $token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy")); , '$empresa'


    $query = "SELECT * FROM `controle_comb_cadastro_veiculos` WHERE id = $id";

    $result = mysqli_query($conn, $query);
    $erro = $conn->error;
    if ($erro != null) {
        echo false;
    } else {
        $row_cnt = $result->num_rows;
        $idfunc = null;
        $idempresa = null;
        $idcarro = null;

        $arr = array();
        $i = 0;

        if ($row_cnt > 0) {
            while ($consulta_result = mysqli_fetch_assoc($result)) {
                $arr[$i]['marca'] =  $consulta_result['marca'];
                $arr[$i]['placa'] =  $consulta_result['placa'];
                $arr[$i]['modelo'] =  $consulta_result['modelo'];
                $arr[$i]['prefixo'] =  $consulta_result['prefixo'];
                $arr[$i]['ano'] =  $consulta_result['ano'];
                $arr[$i]['km'] =  $consulta_result['km'];
                $arr[$i]["combustivel"] = $consulta_result['combustivel'];
                $arr[$i]["limit_dia"] = $consulta_result['limit_dia'];
                $arr[$i]["limit_tanque"] = $consulta_result['limit_tanque'];
                $i++;
            }
            // $query1 = "SELECT f.nome as motorista, c.nome as empresa, v.marca, v.modelo,v.placa,v.prefixo, v.ano
            // FROM `controle_comb_cadastro_funcionario` as f, `controle_comb_cadastro_veiculos` as v, `controle_comb_cadastro_cliente` as c
            //  WHERE f.id = $idfunc AND v.id = $idcarro AND c.id = $idempresa ";

            //  $rt = mysqli_query($conn, $query1);
            //  $rct = $rt->num_rows;
            //     if ($rct > 0){
            //         while ($cr = mysqli_fetch_assoc($rt)) {
            //             $arr[$i]['motorista'] = $cr['motorista'];
            //             $arr[$i]['empresa'] = $cr['empresa'];
            //             $arr[$i]['placa'] = $cr['placa'];
            //             $arr[$i]['prefixo'] = $cr['prefixo'];
            //             $arr[$i]['modelo'] = $cr['modelo'];
            //             $arr[$i]['marca'] = $cr['marca'];
            //             $arr[$i]['ano'] = $cr['ano'];

            //         }
            //     }
            echo json_encode($arr);
        } else {
            echo false;
        }
    }
});

$app->put('/confirmAbs(/)', function () use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $idAbs = $jsonObj['id'];
    $litros = $jsonObj['litro'];
    $tipo = $jsonObj['comb'];
    $frentista = $_SESSION['email'];


    $query = "UPDATE `controle_comb_abastecimento` SET `abastecimento_litros` = '$litros', `abastecimento_tipo_comb` = '$tipo', 
        `frentista` = (SELECT id FROM `controle_comb_cadastro_funcionario` WHERE email='$frentista') WHERE id = $idAbs";

    $result = mysqli_query($conn, $query);
});


$app->put('/confirmAbsMot(/)', function () use ($app) {

    date_default_timezone_set('America/Sao_Paulo');

    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $idAbs = $jsonObj['id'];
    $url = $jsonObj['url'];
 

    $query = "UPDATE `controle_comb_abastecimento` SET `url_motorista` = '$url' WHERE id = $idAbs";

    $result = mysqli_query($conn, $query);
});

$app->put('/ass(/)', function () use ($app) {
    date_default_timezone_set('America/Sao_Paulo');
    $empresa = userEmpresa();
    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);

    $ass = $jsonObj['ass'];
    $qt = $jsonObj['quant'];
    $tp = $jsonObj['tp'];
    $nf = $jsonObj['nota'];
    $vl = $jsonObj['valor'];

    $today = date("Y-m-d");
    $hour = date("h:i");

    $QGas = "SELECT * FROM controle_comb_combustivel WHERE tipo = '$tp' and empresa = '$empresa' order by id DESC LIMIT 1";

    $r1 = mysqli_query($conn, $QGas);
    if ($r1->num_rows > 0) {
        $consulta_result = mysqli_fetch_assoc($r1);

        $id = $consulta_result['id'];
        $qt_atual =  $consulta_result['quantidade_atual'];

        if ($qt_atual > 0) {
            $qt = $qt + $qt_atual;

            $query = "UPDATE control_comb_combustivel SET quantidade_atual = '0' WHERE id = $id";
            $result = mysqli_query($conn, $query);
        }
    }

    $query = "INSERT INTO controle_comb_combustivel(quantidade_total, quantidade_atual, assinatura, tipo, data, hora, empresa, nota_fiscal, valor)
    VALUES ('$qt', '$qt', '$ass', '$tp', '$today', '$hour', '$empresa', '$nf', '$vl')";
    echo $query;
    mysqli_query($conn, $query);
    $erro = $conn->error;
    if ($erro != null) {
        echo false;
    } else {
        echo $erro;
    }
});

//Consulta Quantidade de combustivel na Bomba
$app->put('/consCombs(/)', function () use ($app) {
    date_default_timezone_set('America/Sao_Paulo');
    $empresa = userEmpresa();
    $conn = getConnection();

    $jsonbruto = $app->request()->getBody();
    $jsonObj = json_decode($jsonbruto, true);
    if ($empresa == 'Admin') {
        $QGas = "SELECT SUM(quantidade_total) as quantidade_total, SUM(quantidade_atual) as quantidade_atual FROM  `controle_comb_combustivel` WHERE tipo='Gasolina'  ";
        $QEt = "SELECT SUM(quantidade_total) as quantidade_total, SUM(quantidade_atual) as quantidade_atual FROM  `controle_comb_combustivel` WHERE tipo='Etanol'  ";
        $QDie = "SELECT SUM(quantidade_total) as quantidade_total, SUM(quantidade_atual) as quantidade_atual FROM  `controle_comb_combustivel` WHERE tipo='Diesel'  ";
    } else {
        $QGas = "SELECT * FROM  `controle_comb_combustivel` WHERE tipo='Gasolina' and empresa=$empresa order by id DESC LIMIT 1 ";
        $QEt = "SELECT * FROM  `controle_comb_combustivel` WHERE tipo='Etanol'and empresa=$empresa order by id DESC LIMIT 1 ";
        $QDie = "SELECT * FROM  `controle_comb_combustivel` WHERE tipo='Diesel'and empresa=$empresa order by id DESC LIMIT 1 ";
    }

    $r1 = mysqli_query($conn, $QGas);
    $r2 = mysqli_query($conn, $QEt);
    $r3 = mysqli_query($conn, $QDie);
    $arr = array();
    $i = 0;

    $erro = $conn->error;
    if ($erro != null) {
        echo false;
    } else {

        $row = $r1->num_rows;
        $row2 = $r2->num_rows;
        $row3 = $r3->num_rows;
        if ($row > 0) {
            $consulta_result = mysqli_fetch_assoc($r1);
            // $arr[0]['gas'] =  $consulta_result['tipo'];
            $arr[1]['quantidade_total'] =  $consulta_result['quantidade_total'];
            $arr[2]['quantidade_atual'] =  $consulta_result['quantidade_atual'];
        }
        if ($row2 > 0) {
            $consulta_result = mysqli_fetch_assoc($r2);
            // $arr[3]['eta'] =  $consulta_result['tipo'];
            $arr[4]['quantidade_total'] =  $consulta_result['quantidade_total'];
            $arr[5]['quantidade_atual'] =  $consulta_result['quantidade_atual'];
        }
        if ($row3 > 0) {
            $consulta_result = mysqli_fetch_assoc($r3);
            // $arr[6]['dies'] =  $consulta_result['tipo'];
            $arr[7]['quantidade_total'] =  $consulta_result['quantidade_total'];
            $arr[8]['quantidade_atual'] =  $consulta_result['quantidade_atual'];
        }
        echo json_encode($arr);
    }
});
$app->run();
