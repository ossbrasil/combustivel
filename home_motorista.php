<?php include("./includes/head.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>App-Morista</title>

</head>

<body>
    <section id="menu" class='h-100 w-100'>
        <div class="container-fluid align-items-center mt-5">
            
            <div class="row justify-content-center">
                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                    <img src="./imagens/logo.png" alt="Logo FVB" class="w-100 my-4">
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                    <button class="btn btn-login btn-block  btn-dark-green my-2 " onclick="checkAbs()" type="submit">Check-in Abastecimento</button>
                </div>
            </div>
            <div class="row justify-content-center">
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
        <!-- <footer class="modal-footer align-self-end justify-content-center" >
              <small class='text-center'>Aplicativo Web para Controle de Combustível da FVB Locadora LTDA.</small>  
        </footer> -->
    </section>
    <section id="dadosCheck" class='d-none'>
        <div class="container-fluid mt-3 mb-1 animated fadeIn ">
            <div class="row justify-content-center">
                <div class="row col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 align-self-center ">
                    <img src="./imagens/logo.png" alt="Logo FVB" class="w-100 my-4">
                </div>
            </div>
            <div class="row justify-content-center">
                <h5 class="card-title text-center font-weight-bold mt-1">QR-Code gerado</h5>
                <h6 class='text-center font-weight-light'>Informe esse código ao frentista após o abastecimento</h6>

            </div>
            <div class="row justify-content-center mt-3 mb-3 d-none" id="qrCheck">
                <div class=" mt-2 text-center" id="qrcode">
                </div>
            </div>
            <div class="row justify-content-center">
               <small class="text-center">Atenção! Esse QR-Code é válido apenas para um abastecimento.</small>
            </div>
            <footer class="modal-footer justify-content-center">
                <a type="button" class="btn btn-danger waves-effect p-2" data-dismiss="modal" onclick="resetModal()">Voltar</a>
            </footer>
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
                        <div class="card-header text-center font-weight-bold mt-1">Ultimos Abastecimentos</div>
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
    <section id='snap' class='d-none mt-5'>

        <div class="row align-items-center justify-content-center mt-2">
            <div class="col">

                <p id='textHead'> </p>
                <div class="w-100 align-self-center mt-2 animated fadeIn" id='divCam'>


                    <h5 class="text-center font-weight-bold" id='textQR'></h5>
                    <h6 class="text-center font-weight-light" id='textBody'></h6>


                    <div class="mt-1 embed-responsive embed-responsive-4by3">
                        <video class="embed-responsive-item" id="cam3"></video>
                    </div>
                    <div class='row justify-content-center mt-2' id="btnSnap">
                        <a type="submit" class="btn btn-success p-2" onclick="confirmSnap()">Tirar Foto </a>

                    </div>
                    <div class='row justify-content-center mt-2 '>
                        <a type="button" class="btn btn-danger waves-effect p-2" data-dismiss="modal" onclick="resetModal()">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

</body>




<?php include("./includes/imports.php") ?>
<script src="./js/app_motorista.js"></script>