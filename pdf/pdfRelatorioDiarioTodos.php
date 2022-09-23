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

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial',
    'format' => 'A4-L',
    'margin_top' => 5,
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
]);

$data = $_SESSION['relatorio_diario_data'];
$periodo = $_SESSION['relatorio_diario_periodo'];
$mes = $_SESSION['relatorio_diario_mes'];
$ano = $_SESSION['relatorio_diario_ano'];

$vg_serv = 0;
$vm_serv = 0;
$vg_km = 0;
$vm_km = 0;

// HEADER DO html
$mpdf->WriteHTML('
    <head>
        <link rel="stylesheet" href="../sass/padroes.css">
    </head>

    <body>
        <section>');

// $diasDoMes = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
$diasDoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

for ($dia = 0; $dia <= $diasDoMes; $dia++) {

    if ($dia != 0) {

        $dia_atual = str_pad($dia, 2, '0', STR_PAD_LEFT);

        $data_atual = $data . '-' . $dia_atual;



        for ($i = 0; $i <= 1; $i++) {

            if ($i == 0) {
                $polo_vg = 1;
                $polo_vm = 3;
            } else {
                $polo_vg = 2;
                $polo_vm = 4;
            }

            $query_dia = "SELECT prefixo FROM `gestaocmv` WHERE data_req = '$data_atual' AND polo IN( $polo_vg, $polo_vm )";
            $result_dia = mysqli_query($conn, $query_dia);
            $row_cnt = $result_dia->num_rows;

            if ($row_cnt > 0) {

                $mpdf->WriteHTML('<div>
                <div id="titulo" style="display: flex;">
                    <div>
                        <img src="../imagens/relatorio_diario_head.jpg" alt="logo">
                    </div>');

                if ($i == 1) {
                    $mpdf->WriteHTML('<div>Emergência</div>');
                }

                $mpdf->WriteHTML('<table>
                        <tr>
                            <td>
                                <table cellspacing="0" style="float:right;width:650px">
                                    <tr>
                                        <td>
                                            Polo: Vila Guilherme
                                        </td>
                                        <td>
                                            Data: ' . date('d/m/Y', strtotime($data_atual)) . '
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table cellspacing="0" style="float:right;width:650px">
                                    <tr>
                                        <td>
                                            Polo: Vila Mariana
                                        </td>');

                if ($periodo == 0) {

                    $mpdf->WriteHTML('<td>
                        ( X ) Dia
                    </td>
                    <td>
                        ( ) Noite
                    </td>');
                } else {
                    $mpdf->WriteHTML('<td>
                        ( ) Dia
                    </td>
                    <td>
                        ( X ) Noite
                    </td>');
                }


                $mpdf->WriteHTML('</tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table border="1"  style="border-collapse: collapse; width:1200px; font-size: 13px; text-align:center; margin-top:16px;">
<thead >
    <tr style="background: #c6c6c6;">
        <td colspan="10">VILA GUILHERME
        </td>
        <td colspan="10">VILA MARIANA
        </td>
    </tr>
    <tr style="background: #c6c6c6;">
        <td colspan="2" style="width:100px;">Prefixo
        </td>
        <td colspan="2" style="width:200px;">Serviços Executados
        </td>
        <td colspan="2" style="width:100px;">KM Inicial 
        </td>
        <td colspan="2" style="width:100px;">KM Final
        </td>
        <td colspan="2" style="width:100px;">Total
        </td>
        <td colspan="2" style="width:100px;">Prefixo
        </td>
        <td colspan="2" style="width:200px;">Serviços Executados
        </td>
        <td colspan="2" style="width:100px;">KM Inicial 
        </td>
        <td colspan="2" style="width:100px;">KM Final
        </td>
        <td colspan="2" style="width:100px;">Total
        </td>
    </tr>
</thead>
<tbody>');

                // Query vila guilherme
                $query = "SELECT prefixo, servicos, kminicio, kmfim FROM `gestaocmv` WHERE data_req = '$data_atual' AND polo = $polo_vg AND periodo = $periodo ORDER BY prefixo ASC";
                
                $result = mysqli_query($conn, $query);

                $query2 = "SELECT prefixo, servicos, kminicio, kmfim FROM `gestaocmv` WHERE data_req = '$data_atual' AND polo = $polo_vm AND periodo = $periodo ORDER BY prefixo ASC";
                $result2 = mysqli_query($conn, $query2);
                $consulta_result1 = mysqli_fetch_assoc($result2);       
                $ii=0;   
                $t=0;
                $arr = array(); 
                while ($consulta_result = mysqli_fetch_assoc($result2)) { 
                    $dif = $consulta_result['kmfim'] - $consulta_result['kminicio'];
                    $arr[$ii]['prefixo']  = $consulta_result['prefixo'];
                    $arr[$ii]['servicos'] = $consulta_result['servicos'];
                    $arr[$ii]['kminicio'] = $consulta_result['kminicio'];
                    $arr[$ii]['kmfim'] = $consulta_result['kmfim']; 
                    $arr[$ii]['dif'] = $dif;
                    $ii++;
                }
                $n = $result2->num_rows;
                $n = $n -1;
                while ($consulta_result = mysqli_fetch_assoc($result)) {
                    $dif = $consulta_result['kmfim'] - $consulta_result['kminicio'];
                    $mpdf->WriteHTML('<tr>
                    <td colspan="2" style="color: #f44336; background:#ffcdd2;">' . $consulta_result['prefixo'] . '</td>
                    <td colspan="2">' . $consulta_result['servicos'] . '</td>
                    <td colspan="2">' . $consulta_result['kminicio'] . '</td>
                    <td colspan="2">' . $consulta_result['kmfim'] . '</td>
                    <td colspan="2">' . $dif . '</td>
                        ');

                    if ($t<$n) {
                            
                            $mpdf->WriteHTML('
                                                <td colspan="2" style="color: #f44336; background:#ffcdd2;">' . $arr[$t]['prefixo'] . '</td>
                                                <td colspan="2">' . $arr[$t]['servicos'].  '</td>
                                                <td colspan="2">' . $arr[$t]['kminicio']. '</td>
                                                <td colspan="2">' . $arr[$t]['kmfim'] . '</td>
                                                <td colspan="2">' . $arr[$t]['dif'] . '</td>
                                            </tr>'); 
                                $vm_serv =  $vm_serv +$arr[$t]['servicos'] ;
                                            $vm_km =  $vm_km +  $arr[$t]['dif'];              
                        }else {$mpdf->WriteHTML('</tr>');}
                        $t++; 
                    $vg_serv =  $vg_serv + $consulta_result['servicos'];
                    $vg_km =  $vg_km + $dif;
                }

                $mpdf->WriteHTML('</tbody>
                <tfoot>
                    <tr style="background: #e0e0e0;">
                        <td colspan="2">Total</td>
                        <td colspan="2">' . $vg_serv . '</td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2">' . $vg_km . '</td>
                        <td colspan="2">Total</td>
                        <td colspan="2">' . $vm_serv . '</td>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="2">' . $vm_km . '</td>
                    </tr>
                </tfoot>
                </table> 
                </div>');

                // if ($i == 0) {
                $mpdf->WriteHTML('<pagebreak>');
                // }

                $vg_serv = 0;
                $vm_serv = 0;
                $vg_km = 0;
                $vm_km = 0;
            }//fimdoIf
        }//fimdoFor
    }//fimdoIf
}//fimdoFor

$mpdf->WriteHTML('</section>
    </body>
    ');

$mpdf->Output('Relatório diario.pdf', 'i');
