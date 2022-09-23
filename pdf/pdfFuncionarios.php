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


$query = 'SELECT id, nome, cnh, validade_cnh, centro_custo, ctps FROM `funcionarios` ORDER BY `funcionarios`.`nome` ASC';
//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial'
]);

// Opções e preferências do PDF
$mpdf->SetTitle('Relatório de Funcionarios');
$mpdf->SetHeader('Relatório de Funcionarios|FVB painel|Referente a data {DATE d/m/Y}');
$mpdf->SetFooter('Relatório de Funcionarios|{PAGENO}|FVB painel');

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
                    <h1>Relatório de funcionarios');
                $mpdf->WriteHTML('</h1>
                </div>
                <div>
                    <table id="carrega-infos">
                        <thead>
                            <tr>
                                <td>Nome
                                </td>
                                <td>CNH
                                </td>
                                <td>Validade CNH
                                </td>
                                <td>CTPS
                                </td>
                                <td>Contrato
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                        ');
                    if ($row_cnt > 0) {
                        while ($consulta_result = mysqli_fetch_assoc($result)) {
                            $mpdf->WriteHTML('
                                <tr>
                                    <td class="th-sm align-middle">' . $consulta_result['nome'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['cnh'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . date('d/m/Y', strtotime($consulta_result['validade_cnh'])) . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['ctps'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['centro_custo'] . '
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

$mpdf->Output('Relatório de Funcionarios.pdf', 'i');
