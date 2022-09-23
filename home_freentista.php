<?php include("./includes/head.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>App-Frentista</title>

</head>

<body class='w-auto h-auto p-8'>
    <section id="menu">
        <div class="container-fluid mt-5 mb-1">
            <div class="row align-items-center justify-content-center mt-5 mb-5">
                <div class="col-6 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                    <img src="./imagens/logo.png" alt="Logo FVB" class="w-100 my-4">
                </div>
            </div>
            <div class="row align-items-center justify-content-center mt-5">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3  align-self-center ">
                    <button class="btn btn-login btn-block  btn-dark-green my-2 " onclick="checkAbs()" type="submit">Check-in Abastecimento</button>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                    <button class="btn btn-login btn-block  btn-dark-green my-2" onclick="listarAbs()" type="submit">Listar Abastecimentos</button>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                    <button class="btn btn-login btn-block  btn-dark-green my-2" type="submit" onclick="location.replace('login.php');">Sair da Conta</button>
                </div>
            </div>
        </div>
    </section>
    <section>

        <div id="dadosCheck" class="container-fluid mt-0 animated fadeIn d-none">
            <!-- <div class="row justify-content-center mt-2 mb-5">
                <div class="col-6 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                    <img src="./imagens/logo.png" alt="Logo FVB" class="w-100 my-4">
                </div>
            </div> -->
            <div class="row justify-content-center mt-4 mb-3">

                <div class="item">
                    <div class="circle-color blue text-center mr-1 text-white" id='cir1'>1</div>
                </div>
                <div class="item">
                    <div class="circle-color bg-light text-center mr-1 text-white" id='cir2'>2</div>
                </div>
                <div class="item">
                    <div class="circle-color bg-light text-center mr-1 text-white" id='cir3'>3</div>
                </div>
                <div class="item">
                    <div class="circle-color bg-light text-center mr-1 text-white" id='cir4'>4</div>
                </div>
                <div class="item">
                    <div class="circle-color bg-light text-center mr-1 text-white" id='cir5'>5</div>
                </div>
            </div>

            <div class="row align-items-center justify-content-center mt-2">
                <div class="col">

                    <p id='textHead'> </p>
                    <div class="w-100 align-self-center mt-2 animated fadeIn" id='divCam'>


                        <h5 class="text-center font-weight-bold" id='textQR'></h5>
                        <h6 class="text-center font-weight-light" id='textBody'></h6>


                        <div class="mt-1 embed-responsive embed-responsive-4by3">
                            <video class="embed-responsive-item" id="cam"></video>
                            <video class="embed-responsive-item" id="cam2"></video>
                            <video class="embed-responsive-item" id="cam3"></video>
                        </div>
                        <div class='row justify-content-center mt-2 d-none' id="btnSnap">
                            <a type="submit" class="btn btn-success p-2" onclick="confirmSnap()">Tirar Foto </a>
                            
                        </div>
                        <div class='row justify-content-center mt-2 '>
                            <a type="button" class="btn btn-danger waves-effect p-2" data-dismiss="modal" onclick="resetModal()">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>


            <div id="carSelect" class='d-none'>
                <h5 class="card-title text-center font-weight-bold mt-1">Informe o Abastecimento</h5>
                <h6 class="text-center font-weight-light">Veículo</h6>

                <div class="row justify-content-center mt-2 ">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                        <div class="card-group ">
                            <div class="card">

                                <!-- <img class="card-img-top"  src="imagens/car-preto.png" alt="Card image cap"> -->
                                <div class="card-body">
                                    <i class="fas fa-car prefix text-dark p-1 d-inline"></i>
                                    <h5 class="card-title d-inline" id='placa'></h5>
                                    <p class="card-text" id='texto'></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="text-center font-weight-light">Abastecimento</h6>

                <div class="row justify-content-center mt-2">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">

                        <div class="card text-center">
                            <!-- <img class="card-img-top"  src="imagens/car-preto.png" alt="Card image cap"> -->
                            <div class="card-body">
                                <div class="text-left">
                                    <i class="fas fa-gas-pump prefix text-dark mr-2 ml-2"></i>
                                    <label id="labelComb">Combustível</label>
                                </div>
                                <select id="cadastrarComb" class="browser-default custom-select text-left">

                                    <option value="0" selected disabled>Selecione o tipo</option>
                                    <option value="1">Gasolina</option>
                                    <option value="2">Etanol</option>
                                    <option value="3" select disabled>Diesel</option>
                                </select>
                                <small id="combHelpCad" class="text-danger"></small>

                                <div class="text-left mt-2">
                                    <i class="fas fa-gas-pump prefix text-dark mr-2 ml-2"></i>
                                    <label for="cadastrarLitros">Litros</label>
                                </div>
                                <input type="number" id="cadastrarLitros" class="form-control" placeholder="Litros">
                                <small id="ltHelpCad" class="text-danger"></small>
                                <div class="text-left mt-2">
                                    <i class="fas fa-gas-pump prefix text-dark mr-2 ml-2"></i>
                                    <label for="cadastrarKM">KM</label>
                                </div>
                                <input type="number" id="cadastrarKM" class="form-control" placeholder="00.000">
                                <small id="kmHelpCad" class="text-danger"></small>
                                <div class="text-left mt-2">

                                    <i class="fas fa-dollar-sign prefix text-dark mr-2 ml-2"></i>
                                    <label for="cadastrarVal">Valor (R$)</label>
                                </div>
                                <input type="number" id="cadastrarVal" class="form-control" placeholder="0.00">
                                <small id="valHelpCad" class="text-danger"></small>
                                <div class="text-left mt-2">

                                    <i class="fas fa-file-invoice-dollar text-dark mr-2 ml-2"></i>
                                    <label for="cadastrarNota">Nota Fiscal</label>
                                </div>
                                <input type="number" id="cadastrarNota" class="form-control" placeholder="Nº da Nota">
                                <small id="valHelpCad" class="text-danger"></small>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row justify-content-center mt-2" id="qrCheck">
                    <div class=" text-center" id="qrcode">
                        <a type="submit" class="btn btn-success p-2" id="btnAddOs" onclick="confirmCar()">Prosseguir </a>
                        <a type="button" class="btn btn-danger waves-effect p-2" data-dismiss="modal" onclick="resetModal()">Cancelar</a>
                    </div>
                </div>
            </div>

            <div id="motSelect" class='d-none'>
                <h5 class="card-title text-center mt-2">Dados do Motorista</h5>
                <div class="row justify-content-center mt-3 ">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                        <div class="card-group ">
                            <div class="card">

                                <!-- <img class="card-img-top"  src="imagens/car-preto.png" alt="Card image cap"> -->
                                <div class="card-body">
                                    <i class="fas fa-car prefix text-dark p-1 d-inline"></i>
                                    <h5 class="card-title d-inline" id='motNome'></h5>
                                    <p class="card-text" id='texto'></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-2" id="qrConfirm">
                    <div class=" text-center" id="qrcode">
                        <a type="submit" class="btn btn-success p-2" id="btnAddOs" onclick="confirmAbs()">Confirmar</a>
                        <a type="button" class="btn btn-danger waves-effect p-2" data-dismiss="modal" onclick="resetModal()">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section id='listarAbs' class='d-none'>
        <div class="row justify-content-center">
            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                <img src="./imagens/logo.png" alt="Logo FVB" class="w-100 my-4">
            </div>
        </div>
        <div class="row wow fadeIn justify-content-center">

            <!--Grid column-->
            <div class="col-md-6 col-sm-4 mt-4 mb-4">

                <!--Card-->
                <div class="card">
                    <!--Card content-->
                    <div class="card-body">
                        <div class="card-header">Ultimos Abastecimentos</div>
                        <!-- Table  -->
                        <table class="table table-hover table-sm" id="Abstable" cellspacing="0" width="100%">
                            <!-- Table head -->
                            <thead class="blue-grey lighten-4">
                                <tr>
                                    <th class='th-sm text-center align-middle'>Carro</th>
                                    <th class='th-sm text-center align-middle'>Tipo Comb.</th>
                                    <th class='th-sm text-center align-middle'>Litros</th>
                                    <th class='th-sm text-center align-middle'>Hora</th>
                                </tr>
                            </thead>
                            <!-- Table head -->

                            <!-- Table body -->
                            <tbody id='cadastroVeiculostable'>

                            </tbody>
                            <!-- Table body -->
                        </table>
                        <!-- Table  -->

                    </div>

                </div>
                <!--/.Card-->

            </div>


        </div>
        <div class="row wow fadeIn justify-content-center">
            <footer class="modal-footer justify-content-end mx-auto center ">
                <a type="button" class="btn btn-danger waves-effect p-2" data-dismiss="modal" onclick="resetModal()">Voltar</a>
            </footer>
        </div>
    </section>
</body>


<div class="modal fade" id="criadoComSucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-sm modal-dialog modal-notify modal-success" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header p-2">
                <p class="heading p-2 lead">Criado com sucesso</p>

                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                    <p>Abastecimento registrado com sucesso</p>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <a type="button" class="btn btn-outline-success waves-effect" onclick="resetModal()" data-dismiss="modal">Ok</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

<!-- Modal de alerta -->
<div class="modal fade" id="modalAlerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-sm modal-dialog modal-notify modal-warning" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header p-2">
                <p class="heading p-2 lead">Alerta</p>

                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-4x mb-3 animated fadeIn"></i>
                    <p id="menssagemAlerta"></p>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Ok</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<footer class="modal-footer justify-content-end mx-auto center d-none">
    <a type="button" class="btn btn-danger waves-effect p-2" data-dismiss="modal" onclick="resetModal()">Voltar</a>
</footer>



<?php include("./includes/imports.php") ?>

<script src="./js/app_freentista.js"></script>