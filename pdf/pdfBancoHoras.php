<?php

session_start();

require_once __DIR__ . '../../vendor/autoload.php';


//conexao DB
$servidor = "34.151.252.46";
$usuario = "root";
$senha = "abc123**";
$dbname = "fvblocadora";

//Realiza Conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
$conn->set_charset("utf8");


$query = 'SELECT * FROM `motoristas` WHERE `polo` IN (' . $_GET['polo'] . ')';
//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy"));

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

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial'
]);

// Opções e preferências do PDF
$mpdf->SetTitle('Relatório de banco de horas');
$mpdf->SetHeader('Banco de horas|FVB painel|Referente a data {DATE d/m/Y}');
$mpdf->SetFooter('Banco de horas|{PAGENO}|FVB painel');

// HEADER DO html
$mpdf->WriteHTML('
    <head>
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../sass/padroes.css">
    </head>

    <body>
        <section id="pdfMotoristas">
            <div>
                <div id="titulo">
                    <h1>Banco de horas');
                $mpdf->WriteHTML('</h1>
                </div>
                <div>
                    <table id="carrega-infos">
                        <thead>
                            <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Polo</th>
                            <th>Jornada</th>
                            <th>Horas Extras</th>
                            </tr>
                        </thead>
                        <tbody>');
                    if ($row_cnt > 0) {
                        while ($consulta_result = mysqli_fetch_assoc($result)) {
                            $mpdf->WriteHTML( '
                                <tr id="' . $consulta_result['id'] . '">
                                    <td>' . $consulta_result['nome'] . '
                                    </td>
                                    <td>' . $consulta_result['cpf'] . '
                                    </td>
                            ');
                            if ($consulta_result['polo'] == 75992 || $consulta_result['polo'] == 70404) {
                                $mpdf->WriteHTML( '<td>Vl. Guilherme</td>');
                            } else if ($consulta_result['polo'] == 75993 || $consulta_result['polo'] == 81142) {
                                $mpdf->WriteHTML( '<td>Vl. Mariana</td>');
                            } else {
                                $mpdf->WriteHTML( '<td>Não consta</td>');
                            }
                            if ($consulta_result['tipo_jornada'] == 613578 || $consulta_result['tipo_jornada'] == 613674) {
                                $mpdf->WriteHTML( '<td>12 x 36 - 06:00 as 18:00</td>');
                            } else if ($consulta_result['tipo_jornada'] == 544309 || $consulta_result['tipo_jornada'] == 613669) {
                                $mpdf->WriteHTML( '<td>12 x 36 - 18:00 as 06:00</td>');
                            } else if ($consulta_result['tipo_jornada'] == 613574 ) {
                                $mpdf->WriteHTML( '<td>12x 36 - 07:00 as 19:00</td>');
                            } else if ($consulta_result['tipo_jornada'] == 613576) {
                                $mpdf->WriteHTML( '<td>12x36 - 19:00 as 07:00</td>');
                            } else if ($consulta_result['tipo_jornada'] == 573554) {
                                $mpdf->WriteHTML( '<td>12x36 - 04:00 as 16:00</td>');
                            } else if ($consulta_result['tipo_jornada'] == 573552) {
                                $mpdf->WriteHTML( '<td>12x36 - 16:00 as 04:00</td>');
                            } else {
                                $mpdf->WriteHTML( '<td>Não consta</td>');
                            }
                            if($consulta_result['banco_horas'] < 0){
                                $valor = $consulta_result['banco_horas'];
                                $valor_final = str_replace('-', '', strval($valor));
                                $mpdf->WriteHTML( '
                                    <td style="text-align:center;background-color:#f44336; color:white; font-weight: bold;"> - '.
                                        time_from_seconds($valor_final)
                                    .'</td>');
                            } else if ($consulta_result['banco_horas'] > 108000) {
                                $mpdf->WriteHTML( '<td style="text-align:center; background-color:#FF8800; color:white; font-weight: bold;">'.time_from_seconds($consulta_result['banco_horas']).'</td>');
                            } else {
                                $mpdf->WriteHTML( '<td style="text-align:center; background-color:#00c851; color:white; font-weight: bold;">'.time_from_seconds($consulta_result['banco_horas']).'</td>');
                            }
                            $mpdf->WriteHTML( '
                            </tr>');
                        }
                    }
                $mpdf->WriteHTML('
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </body>
    ');

$mpdf->Output('Banco de horas.pdf', 'i');
