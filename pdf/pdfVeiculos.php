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


$query = 'SELECT * FROM `veiculos`';
//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial'
]);

// Opções e preferências do PDF
$mpdf->SetTitle('Relatório de Veículos');
$mpdf->SetHeader('Relatório de Veículos|FVB painel|Referente a data {DATE d/m/Y}');
$mpdf->SetFooter('Relatório de Veículos|{PAGENO}|FVB painel');

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
                    <h1>Relatório de Veículos');
                $mpdf->WriteHTML('</h1>
                </div>
                <div>
                    <table id="carrega-infos">
                        <thead>
                            <tr>
                                <td>Prefixo
                                </td>
                                <td>Placa
                                </td>
                                <td>Marca
                                </td>
                                <td>Modelo
                                </td>
                                <td>Ano
                                </td>
                                <td>Modelo
                                </td>
                                <td>Combustível
                                </td>
                                <td>Seguradora
                                </td>
                                <td>Contrato
                                </td>
                                </tr>
                        </thead>
                        <tbody>
                        ');
                    if ($row_cnt > 0) {
                        while ($consulta_result = mysqli_fetch_assoc($result)) {

                            $marca_modelo = preg_split("#/#", $consulta_result['marca_modelo']);
            
                            $ano_modelo = preg_split("#/#", $consulta_result['ano_modelo']);
            
                            $mpdf->WriteHTML('
                                <tr>
                                    <td class="th-sm align-middle align-middle" style="text-align: center;">' . $consulta_result['prefixo'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['placa'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $marca_modelo['0'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $marca_modelo['1'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $ano_modelo['0'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $ano_modelo['1'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['combustivel'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . $consulta_result['seguro'] . '
                                    </td>
                                    <td class="th-sm text-center align-middle">' . strtoupper($consulta_result['contrato']) . '
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

$mpdf->Output('Relatório de Veiculos.pdf', 'i');
