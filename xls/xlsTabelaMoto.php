<?php
session_start();

//conexao DB
$servidor = "34.151.252.46";
$usuario = "root";
$senha = "abc123**";
$dbname = "fvblocadora";

//Realiza Conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
$conn->set_charset("utf8");

if (date('d') % 2 == 0) {
    if ($_GET['dia'] == 2) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (1,3,7) AND `ferias` = 0  AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else if ($_GET['dia'] == 1) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5) AND `ferias` = 0  AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5,1,3,7) AND `ferias` = 0  AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    }
} else {
    if ($_GET['dia'] == 1) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (1,3,7) AND `ferias` = 0  AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else if ($_GET['dia'] == 2) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5) AND `ferias` = 0  AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5,1,3,7) AND `ferias` = 0  AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    }
}

//Query do Banco
$result = mysqli_query($conn, $query);
$row_cnt = $result->num_rows;
//Fim

$dia = 0;

if ($_GET['dia'] == 1) {
    $dia = '(Impar)';
} else if ($_GET['dia'] == 2) {
    $dia = '(Par)';
}else{
    $dia = '(Ambos)';
}

$consulta_teste = mysqli_fetch_assoc($result);

$tipo_jornada = '';

if ($_GET['jornada'] == '613578,613674') {
    $tipo_jornada = 'Turno 12 x 36 - 06:00 as 18:00';
} else if ($_GET['jornada'] == 544309 || $consulta_result['tipo_jornada'] == 613669) {
    $tipo_jornada = 'Turno 12 x 36 - 18:00 as 06:00';
} else if ($_GET['jornada'] == 613574) {
    $tipo_jornada = 'Turno 12x 36 - 07:00 as 19:00';
} else if ($_GET['jornada'] == 613576) {
    $tipo_jornada = 'Turno 12x36 - 19:00 as 07:00';
} else if ($_GET['jornada'] == 573554) {
    $tipo_jornada = 'Turno 12x36 - 04:00 as 16:00';
} else if ($_GET['jornada'] == 573552) {
    $tipo_jornada = 'Turno 12x36 - 16:00 as 04:00';
} else {
    $tipo_jornada = 'Não Consta';
}

$tipo_funcao = '';
if ($consulta_teste['funcao'] == 80348 || $consulta_teste['funcao'] == 84534) {
    $tipo_funcao = 'Condutor';
} else if ($consulta_teste['funcao'] == 80348) {
    $tipo_funcao = 'Ajudante';
}


$tipo_polo = '';
if ($consulta_teste['polo'] == 75992 || $consulta_teste['polo'] == 70404) {
    $tipo_polo = 'Vila Guilherme';
} else {
    $tipo_polo = 'Vila Mariana';
}

$jornada ='';
if ($consulta_teste['status_ultimo_ponto'] == 1) {
    $jornada ='Em jornada';
} else if ($consulta_teste['status_ultimo_ponto'] == 2) {
    $jornada ='Intervalo';
} else if ($consulta_teste['status_ultimo_ponto'] == 3) {
    $jornada ='Ausente';
} else if ($consulta_teste['status_ultimo_ponto'] == 4) {
    $jornada ='Em jornada extra';
} else if ($consulta_teste['status_ultimo_ponto'] == 5) {
    $jornada ='Expedente encerrado';
} else if ($consulta_teste['status_ultimo_ponto'] == 6) {
    $jornada ='De folga';
} else if ($consulta_teste['status_ultimo_ponto'] == 7) {
    $jornada ='Atrasado';
} else if ($consulta_teste['status_ultimo_ponto'] == 8) {
    $jornada ='Trabalhando em dia de folga';
} else {
    $jornada ='Não consta';
}
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Relatório Eventos</title>
    <style>
        h1{
            margin: 0;
            padding: 0;
        }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <?php
    $html = ' 
        <h1>Informações Checklist ' . $dia . '</h1>
        <h2>' . $tipo_jornada . '</h2>
        <small>Referente a data de ' . date('d/m/Y') . '</small>
        <table>
        <trbackground="black">
          <td colspan="1" align="center">Motorista</td>
          <td colspan="1" align="center">Função</td>
          <td colspan="1" align="center">Polo</td>
          <td colspan="1" align="center">jornada</td>
        </tr>
        ';

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $html =  $html .
                '<tr>
      <td class="text-center">' . $consulta_result['nome'] . '</td>
      <td class="text-center">' . $tipo_funcao . '</td>
      <td class="text-center">' . $tipo_polo . '</td>
      <td class="text-center">' . $jornada . '</td>
    </tr>';
        }
    }
    $html = $html . ' </table> ';
    $arquivo = "Relatorio de Motoristas.xls";
    header("Expires: 0");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
    header("Content-Description: PHP Generated Data");

    echo $html;
    exit; ?>
</body>

</html>