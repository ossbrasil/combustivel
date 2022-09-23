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
    'margin_left' => 17,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
]);


$data = new DateTime($_GET['dataFiltro']);
$d = $data->format('d/m/Y');

// Opções e preferências do PDF
// HEADER DO html
$mpdf->WriteHTML('
    <head>
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../sass/padroes.css">
    </head>
    <body>
        <section>
            <div>
                <div id="titulo" style="display: flex;">
                    <div>
                        <img src="../imagens/cmd01_head.jpg" alt="logo">
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                CMV n°: ' . $_GET['cmv'] . '
                            </td>
                            <td>
                                Data: ' . $d . '
                            </td>

                            <td>
                                Prefixo: ' . $_GET['prefixo'] . '
                            </td>

                        </tr>
                        <tr>
                            <td>
                                Motorista: ' . $_GET['motorista'] . '
                            </td>

                            <td>
                                Matríula: ' . $_GET['matricula'] . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <img src="../imagens/cmv_body_1.jpg" alt="pg_1" height="942">
            </div>
            
            <div>
                <img src="../imagens/cmv_body_2.jpg" alt="pg_2">
            </div>

        </section>
    </body>
    ');

$mpdf->Output('Relatório de CMV ' . $_GET['cmv'] . '.pdf', 'D');
