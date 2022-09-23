<?php
session_start();

//conexao DB
$servidor = "34.151.252.46";
$usuario = "root";
$senha = "abc123**";
$dbname = "fvblocadora";

//Realiza Conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
$conn->set_charset("utf8");

$query = 'SELECT * FROM `motoristas` WHERE `polo` IN (' . $_GET['polo'] . ')';

//Query do Banco
$result = mysqli_query($conn, $query);
$row_cnt = $result->num_rows;
//Fim

?>

<html>

<head>
    <meta charset="utf-8">
    <title>Relatório Eventos</title>
    <style>
        h1 {
            margin: 0;
            padding: 0;
            width: fit-content;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            vertical-align: middle;
            font-size: 20px;
        }

        .newtamanho{
            display: flex;
        }
    </style>
</head>

<body>
    <?php
    $html = '
    <div class=newtamanho>
    <img src="../imagens/Prefeitura_de_Sao_Paulo_Centralizado_Preferencial.png" alt="Logo Prefeitura" width="75px">
    <h1>Mapa de controle de Movimentação de veículos</h1>
    </div>
        <small>Referente a data de ' . date('d/m/Y') . '</small>
        <table>
        <thead>
            <tr>
                <td class="grey">CMV N°</td>
                <td class="grey">Prefixo</td>
                <td class="grey">Placa</td>
                <td class="grey">Motorista</td>
                <td class="grey">Matricula</td>
                <td class="grey">Serviços Executados</td>
                <td colspan="2">Horário de serviço<br>Início | Término</td>
                <td class="grey">CMV prenchida?</td>
                <td colspan="2">KM<br>Início | Término</td>
                <td class="grey">OBS</td>
            </tr>
        </thead>
        <tbody id="carregaMapaMov">
            <tr>
                <td>106309
                </td>
                <td>660
                </td>
                <td>FQM-6191
                </td>
                <td>ARNALDO BOCZ JUNIOR
                </td>
                <td>70399
                </td>
                <td>2
                </td>
                <td>18:25
                </td>
                <td>05:07
                </td>
                <td>Sim
                </td>
                <td>152.650
                </td>
                <td>152.723
                </td>
                <td>OBS N.o
                </td>
            </tr>
        </tbody>';
    $html = $html . ' </table> ';
    $arquivo = "Relatorio de Veículos.xls";
    header("Expires: 0");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
    header("Content-Description: PHP Generated Data");

    echo $html;
    exit; ?>
</body>

</html>