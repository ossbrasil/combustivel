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


$query = 'SELECT * FROM `dobras` WHERE `polo` IN ('.$_GET['polo'].')';
//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial'
]);

// Opções e preferências do PDF
$mpdf->SetTitle('Relatório de Plantão avulso');
$mpdf->SetHeader('Relatório de Plantão avulso|FVB painel|Referente a data {DATE d/m/Y}');
$mpdf->SetFooter('Relatório de Plantão avulso|{PAGENO}|FVB painel');

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
                    <h1>Relatório de plantão avulso');
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
                            <td>Justificativa
                            </td>
                            <td>Polo
                            </td>
                            <td>Data da Plantão Avulso
                            </td>
                            <td>Turno Plantão Avulso
                            </td>
                            </tr>
                        </thead>
                        <tbody>
                        ');
                    if ($row_cnt > 0) {
                        while ($consulta_result = mysqli_fetch_assoc($result)) {
                            $mpdf->WriteHTML('
                            <tr id="' . $consulta_result['id'] . '">
                                <td >' . $consulta_result['nome'] . '
                                </td>
                                <td >' . $consulta_result['cpf'] . '
                                </td>
                                <td >' . $consulta_result['justificativa'] . '
                                </td>');
                                if ($consulta_result['polo'] == 75992 || $consulta_result['polo'] == 70404) {
                                    $mpdf->WriteHTML('<td >Vl. Guilherme</td>');
                                } else if ($consulta_result['polo'] == 75993 || $consulta_result['polo'] == 81142) {
                                    $mpdf->WriteHTML('<td >Vl. Mariana</td>');
                                } else {
                                    $mpdf->WriteHTML('<td >Não consta</td>');
                                }
                                $mpdf->WriteHTML('
                                <td >' . date('d/m/Y', strtotime($consulta_result['data'])) . '
                                </td>');
                            if ($consulta_result['turno_dobrado'] == "613578,613674") {
                                $mpdf->WriteHTML('<td >12 x 36 - 06:00 as 18:00</td>');
                            } else if ($consulta_result['turno_dobrado'] == "544309,613669") {
                                $mpdf->WriteHTML('<td >12 x 36 - 18:00 as 06:00</td>');
                            } else if ($consulta_result['turno_dobrado'] == 613574) {
                                $mpdf->WriteHTML('<td >12x 36 - 07:00 as 19:00</td>');
                            } else if ($consulta_result['turno_dobrado'] == 613576) {
                                $mpdf->WriteHTML('<td >12x36 - 19:00 as 07:00</td>');
                            } else if ($consulta_result['turno_dobrado'] == 573554) {
                                $mpdf->WriteHTML('<td >12x36 - 04:00 as 16:00</td>');
                            } else if ($consulta_result['turno_dobrado'] == 573552) {
                                $mpdf->WriteHTML('<td >12x36 - 16:00 as 04:00</td>');
                            } else {
                                $mpdf->WriteHTML('<td >Não consta</td>');
                            }
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

$mpdf->Output('Relatório de plantão avulso.pdf', 'i');
