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

$query = 'SELECT * FROM `motoristas` WHERE `polo` IN (' . $_GET['polo'] . ')';

//Query do Banco
$result = mysqli_query($conn, $query);
$row_cnt = $result->num_rows;
//Fim

function seconds_from_time($time) {
    list($h, $m, $s) = explode(':', $time);
    return ($h * 3600) + ($m * 60) + $s;
}

function time_from_seconds($seconds) {
    $h = floor($seconds / 3600);
    $m = floor(($seconds % 3600) / 60);
    // $s = $seconds - ($h * 3600) - ($m * 60);
    return sprintf('%02d:%02d', $h, $m);
}
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
        <h1>Informações Relatório Banco de Horas</h1>
        <small>Referente a data de ' . date('d/m/Y') . '</small>
        <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Polo</th>
            <th>Jornada</th>
            <th>Horas Extras</th>
        </tr>
        ';

    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {
            $html =  $html . '
                <tr id="' . $consulta_result['id'] . '">
                    <td>' . $consulta_result['nome'] . '
                    </td>
                    <td>' . $consulta_result['cpf'] . '
                    </td>
            ';
            if ($consulta_result['polo'] == 75992 || $consulta_result['polo'] == 70404) {
                $html =  $html . '<td>Vl. Guilherme</td>';
            } else if ($consulta_result['polo'] == 75993 || $consulta_result['polo'] == 81142) {
                $html =  $html . '<td>Vl. Mariana</td>';
            } else {
                $html =  $html . '<td>Não consta</td>';
            }
            if ($consulta_result['tipo_jornada'] == 613578 || $consulta_result['tipo_jornada'] == 613674) {
                $html =  $html . '<td>12 x 36 - 06:00 as 18:00</td>';
            } else if ($consulta_result['tipo_jornada'] == 544309 || $consulta_result['tipo_jornada'] == 613669) {
                $html =  $html . '<td>12 x 36 - 18:00 as 06:00</td>';
            } else if ($consulta_result['tipo_jornada'] == 613574 ) {
                $html =  $html . '<td>12x 36 - 07:00 as 19:00</td>';
            } else if ($consulta_result['tipo_jornada'] == 613576) {
                $html =  $html . '<td>12x36 - 19:00 as 07:00</td>';
            } else if ($consulta_result['tipo_jornada'] == 573554) {
                $html =  $html . '<td>12x36 - 04:00 as 16:00</td>';
            } else if ($consulta_result['tipo_jornada'] == 573552) {
                $html =  $html . '<td>12x36 - 16:00 as 04:00</td>';
            } else {
                $html =  $html . '<td>Não consta</td>';
            }
            if ($consulta_result['banco_horas'] < 0) {
                $valor = $consulta_result['banco_horas'];
                $valor_final = str_replace('-', '', strval($valor));
                $html =  $html . '
                    <td style="text-align:center;background-color:#f44336; color:white; font-weight: bold;"> 
                      - ' .
                    time_from_seconds("$valor_final")
                    . '</td>';
            } else if ($consulta_result['banco_horas'] > 108000) {
                $html =  $html . '<td style="text-align:center; background-color:#FF8800; color:white; font-weight: bold;"> ' . time_from_seconds($consulta_result['banco_horas']) . '</td>';
            } else {
                $html =  $html . '<td style="text-align:center; background-color:#00c851; color:white; font-weight: bold;"> ' . time_from_seconds($consulta_result['banco_horas']) . '</td>';
            }
            $html =  $html . '
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