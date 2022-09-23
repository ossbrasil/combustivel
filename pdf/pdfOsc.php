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
    'margin_top' => 5,
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
]);

// Opções e preferências do PDF

$poloName = '';

if ($_GET['polo'] == 1) {
    $poloName = 'Vila Guilherme C';
} else if ($_GET['polo'] == 2) {
    $poloName = 'Vila Guilherme E';
} else if ($_GET['polo'] == 3) {
    $poloName = 'Vila Mariana C';
} else if ($_GET['polo'] == 4) {
    $poloName = 'Vila Mariana E';
}
$data = new DateTime($_GET['dataFiltro']);
$d = $data->format('d/m/Y');
// HEADER DO html
$mpdf->WriteHTML('
    <head>
        <link rel="stylesheet" href="../sass/padroes.css">
    </head>

    <body>
        <section>
            <div>
                <div id="titulo" style="display: flex;">
                    <div>
                        <img src="../imagens/os_head.jpg" alt="logo">
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                N°: ' . $_GET['cmv'] . '
                            </td>
                            <td>
                                Polo: ' . $poloName . '
                            </td>
                            
                        </tr>
                        <tr>
                            <td>
                                Motorista: ' . $_GET['motorista'] . '
                            </td>

                            <td>
                                Matríula: ' . $_GET['matricula'] . '
                            </td>
                            
                            <td>
                                Prefixo: ' . $_GET['prefixo'] . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <img src="../imagens/osc_body_noDate.jpg" alt="pg_1" height="942">
            </div>
            <div style="width:100%; text-align:center;">
                <h5>' . $d
                 . '</h5>
            </div>
            <div>
                <img src="../imagens/osc_body_noDate_ass.jpg" alt="pg_1" height="942">
            </div>
        </section>
    </body>
    ');

$mpdf->Output('Relatório de OS ' . $_GET['cmv'] . '.pdf', 'D');
