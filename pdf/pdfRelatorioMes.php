<?php

session_start();

require_once __DIR__ . '../../vendor/autoload.php';

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//conexao DB
$servidor = "34.151.252.46";
$usuario = "root";
$senha = "abc123**";
$dbname = "fvblocadora";

//Realiza Conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
$conn->set_charset("utf8");

$mes = $_SESSION['relatorio_infomes'];
$ano = $_SESSION['relatorio_infoano'];
$tipo = $_SESSION['relatorio_infotipo'];

if ($mes == '01') {
    $mes_a = "janeiro";
} elseif ($mes == '02') {
    $mes_a = "fevereiro";
} elseif ($mes == '03') {
    $mes_a = "março";
} elseif ($mes == '04') {
    $mes_a = "abril";
} elseif ($mes == '05') {
    $mes_a = "maio";
} elseif ($mes == '06') {
    $mes_a = "junho";
} elseif ($mes == '07') {
    $mes_a = "julho";
} elseif ($mes == '08') {
    $mes_a = "agosto";
} elseif ($mes == '09') {
    $mes_a = "setembro";
} elseif ($mes == '10') {
    $mes_a = "outubro";
} elseif ($mes == '11') {
    $mes_a = "novembro";
} elseif ($mes == '12') {
    $mes_a = "dezembro";
}


$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial',
    'margin_top' => 5,
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
]);

// Opções e preferências do PDF

$poloName = '';
$diasDoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

