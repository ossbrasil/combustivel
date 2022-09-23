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

if (date('d') % 2 == 0) {
    if ($_GET['dia'] == 2) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (1,3,7) AND `ferias` = 0 AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else if ($_GET['dia'] == 1) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5) AND `ferias` = 0 AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5,1,3,7) AND `ferias` = 0 AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    }
} else {
    if ($_GET['dia'] == 1) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (1,3,7) AND `ferias` = 0 AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else if ($_GET['dia'] == 2) {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5) AND `ferias` = 0 AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    } else {
        $query = 'SELECT * FROM `motoristas` WHERE tipo_jornada IN ( ' . $_GET['jornada'] . ' ) AND polo IN ( ' . $_GET['polo'] . ' ) AND status_ultimo_ponto IN (6,5,1,3,7) AND `ferias` = 0 AND status_ultimo_ponto = ' . $_GET['tipoJornada'] . '';
    }
}

//Query do Banco
$result = mysqli_query($conn, $query);
$row_cnt = $result->num_rows;
//Fim

$mpdf = new \Mpdf\Mpdf([
    'default_font' => 'arial'
]);

$dia = 0;

if($_GET['dia'] == 1){
    $dia = '(Impar)';
}  else if ($_GET['dia'] == 2) {
    $dia = '(Par)';
}else{
    $dia = '(Ambos)';
}

$tipo_jornada = '';

if ($_GET['jornada'] == '613578,613674') {
    $tipo_jornada = 'Turno 12 x 36 - 06:00 as 18:00';
} else if ($_GET['jornada'] == 544309 || $consulta_result['tipo_jornada'] == 613669) {
    $tipo_jornada ='Turno 12 x 36 - 18:00 as 06:00';
} else if ($_GET['jornada'] == 613574) {
    $tipo_jornada ='Turno 12x 36 - 07:00 as 19:00';
} else if ($_GET['jornada'] == 613576) {
    $tipo_jornada ='Turno 12x36 - 19:00 as 07:00';
} else if ($_GET['jornada'] == 573554) {
    $tipo_jornada ='Turno 12x36 - 04:00 as 16:00';
} else if ($_GET['jornada'] == 573552) {
    $tipo_jornada ='Turno 12x36 - 16:00 as 04:00';
} else {
    $tipo_jornada ='Não Consta';
}

// Opções e preferências do PDF
$mpdf->SetTitle('Relatório de motoristas');
$mpdf->SetHeader(''.$tipo_jornada.'|FVB painel|Referente a data {DATE d/m/Y}');
$mpdf->SetFooter(''.$tipo_jornada.'|{PAGENO}|FVB painel');

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
                    <h1>Relatório de Motoristas'.$dia.'');
                $mpdf->WriteHTML('</h1>
                </div>
                <div>
                    <table id="carrega-infos">
                        <thead>
                            <tr>
                                <td>Motoristas</td>
                                <td>Função</td>
                                <td>Polo</td>
                                <td>Jornada</td>
                            </tr>
                        </thead>
                        <tbody>');
                if ($row_cnt > 0) {
                    while ($consulta_result = mysqli_fetch_assoc($result)) {
                        $mpdf->WriteHTML('
                        <tr>
                            <td>' . $consulta_result['nome'] . '</td>');
                        if ($consulta_result['funcao'] == 80348 || $consulta_result['funcao'] == 84534) {
                            $mpdf->WriteHTML(' <td>Condutor</td>');
                        } else {
                            $mpdf->WriteHTML(' <td>Ajudante</td>');
                        }

                        if ($consulta_result['polo'] == 75992 || $consulta_result['polo'] == 70404) {
                            $mpdf->WriteHTML(' <td>Vila Guilherme</td>');
                        } else {
                            $mpdf->WriteHTML(' <td>Vila Mariana</td>');
                        }

                        if ($consulta_result['status_ultimo_ponto'] == 1) {
                            $mpdf->WriteHTML('<td>Em jornada</td>');
                        } else if ($consulta_result['status_ultimo_ponto'] == 2) {
                            $mpdf->WriteHTML('<td>Intervalo</td>');
                        } else if ($consulta_result['status_ultimo_ponto'] == 3) {
                            $mpdf->WriteHTML('<td>Ausente</td>');
                        } else if ($consulta_result['status_ultimo_ponto'] == 4) {
                            $mpdf->WriteHTML('<td>Em jornada extra</td>');
                        } else if ($consulta_result['status_ultimo_ponto'] == 5) {
                            $mpdf->WriteHTML('<td>Expedente encerrado</td>');
                        } else if ($consulta_result['status_ultimo_ponto'] == 6) {
                            $mpdf->WriteHTML('<td>De folga</td>');
                        } else if ($consulta_result['status_ultimo_ponto'] == 7) {
                            $mpdf->WriteHTML('<td>Atrasado</td>');
                        } else if ($consulta_result['status_ultimo_ponto'] == 8) {
                            $mpdf->WriteHTML('<td>Trabalhando em dia de folga</td>');
                        } else {
                            $mpdf->WriteHTML('<td>Não consta</td>');
                        }

                        $mpdf->WriteHTML('
                            </tr>
                            ');
                    }
                } else {
                    $mpdf->WriteHTML('
                        <tr>
                        <td colspan="4">Nehum registro encontrado</td>
                        </tr>');
                }
                $mpdf->WriteHTML('
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </body>
    ');

$mpdf->Output('Relatório de Menu.pdf', 'i');
