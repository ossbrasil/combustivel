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


$query = 'SELECT * FROM `fornecedores`';
//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial'
]);

// Opções e preferências do PDF
$mpdf->SetTitle('Relatório de Fornecedores');
$mpdf->SetHeader('Relatório de Fornecedores|FVB painel|Referente a data {DATE d/m/Y}');
$mpdf->SetFooter('Relatório de Fornecedores|{PAGENO}|FVB painel');

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
                    <h1>Relatório de fornecedores');
                $mpdf->WriteHTML('</h1>
                </div>
                <div>
                    <table id="carrega-infos">
                        <thead>
                            <tr>
                                <td>Nome do fornecedor
                                </td>
                                <td>Razão social
                                </td>
                                <td>CNPJ
                                </td>
                                <td>Endereço
                                </td>
                                <td>Contato
                                </td>
                                <td>Telefone
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                        ');
                    if ($row_cnt > 0) {
                        while ($consulta_result = mysqli_fetch_assoc($result)) {
                            $mpdf->WriteHTML('
                                <tr>
                                    <td class="th-sm align-middle">' . $consulta_result['nome_oficina'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['razao_social'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['cnpj'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['endereco'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['contato'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['telefone'] . '
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

$mpdf->Output('Relatório de Fornecedores.pdf', 'i');
