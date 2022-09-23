<?php include("./includes/head.php"); ?>
<?php include_once("./includes/navbar.php") ?>
<script src="./js/login.js"></script>

<body class="grey lighten-3">
    <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
            <div class="row wow fadeIn">
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card mt-3">
                        <div class="">
                            <i class="fas fa-users fa-lg primary-color z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                            <div class="float-right text-right p-3">
                                <p class="text-uppercase text-muted mb-1"><small>Funcionários</small></p>
                                <h4 class="font-weight-bold mb-0" id="totalFunc">0</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card mt-3">
                        <div class="">
                            <i class="fas fa-car fa-lg teal z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                            <div class="float-right text-right p-3">
                                <p class="text-uppercase text-muted mb-1"><small>Veículos</small></p>
                                <h4 class="font-weight-bold mb-0" id="totalCar">0</h4>
                            </div>
                        </div>
                        <!-- <div class="card-body pt-0">
                            <div class="progress md-progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 46%" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="card-text">Hoje (19/11/2020), às 15h00 (46%)</p>
                        </div> -->
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card mt-3">
                        <div class="">
                            <i class="fas fa-gas-pump fa-lg purple z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                            <div class="float-right text-right p-3">
                                <p class="text-uppercase text-muted mb-1"><small>Abastecimentos</small></p>
                                <h4 class="font-weight-bold mb-0" id="totalAbs">0</h4>
                            </div>
                        </div>
                        <!-- <div class="card-body pt-0">
                            <div class="progress md-progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="card-text">Quantidade de litros (31%)</p>
                        </div> -->
                    </div>
                </div>
            </div>
            <?php
            if ($_SESSION['acesso'] == 1) {
                echo '<div class="col-lg-4 col-md-12 mb-4 mx-auto">
                    <div class="card mt-3">
                        <div class="">
                            <i class="fas fa-users fa-lg primary-color z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                            <div class="float-right text-right p-3">
                                <p class="text-uppercase text-muted mb-1"><small>Cliente</small></p>
                                <h4 class="font-weight-bold mb-0" id="totalCli">0</h4>
                            </div>
                        </div>
                    </div>
                </div>';
            } ?>

            <div class="row wow fadeIn">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card mt-3">
                        <div class="" onclick="modalGasolina()">
                            <i class="fas fa-tint fa-lg danger-color-dark  z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                            <div class="float-right text-right p-3">
                                <p class="text-uppercase text-muted mb-1"><small>Gasolina</small></p>
                                <div class="row">
                                    <p class="text-muted mb-1 mr-3"><small>Faltam</small></p>
                                    <h4 class="font-weight-bold mb-0 mr-2" id="totalGasolina">0 Litros</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="progress md-progress">
                                <div id="prGas" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="card-text" id="pGas"></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card mt-3">
                        <div class="" onclick="modalEtanol()">
                            <i class="fas fa-tint fa-lg success-color z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                            <div class="float-right text-right p-3">
                                <p class="text-uppercase text-muted mb-1"><small>Etanol</small></p>
                                <div class="row">
                                    <p class="text-muted mb-1 mr-3"><small>Faltam</small></p>
                                    <h4 class="font-weight-bold mb-0 mr-2" id="totalEtanol">0 Litros</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="progress md-progress">
                                <div id="prEtanol" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="card-text" id="pEtanol"></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card mt-3">
                        <div class="" onclick="modalDiesel()">
                            <i class="fas fa-tint fa-lg stylish-color-dark z-depth-2 p-4 ml-3 mt-n3 rounded text-white"></i>
                            <div class="float-right text-right p-3">
                                <p class="text-uppercase text-muted mb-1"><small>Diesel</small></p>
                                <div class="row">
                                    <p class="text-muted mb-1 mr-3"><small>Faltam</small></p>
                                    <h4 class="font-weight-bold mb-0 mr-2" id="totalDiesel">0 Litros</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="progress md-progress">
                                <div id="prDies" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="card-text" id="pDies"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row wow fadeIn">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">Ultimos Abastecimentos</div>
                            <table class="table table-hover table-sm" id="Abstable" cellspacing="0" width="100%">
                                <thead class="blue-grey lighten-4">
                                    <tr>
                                        <th class="th-sm text-center align-middle">Prefixo</th>
                                        <th class="th-sm text-center align-middle">Placa</th>
                                        <th class="th-sm text-center align-middle">Motorista</th>
                                        <th class="th-sm text-center align-middle">Tipo Comb.</th>
                                        <th class="th-sm text-center align-middle">Litros</th>
                                        <th class="th-sm text-center align-middle">Data-Hora</th>
                                    </tr>
                                </thead>
                                <tbody id="cadastroVeiculostable"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row wow fadeIn">
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">Consumo de Combutível - Totalidade de cada dia</div>
                        <div class="card-body">
                            <div class="chart-container" id="linechartcss">
                                <canvas id="linechart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">Consumo de CombutíveL - Tipo de Combustível</div>
                        <div class="card-body">
                            <canvas id="barchart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row wow fadeIn">
                <div class="col-md-6 mb-4">
                    <!-- <div class="card">
                        <-- Card header -->
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <section>
                    <!-- Modal Controle de GASOLINA -->
                    <div class="modal fade" id="modalGasolina" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-notify modal-xl modal-danger" role="document">
                            <div class="modal-content">
                                <div class="modal-header p-2">
                                    <p class="heading p-2 lead">Quantidade de Gasolina</p>
                                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="white-text">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <i class="fas fa-gas-pump fa-4x mb-5"></i>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="EditarQuantGasolina">Quantidade disponível</label>
                                                <input type="number" id="EditarQuantGasolina" class="form-control" placeholder="Digite a quantidade disponível." min=1>
                                                <small id="gasolinaHelpCad" class="text-danger"></small><br>
                                                <label for="EditarNotaG" class="mt-2">Nº da Nota Fiscal</label>
                                                <input type="text" id="EditarNotaG" class="form-control" placeholder="Digite o número da nota.">
                                                <label for="EditarValorG" class="mt-2">Valor Total (R$)</label>
                                                <input type="text" id="EditarValorG" class="form-control" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-12 p-2">
                                            <label>Assinatura do responsável</label>
                                            <div id="imagemModalGas" class="text-center z-depth-1 rounded-sm">
                                                <img id="loadedImageGas" src="" alt="assinatura" class="img-fluid">
                                            </div>
                                            <div id="canvasModalGas">
                                                <div class="text-center z-depth-1 rounded-sm">
                                                    <div class="js-signature" id="assinaturaGas" onclick="signatureStart()"></div>
                                                </div>
                                            </div>
                                            <div class="text-center mt-2">
                                                <a class="btn btn-sm btn-warning" id="btnGasClean" onclick="clearCanvas()">Limpar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <a type="button" class="btn btn-success waves-effect" id="btnGasSave">Salvar</a>
                                    <a role="button" class="btn btn-danger waves-effect" data-dismiss="modal">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Controle de ETANOL -->
                    <div class="modal fade" id="modalEtanol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-notify modal-xl modal-success" role="document">
                            <div class="modal-content">
                                <div class="modal-header p-2">
                                    <p class="heading p-2 lead">Quantidade de Etanol</p>
                                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="white-text">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <i class="fas fa-gas-pump fa-4x mb-5"></i>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="EditarQuantEtanol">Quantidade disponível</label>
                                                <input type="number" id="EditarQuantEtanol" class="form-control" placeholder="Digite a quantidade disponível." min=1>
                                                <small id="etanolHelpCad" class="text-danger"></small><br>
                                                <label for="EditarNotaE" class="mt-2">Nº da Nota Fiscal</label>
                                                <input type="text" id="EditarNotaE" class="form-control" placeholder="Digite o número da nota.">
                                                <label for="EditarValorE" class="mt-2">Valor Total (R$)</label>
                                                <input type="text" id="EditarValorE" class="form-control" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-12 p-2">
                                            <label>Assinatura do responsável</label>
                                            <div id="imagemModalEta" class="text-center z-depth-1 rounded-sm">
                                                <img id="loadedImageEta" src="" alt="assinatura" class="img-fluid">
                                            </div>
                                            <div id="canvasModalEta">
                                                <div class="text-center z-depth-1 rounded-sm">
                                                    <div class="js-signature" id="assinaturaEta" onclick="signatureStart()"></div>
                                                </div>
                                            </div>
                                            <div class="text-center mt-2">
                                                <a class="btn btn-sm btn-warning" id="btnEtaClean" onclick="clearCanvas()">Limpar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <a type="button" class="btn btn-success waves-effect" id="btnEtaSave">Salvar</a>
                                    <a role="button" class="btn btn-danger waves-effect" data-dismiss="modal">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Controle de DIESEL -->
                    <div class="modal fade" id="modalDiesel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-notify modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header DarkGreyBGColor p-2">
                                    <p class="heading p-2 lead">Quantidade de Diesel</p>
                                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="white-text">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <i class="fas fa-gas-pump DarkGreyColor fa-4x mb-5"></i>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="EditarQuantDiesel">Quantidade disponível</label>
                                                <input type="number" id="EditarQuantDiesel" class="form-control" placeholder="Digite a quantidade disponível." min=1>
                                                <small id="dieselHelpCad" class="text-danger"></small><br>
                                                <label for="EditarNotaD" class="mt-2">Nº da Nota Fiscal</label>
                                                <input type="text" id="EditarNotaD" class="form-control" placeholder="Digite o número da nota.">
                                                <label for="EditarValorD" class="mt-2">Valor Total (R$)</label>
                                                <input type="text" id="EditarValorD" class="form-control" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-12 p-2">
                                            <label>Assinatura do responsável</label>
                                            <div id="imagemModalDie" class="text-center z-depth-1 rounded-sm">
                                                <img id="loadedImageDie" src="" alt="assinatura" class="img-fluid">
                                            </div>
                                            <div id="canvasModalDie">
                                                <div class="text-center z-depth-1 rounded-sm">
                                                    <div class="js-signature" id="assinaturaDie" onclick="signatureStart()"></div>
                                                </div>
                                            </div>
                                            <div class="text-center mt-2">
                                                <a class="btn btn-sm btn-warning" id="btnDieClean" onclick="clearCanvas()">Limpar</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <a type="button" class="btn btn-success waves-effect" id="btnDieSave">Salvar</a>
                                    <a role="button" class="btn btn-danger waves-effect" data-dismiss="modal">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Abastecimento -->
                    <div class="modal fade" id="viewInfoAbs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-notify modal-primary" role="document">
                            <div class="modal-content">
                                <div class="modal-header p-2">
                                    <p class="heading p-2 lead">Informações sobre Abastecimento</p>
                                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="white-text">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="infoFrentista">Frentista</label>
                                            <input type="text" id="infoFrentista" class="form-control" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="infoVeiculo">Veículo</label>
                                            <input type="text" id="infoVeiculo" class="form-control" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="infoMotorista">Motorista</label>
                                            <input type="text" id="infoMotorista" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="infoLitros">Litros</label>
                                            <input type="number" id="infoLitros" class="form-control" disabled>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="infoTipoComb">Tipo de Combustível</label>
                                            <input type="text" id="infoTipoComb" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="infoDtAbs">Data do abastecimento</label>
                                            <input type="text" id="infoDtAbs" class="form-control" disabled>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="infoHrAbs">Hora do abastecimento</label>
                                            <input type="text" id="infoHrAbs" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="form-group col-md-6">
                                            <label for="infoVal">Valor Total (R$)</label>
                                            <input type="text" id="infoVal" class="form-control" maxlength="40" disabled>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="infoNF">Nota</label>
                                            <input type="text" id="infoNF" class="form-control" maxlength="40" disabled>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center" id="imgs"></div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <a type="button" class="btn btn-danger btn-sm waves-effect" data-dismiss="modal">Fechar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Criado com sucesso -->
                    <div class="modal fade" id="EditadoComSucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-sm modal-dialog modal-notify modal-success" role="document">
                            <div class="modal-content">
                                <div class="modal-header p-2">
                                    <p class="heading p-2 lead">Salvo!</p>
                                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="white-text">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                                        <p>Edição das informações e assinatura foram salvas!</p>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Ok</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>

</html>

<?php include("./includes/imports.php") ?>
<script src="./node_modules/jq-signature/jq-signature.min.js"></script>
<script src="./js/menu.js"></script>