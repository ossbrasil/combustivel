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


$query = 'SELECT * from ferias WHERE polo IN ('.$_GET['polo'].')';
//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial'
]);

// Opções e preferências do PDF
$mpdf->SetTitle('Relatório de Férias');
$mpdf->SetHeader('Relatório de Férias|FVB painel|Referente a data {DATE d/m/Y}');
$mpdf->SetFooter('Relatório de Férias|{PAGENO}|FVB painel');

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
                    <h1>Relatório de férias');
                $mpdf->WriteHTML('</h1>
                </div>
                <div>
                    <table id="carrega-infos">
                        <thead>
                            <tr>
                                <td>Nome
                                </td>
                                <td>CPF
                                </td>
                                <td>Polo
                                </td>
                                <td>Início
                                </td>
                                <td>Fim
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                        ');
                    if ($row_cnt > 0) {
                        while ($consulta_result = mysqli_fetch_assoc($result)) {
                            $mpdf->WriteHTML('
                            <tr>
                        <td>' . $consulta_result['nome'] . '
                        </td>
                        <td>' . $consulta_result['cpf'] . '
                        </td>');
                if ($consulta_result['polo'] == 75992 || $consulta_result['polo'] == 70404) {
                    $mpdf->WriteHTML('<td>Vl. Guilherme</td>');
                } else if ($consulta_result['polo'] == 75993 || $consulta_result['polo'] == 81142) {
                    $mpdf->WriteHTML('<td>Vl. Mariana</td>');
                } else {
                    $mpdf->WriteHTML('<td>Não consta</td>');
                }
                $mpdf->WriteHTML('
                        <td>' . date('d/m/Y', strtotime($consulta_result['inicio_ferias'])) . '
                        </td>
                        <td>' . date('d/m/Y', strtotime($consulta_result['fim_ferias'])) . '
                        </td>
                    </tr>
                            ');
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

$mpdf->Output('Relatório de ferias.pdf', 'i');
