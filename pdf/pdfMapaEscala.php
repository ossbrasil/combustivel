<?php

session_start();

require_once __DIR__ . '../../vendor/autoload.php';

// // conexao DB online
$servidor = "34.151.252.46";
$usuario = "root";
$senha = "abc123**";
$dbname = "fvblocadora";

//Realiza Conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
$conn->set_charset("utf8");

$query = 'SELECT * FROM `motoristas` WHERE polo IN (' . $_GET['polo'] . ') ORDER BY `motoristas`.`nome` LIMIT ' . $_GET['limitMin'] . ', ' . $_GET['limitMax'] . '';

//Captura o Resultado
$result = mysqli_query($conn, $query);

//Conta as linhas que retornaram
$row_cnt = $result->num_rows;

$mesAtual = $_GET['mesSelecionado'];

$anoAtual = date('Y');

$diasDoMes = cal_days_in_month(CAL_GREGORIAN, $mesAtual, $anoAtual);

$diasDoMesAnterior = cal_days_in_month(CAL_GREGORIAN, $mesAtual - 1, $anoAtual);

$token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy"));

try {

    $mpdf = new \Mpdf\Mpdf([
        'default_font' => 'arial'
    ]);

    // Opções e preferências do PDF
    $mpdf->SetTitle('Relatório de Escalas');
    $mpdf->SetHeader('Mapa de Escala|FVB painel|Referente a data {DATE d/m/Y}');
    $mpdf->SetFooter('Mapa de Escala|{PAGENO}|FVB painel');

    // HEADER DO html
    $mpdf->WriteHTML('
    <head>
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../sass/padroes.css">
    </head>
    <style>
        .secondary-color-dark{
            background-color: #9933CC;
            padding: 0px !important;
            margin: 0px !important;
        }
        .info-color{
            background-color: #33b5e5;
            padding: 0px !important;
            margin: 0px !important;
        }
        .red{
            background-color: #ff4444;
            padding: 0px !important;
            margin: 0px !important;
        }
        .green{
            background-color: #00C851;
            padding: 0px !important;
            margin: 0px !important;
        }
        .warning-color{
            background-color: #FF8800;
            padding: 0px !important;
            margin: 0px !important;
        }
        .rgba-stylish-strong{
            background-color: #79859a;
            padding: 0px !important;
            margin: 0px !important;
        }
        .p-0{
            padding: 0px !important;
            margin: 0px !important
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
          }
        tr {
            border-collapse: collapse;
            border-spacing: 0;
          }
          
    </style>
    <body>
        <section id="pdfMotoristas">
            <div>
                <div id="titulo">
                    <h1>Mapa de Escala');
    $mpdf->WriteHTML('</h1>
                </div>
                <div>
                    <table id="carrega-infos">
                        <thead>
                            <tr>
                                <td>Motoristas</td>
                                <td>Função</td>
                                ');
    for ($contaTitulo = 1; $contaTitulo <= $diasDoMes; $contaTitulo++) {
        $mpdf->WriteHTML('<td colspan="1" align="center">' . $contaTitulo . '</td>');
    }
    $mpdf->WriteHTML('
                            </tr>
                        </thead>
                        <tbody>');
    if ($row_cnt > 0) {
        while ($consulta_result = mysqli_fetch_assoc($result)) {

            //query que seleciona o motorista que possui o cpf selecionado
            $queryMoto = 'SELECT * FROM `motoristas` WHERE cpf = "' . $consulta_result['cpf'] . '" LIMIT 10';
            $resultMoto = mysqli_query($conn, $queryMoto);
            $consultaMoto = mysqli_fetch_assoc($resultMoto);
            //Fim

            $mpdf->WriteHTML('
                                    <tr id="' . $consulta_result['id'] . '">
                                        <td class="th-sm align-middle text-size-view">' . $consulta_result['nome'] . '
                                        </td>');
            if ($consulta_result['funcao'] == 80348 || $consulta_result['funcao'] == 84534) {
                $mpdf->WriteHTML('<td class="th-sm text-center align-middle">Condutor</td>');
            } else if ($consulta_result['funcao'] == 80347) {
                $mpdf->WriteHTML('<td class="th-sm text-center align-middle">Ajudante</td>');
            }
            //conta todos os dias do mês e joga na tabela
            for ($contaDias = 1; $contaDias <= $diasDoMes; $contaDias++) {

                //Turnos
                $turnosManha = "613578,613674,613576,545859,545852,573554";
                $turnosNoite = "544309,613669,613574,573552";

                //Status do Colaborador
                $statusDisp = "1,2,3,7";
                $statusFolga = "5,6";

                //Transforma o dia contado em uma data para checar se existe uma dobra
                $data_reformada = date('Y-m-d', strtotime('' . $anoAtual . '-' . $mesAtual . '-' . $contaDias . ''));

                //query que seleciona as dobras cadastradas para o cpf selecionado
                $queryDobras = 'SELECT * FROM `dobras` WHERE cpf = "' . $consulta_result['cpf'] . '" AND data = "' . $data_reformada . '" LIMIT 1';
                $resultDobras = mysqli_query($conn, $queryDobras);
                $consultaDobras = mysqli_fetch_assoc($resultDobras);
                //Fim

                //query que seleciona a substituição do motorista que possui o cpf selecionado
                $querySubs = 'SELECT * FROM `substituicao` WHERE cpf_substituto = "' . $consulta_result['cpf'] . '" AND dia_da_falta = "' . $data_reformada . '" LIMIT 1';
                $resultSubs = mysqli_query($conn, $querySubs);
                $consultaSubs = mysqli_fetch_assoc($resultSubs);
                //Fim

                //query que seleciona a substituição do motorista que possui o cpf selecionado
                $querySubs2 = 'SELECT * FROM `substituicao` WHERE cpf_substituido = "' . $consulta_result['cpf'] . '" AND dia_da_falta = "' . $data_reformada . '" LIMIT 1';
                $resultSubs2 = mysqli_query($conn, $querySubs2);
                $consultaSubs2 = mysqli_fetch_assoc($resultSubs2);
                //Fim

                //query que seleciona a substituição do motorista que possui o cpf selecionado
                $queryFerias = 'SELECT * FROM `ferias` WHERE cpf = "' . $consulta_result['cpf'] . '" AND "' . $data_reformada . '" BETWEEN inicio_ferias and fim_ferias LIMIT 1';
                $resultFerias = mysqli_query($conn, $queryFerias);
                $row_cntFerias = $resultFerias->num_rows;
                //Fim

                //query que seleciona a substituição do motorista que possui o cpf selecionado
                $queryFerias2 = 'SELECT * FROM `ferias` WHERE substituto = "' . $consulta_result['id'] . '" AND "' . $data_reformada . '" BETWEEN inicio_ferias and fim_ferias LIMIT 1';
                $resultFerias2 = mysqli_query($conn, $queryFerias2);
                $row_cntFerias2 = $resultFerias2->num_rows;
                $consultaFerias2 = mysqli_fetch_assoc($resultFerias2);
                //Fim

                $turno = $consulta_result['tipo_jornada'];
                $ponto = $consulta_result['status_ultimo_ponto'];
                $cpf = $consulta_result['cpf'];

                if (date('d') % 2 == 0) {
                    if (preg_match("($ponto)", $statusDisp) === 1) {
                        $dia_work = "IMPAR";
                    } else {
                        $dia_work = "PAR";
                    }
                } else if (date('d') % 2 !== 0) {
                    if (preg_match("($ponto)", $statusDisp) === 1) {
                        $dia_work = "PAR";
                    } else {
                        $dia_work = "IMPAR";
                    }
                }

                //Grava o cpf e data do dia da Falta
                if (isset($consultaSubs2['cpf_substituido']) && isset($consultaSubs2['dia_da_falta'])) {
                    $cpf_sub = $consultaSubs2['cpf_substituido'];
                    $dia_falta = $consultaSubs2['dia_da_falta'];
                    $turno_falta = $consultaSubs2['turno_substituido'];
                } else {
                    $cpf_sub = "";
                    $dia_falta = "";
                    $turno_falta = "";
                }

                //Grava o cpf e data do dia da substituição
                if (isset($consultaSubs['cpf_substituto']) && isset($consultaSubs['dia_da_falta'])) {
                    $cpf_sub2 = $consultaSubs['cpf_substituto'];
                    $dia_falta2 = $consultaSubs['dia_da_falta'];
                    $turno_falta2 = $consultaSubs['turno_substituido'];
                } else {
                    $cpf_sub2 = "";
                    $dia_falta2 = "";
                    $turno_falta = "";
                }

                //Grava o cpf e data do dia da Dobra
                if (isset($consultaDobras['cpf']) && isset($consultaDobras['data'])) {
                    $cpf_dobra = $consultaDobras['cpf'];
                    $dia_dobra = $consultaDobras['data'];
                    $turno_dobra = $consultaDobras['turno_dobrado'];
                } else {
                    $cpf_dobra = "";
                    $dia_dobra = "";
                    $turno_dobra = "";
                }

                //Grava o turno do substituido
                if ($row_cntFerias2 > 0) {
                    $turno_subFerias = $consultaFerias2['turno'];
                } else {
                    $turno_subFerias = "";
                }

                if ($diasDoMesAnterior % 2 !== 0 && $diasDoMes % 2 == 0 || $diasDoMesAnterior % 2 == 0 && $diasDoMes % 2 !== 0) {
                    //Se o dia contado for divisível por 2, ele aplica a regra par
                    if ($contaDias % 2 == 0) {
                        $mpdf->WriteHTML('
                                        <td class="p-0">
                                            <table class="w-100">
                                                <tr>');

                        //Turnos dia Par

                        //Preenche Esquerda
                        if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosManha) === 1 || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosManha) === 1 && $dia_work == "PAR") {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosManha) === 1 && $dia_work == "IMPAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        //Preenche Direita
                        if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosNoite) === 1 || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosNoite) === 1 && $dia_work == "PAR") {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosNoite) === 1 && $dia_work == "IMPAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        $mpdf->WriteHTML('</tr>
                                            </table>
                                        </td>');
                    } else {
                        $mpdf->WriteHTML('
                                        <td class="p-0">
                                            <table class="w-100">
                                            <tr>');

                        //Turnos dia Impar

                        //Preenche Esquerda
                        if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosManha) === 1 || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosManha) === 1 && $dia_work == "IMPAR") {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosManha) === 1 && $dia_work == "PAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        //Preenche Direita
                        if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosNoite) === 1 || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosNoite) === 1 && $dia_work == "IMPAR") {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosNoite) === 1 && $dia_work == "PAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        $mpdf->WriteHTML('</tr>
                                            </table>
                                        </td>');
                    }
                } else { //Se o dia contado for divisível por 2, ele aplica a regra par
                    if ($contaDias % 2 == 0) {
                        $mpdf->WriteHTML('
                                        <td class="p-0">
                                            <table class="w-100">
                                                <tr>');

                        //Turnos dia Par

                        //Preenche Esquerda
                        if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosManha) === 1 || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosManha) === 1 && $dia_work == "PAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        //Preenche Direita
                        if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosNoite) === 1 || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosNoite) === 1 && $dia_work == "PAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        $mpdf->WriteHTML('</tr>
                                            </table>
                                        </td>');
                    } else {
                        $mpdf->WriteHTML('
                                        <td class="p-0">
                                            <table class="w-100">
                                            <tr>');

                        //Turnos dia Impar

                        //Preenche Esquerda
                        if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosManha) === 1 || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosManha) === 1 && $dia_work == "IMPAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        //Preenche Direita
                        if ($cpf == $cpf_sub && $data_reformada == $dia_falta && preg_match("($turno)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="secondary-color-dark float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_dobra && $data_reformada == $dia_dobra && preg_match("($turno_dobra)", $turnosNoite) === 1) {
                            $mpdf->WriteHTML('<td class="info-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($cpf == $cpf_sub2 && $data_reformada == $dia_falta2 && preg_match("($turno_falta2)", $turnosNoite) === 1  || $row_cntFerias2 > 0 && preg_match("($turno_subFerias)", $turnosManha) === 1) {
                            $mpdf->WriteHTML('<td class="warning-color float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if ($row_cntFerias > 0) {
                            $mpdf->WriteHTML('<td class="rgba-stylish-strong float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else if (preg_match("($turno)", $turnosNoite) === 1 && $dia_work == "IMPAR") {
                            $mpdf->WriteHTML('<td class="green float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        } else {
                            $mpdf->WriteHTML('<td class="red float-left w-50 text-center row_sizing align-middle text-white font-weight-bold">12hr</td>');
                        }

                        $mpdf->WriteHTML('</tr> 
                                            </table>
                                        </td>');
                    }
                }
            }
            $mpdf->WriteHTML('
                        </tr>
                        ');
        }
    }

    $mpdf->WriteHTML('
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </body>
    ');
    $mpdf->Output('Relatório.pdf', 'i');
} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception 
    //       name used for catch
    // Process the exception, log, print etc.
    echo $e->getMessage();
}
