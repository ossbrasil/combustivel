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

if ($_GET['filtro'] == 1) {
    $query = "SELECT * FROM `gestaocmv` WHERE `polo` = '" . $_GET['polo'] . "' AND `data_req` = '" . $_GET['dataFiltro'] . "' AND `periodo` = '" . $_GET['periodo'] . "' ORDER BY `gestaocmv`.`numero_cmv` ASC";
} else {
    $query = "SELECT * FROM `gestaocmv` ORDER BY `gestaocmv`.`numero_cmv` ASC";
}

//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial',
    'mode' => 'utf-8',
    'format' => 'A4-L',
    'margin_top' => 5,
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
]);

if ($_GET['polo'] == 1) {
    $poloName = 'Vila Guilherme C';
} else if ($_GET['polo'] == 2) {
    $poloName = 'Vila Guilherme E';
} else if ($_GET['polo'] == 3) {
    $poloName = 'Vila Mariana C';
} else if ($_GET['polo'] == 4) {
    $poloName = 'Vila Mariana E';
}
// Opções e preferências do PDF

// HEADER DO html

$data = new DateTime($_GET['dataFiltro']);
$d = $data->format('d/m/Y');
$mpdf->WriteHTML('
    
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../sass/padroes.css">
    <style>

      table#carrega-infos {
        font-size: 14px;
        border-collapse: collapse;
        padding:0;
        margin:0;
      }

      .text-center{
          text-align: center;
      }

    </style>
</head>

<body>
    <section id="pdfMotoristas">
        <div>
            <div>
                <img src="../imagens/os_head.jpg" alt="logo">
            </div>
            <table style="width: 100%; padding-bottom: 6px;">
            ');
            if ($_GET['filtro'] == 1) {
                $mpdf->WriteHTML('
                <tr>
                    <td>
                        Polo: ' . $poloName . '
                    </td>
                    <td>
                        Encarregado: 0
                    </td>
                    
                    <td>
                        Data: ' . $d . '
                    </td>');
                    if ($_GET['periodo'] == 1) {
                        $mpdf->WriteHTML('
                            <td>
                                Dia ( )
                            </td>
                            <td>
                                Noite (X)
                            </td>
                        ');
                    } else {
                        $mpdf->WriteHTML('
                            <td>
                                Dia (X)
                            </td>
                            <td>
                                Noite ( )
                            </td>
                        ');
                    }
                    $mpdf->WriteHTML('</tr>
                ');
            } else {
                $mpdf->WriteHTML('
                <tr>
                    <td>
                        Polo: Todos os polos
                    </td>
                    <td>
                        Encarregado: Não definido
                    </td>
                    
                    <td>
                        Data: '. date('d/m/Y') .'
                    </td>
                    <td>
                        Dia (X)
                    </td>
                    <td>
                        Noite (X)
                    </td>
                </tr>
                ');
            }
            $mpdf->WriteHTML('
            </table>
            <div>
                <table id="carrega-infos" style="width:100%;">
                    <thead >
                        <tr style="background: #c6c6c6;">
                            <td rowspan="2">CMV N°
                            </td>
                            <td rowspan="2">Prefixo
                            </td>
                            <td rowspan="2">Placa
                            </td>
                            <td rowspan="2">Motorista
                            </td>
                            <td rowspan="2">Matricula
                            </td>
                            <td rowspan="2">Serviços Executados
                            </td>
                            <td colspan="2">Hr de serviço 
                            </td>
                            <td colspan="2">CMV prenchida?
                            </td>
                            <td rowspan="2">Obs N°
                            </td>
                        </tr>
                        <tr style="background: #c6c6c6;">
                            <td>Início
                            </td>
                            <td>Fim
                            </td>
                            <td>Sim
                            </td>
                            <td>Não
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    ');
                    if ($row_cnt > 0) {
                        while ($consulta_result = mysqli_fetch_assoc($result)) {
                            $mpdf->WriteHTML('
                            <tr>
                                <td class="text-center">' . $consulta_result['numero_cmv'] . '
                                </td>
                                <td class="text-center" >' . $consulta_result['prefixo'] . '
                                </td>
                                <td class="text-center" >' . $consulta_result['placa'] . '
                                </td>
                                <td >' . $consulta_result['motorista'] . '
                                </td>
                                <td class="text-center" >' . $consulta_result['matricula'] . '
                                </td>
                                <td class="text-center" >' . $consulta_result['servicos'] . '
                                </td>
                                <td class="text-center" >' . $consulta_result['horarioinicio'] . '
                                </td>
                                <td class="text-center" >' . $consulta_result['horariofim'] . '
                                </td>
                            ');
                            if ($consulta_result['cmvpreenchida'] == 1) {
                                $mpdf->WriteHTML('
                                <td class="text-center">X</td>
                                <td></td>
                                ');
                            } else {
                                $mpdf->WriteHTML('
                                <td></td>
                                <td class="text-center">X</td>
                                ');
                            }
                            $mpdf->WriteHTML('
                                <td >' . $consulta_result['obs'] . '
                                </td>
                            ');
                            
                            $mpdf->WriteHTML('
                            </tr>');
                        }
                    } else {
                        $mpdf->WriteHTML('<tr><td colspan="5">Nenhum registro encontrado</td></tr>');
                    }
                $mpdf->WriteHTML('
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
');

$mpdf->Output('Relatório de CMV.pdf', 'D');
