<?php include("./includes/head.php"); ?>

<header class="corrige-fluid">

</header>
<body id="tela-login" style="overflow:hidden;">
 
            <div id="retorno-ajax"></div>
            <section id="formulario-login">
            <div class="row"> 
                <div class="col-10 col-sm-10 col-lg-4 col-xl-4 mx-auto align-self-center"  id="caixa-login">
                    <form>
                    <div class="row justify-content-center" >
                        <img src="./imagens/logo.png" alt="Logo FVB" class='w-50' >
                    </div>
                        <div class="md-form mt-4">
                            <input type="email" id="usuarioForm" class="form-control" name="email" autocomplete="off">
                            <label for="usuarioForm">E-mail</label>
                        </div>
                        <div class="md-form">
                            <input type="password" id="senhaForm" class="form-control" name="senha">
                            <label for="senhaForm">Senha</label>
                        </div>
                        <div class="text-center p-t-45 p-b-4">
                                <!-- <span class="txt1">
                                    Esqueceu
                                </span>
                                <a href="" class="txt2 hov1">
                                     Senha?
                                </a> -->
                        </div>
                            
                        <!-- Sign in button -->
                        <button class="btn btn-login btn-block my-4" type="submit">Entrar</button>
                        <!-- <a href="">Esqueceu sua senha?</a> -->
                    </form>
                </div>
            </div>
         </section>
        
</body>
        <!-- Modal Alterar Senha -->
        <div class="modal fade left" id="ModalAlterarSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header p-2">
                        <p class="heading p-2 font-weight-bold">Senha Expirada!</p>

                        <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <form id="nova-senha">
                                    <div class="md-form">
                                        <input type="password" id="novasenhaForm" class="form-control" name="novasenha">
                                        <label for="usuarioForm">Nova Senha</label>
                                    </div>
                                    <div class="md-form">
                                        <input type="password" id="repitsenhaForm" class="form-control" name="repitasenha">
                                        <label for="senhaForm">Repita a Senha</label>
                                    </div>
                                    <!-- Sign in button -->
                                    <button class="btn btn-dark-green btn-block my-4" type="submit">Alterar</button>
                                    <!-- <a href="">Esqueceu sua senha?</a> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->

        <!-- Modal Usuário e Senha Incorretos -->
        <div class="modal fade left" id="ModalSenhaCoincide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header p-2">
                        <p class="heading p-2 font-weight-bold">Aviso!</p>

                        <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-center"><strong>As senhas não coincidem!</strong></p>
                            </div>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a class="btn btn-warning" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->

        <!-- Modal Usuário e Senha Incorretos -->
        <div class="modal fade left" id="ModalInvalido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header p-2">
                        <p class="heading p-2 font-weight-bold">Aviso!</p>

                        <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-center"><strong>E-mail e/ou Senha inválidos</strong></p>
                            </div>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a class="btn btn-warning" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->

        <!-- Modal Erro na Rede -->
        <div class="modal fade left" id="ModalEmailSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notify modal-warning" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header p-2">
                        <p class="heading p-2 font-weight-bold">Erro!</p>

                        <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>
                    <!--Body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-center"><strong>Favor preencher corretamente todos os campos</strong></p>
                            </div>
                        </div>
                    </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a class="btn btn-warning" data-dismiss="modal">Fechar</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- Fim do Modal -->

 
    <?php include("./includes/imports.php") ?>
    <script src="./js/login.js"></script>


    <?php include("./includes/footer.php") ?>