// $diasDoMes = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
// HEADER DO html
$mpdf->charset_in = 'iso-8859-1';
$mpdf->WriteHTML('
    <head>
        <link rel="stylesheet" href="../sass/padroes.css">
        <style>
            table{
                border: 1px solid black;
                border-collapse: collapse;
                font-weight: bold;
            }
            tr{
                border: 1px solid black;
            }
            td{
                border: 1px solid black;
                padding: 2px;
            }
        </style>
    </head>

    <body>
        <section>
            <div>
                <div id="titulo" style="display: flex;">
                    <div>
                        <img src="../imagens/relatorio_mes_head.jpg" alt="logo">
                    </div>
                </div>
            </div>
            <div>
                <div id="titulo" style="display: flex;">
                    <div style="width: 100%; font-size: 18px; text-align:center; ">
                        Resumo geral ' . $mes_a . ' de ' . $ano . '
                    </div>
                </div>
            </div>
            <table style="width: 100%; font-size: 13px; text-align:center; margin-top:16px;">
                <thead >
                    <tr style="background: #c6c6c6;">
                        <td rowspan="3">Dias
                        </td>
                        <td colspan="4">VILA GUILHERME
                        </td>
                        <td colspan="4">VILA MARIANA
                        </td>
                    </tr>
                    <tr style="background: #c6c6c6;">
                        <td colspan="2">Serviços Executados
                        </td>
                        <td colspan="2">KM Percorrida
                        </td>
                        <td colspan="2">Serviços Executados
                        </td>
                        <td colspan="2">KM Percorrida
                        </td>
                    </tr>
                    <tr style="background: #c6c6c6;">
                        <td>Dia
                        </td>
                        <td>Noite
                        </td>
                        <td>Dia
                        </td>
                        <td>Noite
                        </td>
                        <td>Dia
                        </td>
                        <td>Noite
                        </td>
                        <td>Dia
                        </td>
                        <td>Noite
                        </td>
                    </tr>
                </thead>
                <tbody>');


if ($tipo == 0) {
    $polo_vg = 1;
    $polo_vm = 3;
} else {
    $polo_vg = 2;
    $polo_vm = 4;
}

$vg_serv_dia_total = 0;
$vg_serv_noite_total = 0;
$vg_km_dia_total = 0;
$vg_km_noite_total = 0;
$vm_serv_dia_total = 0;
$vm_serv_noite_total = 0;
$vm_km_dia_total = 0;
$vm_km_noite_total = 0;

$vg_serv_dia = 0;
$vg_km_dia = 0;
$vg_serv_noite = 0;
$vg_km_noite = 0;
$vm_serv_dia = 0;
$vm_km_dia = 0;
$vm_serv_noite = 0;
$vm_km_noite = 0;

for ($i = 0; $i <= $diasDoMes; $i++) {

    if ($i != 0) {

        $dia = str_pad($i, 2, '0', STR_PAD_LEFT);

        $data = $ano . "-" . $mes . "-" . $dia;

        // Query da vila guilherme dia
        $queryvg = "SELECT servicos, kmfim, kminicio FROM `gestaocmv` WHERE data_req = '$data' AND polo = '$polo_vg' AND periodo = '0'";
        // $queryvg = "SELECT * FROM `gestaocmv` WHERE data_req = '$data' AND polo = '1' AND periodo = 'dia'";
        $result = mysqli_query($conn, $queryvg);
        $row_cnt = $result->num_rows;

        if ($row_cnt > 0) {
            while ($consulta_result = mysqli_fetch_assoc($result)) {
                $serv = $consulta_result['servicos'];
                $vg_serv_dia =  $vg_serv_dia + $serv;

                $km_atual = $consulta_result['kmfim'] - $consulta_result['kminicio'];
                $vg_km_dia = $vg_km_dia + $km_atual;
            }
        } else {
            $vg_serv_dia = 0;
            $vg_km_dia = 0;
        }

        // Query da vila guilherme noite
        $queryvg = "SELECT servicos, kmfim, kminicio FROM `gestaocmv` WHERE data_req = '$data' AND polo = '$polo_vg' AND periodo = '1'";
        // $queryvg = "SELECT * FROM `gestaocmv` WHERE data_req = '$data' AND polo = '1' AND periodo = 'noite'";
        $result = mysqli_query($conn, $queryvg);
        $row_cnt = $result->num_rows;

        if ($row_cnt > 0) {
            while ($consulta_result = mysqli_fetch_assoc($result)) {
                $serv = $consulta_result['servicos'];
                $vg_serv_noite =  $vg_serv_noite + $serv;

                $km_atual = $consulta_result['kmfim'] - $consulta_result['kminicio'];
                $vg_km_noite = $vg_km_noite + $km_atual;
            }
        } else {
            $vg_serv_noite = 0;
            $vg_km_noite = 0;
        }

        // Query da vila mariana dia
        $queryvm = "SELECT servicos, kmfim, kminicio FROM `gestaocmv` WHERE data_req = '$data' AND polo = '$polo_vm' AND periodo = '0'";
        // $queryvm = "SELECT * FROM `gestaocmv` WHERE data_req = '$data' AND polo = '3' AND periodo = 'dia'";
        $result = mysqli_query($conn, $queryvm);
        $row_cnt = $result->num_rows;

        if ($row_cnt > 0) {
            while ($consulta_result = mysqli_fetch_assoc($result)) {
                $serv = $consulta_result['servicos'];
                $vm_serv_dia =  $vm_serv_dia + $serv;

                $km_atual = $consulta_result['kmfim'] - $consulta_result['kminicio'];
                $vm_km_dia = $vm_km_dia + $km_atual;
            }
        } else {
            $vm_serv_dia = 0;
            $vm_km_dia = 0;
        }

        // Query da vila mariana noite
        $queryvm = "SELECT servicos, kmfim, kminicio FROM `gestaocmv` WHERE data_req = '$data' AND polo = '$polo_vm' AND periodo = '1'";
        // $queryvm = "SELECT * FROM `gestaocmv` WHERE data_req = '$data' AND polo = '3' AND periodo = 'noite'";
        $result = mysqli_query($conn, $queryvm);
        $row_cnt = $result->num_rows;

        if ($row_cnt > 0) {
            while ($consulta_result = mysqli_fetch_assoc($result)) {
                $serv = $consulta_result['servicos'];
                $vm_serv_noite =  $vm_serv_noite + $serv;

                $km_atual = $consulta_result['kmfim'] - $consulta_result['kminicio'];
                $vm_km_noite = $vm_km_noite + $km_atual;
            }
        } else {
            $vm_serv_noite = 0;
            $vm_km_noite = 0;
        }

        $mpdf->WriteHTML('
                    <tr>
                        <td>' . $dia . '</td>s
                        <td>' . $vg_serv_dia . '</td>
                        <td>' . $vg_serv_noite . '</td>
                        <td>' . $vg_km_dia . '</td>
                        <td>' . $vg_km_noite . '</td>
                        <td>' . $vm_serv_dia . '</td>
                        <td>' . $vm_serv_noite . '</td>
                        <td>' . $vm_km_dia . '</td>
                        <td>' . $vm_km_noite . '</td>
                    </tr>
                    ');

        $vg_serv_dia_total = $vg_serv_dia_total + $vg_serv_dia;
        $vg_serv_noite_total = $vg_serv_noite_total + $vg_serv_noite;
        $vg_km_dia_total = $vg_km_dia_total + $vg_km_dia;
        $vg_km_noite_total = $vg_km_noite_total + $vg_km_noite;
        $vm_serv_dia_total = $vm_serv_dia_total + $vm_serv_dia;
        $vm_serv_noite_total = $vm_serv_noite_total + $vm_serv_noite;
        $vm_km_dia_total = $vm_km_dia_total + $vm_km_dia;
        $vm_km_noite_total = $vm_km_noite_total + $vm_km_noite;

        $vg_serv_dia = 0;
        $vg_km_dia = 0;
        $vg_serv_noite = 0;
        $vg_km_noite = 0;
        $vm_serv_dia = 0;
        $vm_km_dia = 0;
        $vm_serv_noite = 0;
        $vm_km_noite = 0;
    }
}

$serv_vg = $vg_serv_dia_total + $vg_serv_noite_total;
$km_vg = $vg_km_dia_total + $vg_km_noite_total;
$serv_vm = $vm_serv_dia_total + $vm_serv_noite_total;
$km_vm = $vm_km_dia_total + $vm_km_noite_total;

$serv_dia = $vg_serv_dia_total + $vm_serv_dia_total;
$serv_noite = $vg_serv_noite_total + $vm_serv_noite_total;
$km_dia = $vg_km_dia_total + $vm_km_dia_total;
$km_noite = $vg_km_noite_total + $vm_km_noite_total;

$total_serv = $serv_dia + $serv_noite;
$total_km = $km_dia + $km_noite;

$mpdf->WriteHTML('</tbody>
                <tfoot >

                    <tr style="background: #c6c6c6;">
                    <td rowspan="2">Totais
                        </td>
                        <td>' . $vg_serv_dia_total . '
                        </td>
                        <td>' . $vg_serv_noite_total . '
                        </td>
                        <td>' . $vg_km_dia_total . '
                        </td>
                        <td>' . $vg_km_noite_total . '
                        </td>
                        <td>' . $vm_serv_dia_total . '
                        </td>
                        <td>' . $vm_serv_noite_total . '
                        </td>
                        <td>' . $vm_km_dia_total . '
                        </td>
                        <td>' . $vm_km_noite_total . '
                        </td>
                    </tr>
                    <tr style="background: #c6c6c6;">
                        <td colspan="2">' . $serv_vg . '
                        </td>
                        <td colspan="2">' . $km_vg . '
                        </td>
                        <td colspan="2">' . $serv_vm . '
                        </td>
                        <td colspan="2">' . $km_vm . '
                        </td>
                    </tr>
                </tfoot>
            </table>

            <table style="width: 100%; font-size: 13px; text-align:center; margin-top:16px;">
                <tr  style="background: #c6c6c6;">
                    <td colspan="3">Serviços Executados</td>
                    <td>Dia</td>
                    <td>Noite</td>
                    <td colspan="2">Km Percorrida</td>
                    <td>Dia</td>
                    <td>Noite</td>
                </tr>
                <tr  style="background: #c6c6c6;">
                    <td colspan="3">Totais:</td>
                    <td style="background: #FFFFFF;">' . $serv_dia . '</td>
                    <td style="background: #FFFFFF;">' . $serv_noite . '</td>
                    <td colspan="2">Totais</td>
                    <td style="background: #FFFFFF;">' . $km_dia . '</td>
                    <td style="background: #FFFFFF;">' . $km_noite . '</td>
                </tr>
                <tr style="background: #c6c6c6;">
                    <td colspan="3">Total Geral:</td>
                    <td colspan="2">' . $total_serv . '</td>
                    <td colspan="2">Total Geral:</td>
                    <td colspan="2">' . $total_km . '</td>
                </tr>
            </table>
            <div style="width: 100%; text-align:center;">
                <p>' . strftime('%A, %d de %B de %Y', strtotime('today')) . '</p>
            </div>
            <div>
                <img src="../imagens/relatorio_mes_foot.jpg" alt="logo">
            </div>
            
        </section>
    </body>
    ');


// ob_clean();
$mpdf->Output('Relatorio_mensal.pdf', 'D');
