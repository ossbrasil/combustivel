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

$query = 'SELECT * FROM `motoristas`';

//Query do Banco
$result = mysqli_query($conn, $query);
$row_cnt = $result->num_rows;
//Fim

$row_cnt = $result->num_rows;

$mesAtual = date('m');

$anoAtual = date('Y');

$diasDoMes = cal_days_in_month(CAL_GREGORIAN, $mesAtual, $anoAtual);

$token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy"));

?>

<html>

<head>
    <meta charset="utf-8">
    <title>Relatório Eventos</title>
    <style>
        h1 {
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
        <h1 >Mapa de Escalas</h1>
        <small>Referente a data de ' . date('d/m/Y') . '</small>
        <table>
        <tr background="black">
          <td colspan="1">Motorista</td>
          <td colspan="1">Função</td>
          ';
    for ($contaTitulo = 1; $contaTitulo <= $diasDoMes; $contaTitulo++) {
        $html = $html .'<td colspan="1">' . $contaTitulo . '</td>';
    }
    $html = $html .'
        </tr>
        ';
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $html =  $html . '
                <tr id="' . $consulta_result['id'] . '">
                    <td>' . $consulta_result['nome'] . '
                    </td>';
            if ($consulta_result['funcao'] == 80348 || $consulta_result['funcao'] == 84534) {
                $html =  $html . '<td>Condutor</td>';
            } else if ($consulta_result['funcao'] == 80347) {
                $html =  $html . '<td>Ajudante</td>';
            }

            for ($contaDias = 1; $contaDias <= $diasDoMes; $contaDias++) {
                if ($contaDias % 2 == 0) {
                    if ($consulta_result['status_ultimo_ponto'] == 1 || $consulta_result['status_ultimo_ponto'] == 2 || $consulta_result['status_ultimo_ponto'] == 3 || $consulta_result['status_ultimo_ponto'] == 7) {
                        $html =  $html . '<td style="background-color:#00c851; color:white; font-weight: bold;" >12hr</td>';
                    } else {
                        $html =  $html . '<td style="background-color:#f44336; color:white; font-weight: bold;" >36hr</td>';
                    }
                } else {
                    if ($consulta_result['status_ultimo_ponto'] == 1 || $consulta_result['status_ultimo_ponto'] == 2 || $consulta_result['status_ultimo_ponto'] == 3 || $consulta_result['status_ultimo_ponto'] == 7) {
                        $html =  $html . '<td style="background-color:#f44336; color:white; font-weight: bold;" >36hr</td>';
                    } else {
                        $html =  $html . '<td style="background-color:#00c851; color:white; font-weight: bold;"  >12hr</td>';
                    }
                }
            }
            $html =  $html . '
                </tr>
                ';
        }
    }
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $html =  $html .
                '<tr>
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td class="text-center"></td>
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