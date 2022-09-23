<!-- SideNav -->
<?php
header('Content-type: text/html; charset=utf-8; application/json');
?>

<input type="checkbox" id="menu-tgl" />

<nav id="sidenav" class="menu" tabindex="0">
    <label for="menu-tgl" class="menu-btn">
        <div id="nav-icon4">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </label>
    <div class="smartphone-menu-trigger"></div>
    <header class="avatar text-left w-100" onclick="abrirModalSenha()">
        <div>
            <img src="./imagens/profile.png" />
        </div>
        <div class="user_infos">
            <h5><?php echo $_SESSION["usuario"]; ?></h5>
            <small class="text-black-50 font-weight-bold">
                <?php
                $i = $_SESSION["acesso"];
                switch ($i) {
                    case 1:
                        echo "Administrador";
                        break;
                    case 2:
                        echo "Recursos Humanos";
                        break;
                    case 3:
                        echo "Supervisor";
                        break;
                    case 4:
                        echo "Fiscal";
                        break;
                    case 5:
                        echo "Prefeitura";
                        break;
                }
                ?>
            </small>
        </div>
    </header>
    <div class="dropdown-divider"></div>
    <ul>
        <?php if ($_SESSION["acesso"] == 4) { ?>
            <button class="btn red lighten-1 text-white p-2  text-left" type="button" data-toggle="collapse" data-target="#gestaoVeiculos" aria-expanded="false" aria-controls="gestaoVeiculos">
                <span class="icone line-block">
                    <i class="fas fa-car text-white"></i>
                </span>
                GESTÃO DE VEÍCULOS
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="gestaoVeiculos">
                
                <li tabindex="6" onclick="acessPage('gestaoDeOS.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-tasks"></i>
                    </span>
                    <span>GESTÃO DE OS</span>
                </li>

                <li tabindex="6" onclick="acessPage('check-list.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-clipboard-list"></i>
                    </span>
                    <span>CHECK-LIST</span>
                </li>
                <!-- Basic dropdown -->
            </div>
            <li tabindex="6" onclick="acessPage('mapaControleMov.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-car"></i>
                </span>
                <span>CONTROLE DE VEÍCULOS</span>
            </li>
            <li tabindex="0" class="align-text-top" onclick="acessPage('./includes/logout.php')">
                <span class="icone line-block">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span>SAIR</span>
            </li>
        <?php } ?>




        <?php if ($_SESSION["acesso"] == 3) { ?>
            <button class="btn red lighten-1 text-white p-2  text-left" type="button" data-toggle="collapse" data-target="#gestaoDeEscalas" aria-expanded="false" aria-controls="gestaoDeEscalas">
                <span class="icone line-block">
                    <i class="fas fa-calendar-alt text-white"></i>
                </span>
                GESTÃO DE ESCALAS
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="gestaoDeEscalas">
                <li tabindex="1" onclick="acessPage('escalas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-truck"></i>
                    </span>
                    <span>ESCALAS</span>
                </li>
                <li tabindex="2" onclick="acessPage('mapa-de-escalas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-map"></i>
                    </span>
                    <span>MAPA DE ESCALAS</span>
                </li>
                <li tabindex="3" onclick="acessPage('banco-de-horas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-stopwatch"></i>
                    </span>
                    <span>BANCO DE HORAS</span>
                </li>
                <li tabindex="4" onclick="acessPage('faltas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <span>FALTAS</span>
                </li>

                <li tabindex="8" onclick="acessPage('ferias.php')">
                    <span class="icone line-block">
                        <i class="fas fa-plane-departure"></i>
                    </span>
                    <span>FÉRIAS</span>
                </li>

                <li tabindex="5" onclick="acessPage('substituicoes.php')">
                    <span class="icone line-block">
                        <i class="fas fa-exchange-alt"></i>
                    </span>
                    <span>SUBSTITUIÇÕES</span>
                </li>
                <li tabindex="6" onclick="acessPage('plantao_avulso.php')">
                    <span class="icone line-block">
                        <i class="fas fa-calendar-plus"></i>
                    </span>
                    <span>PLANTÃO AVULSO</span>
                </li>
                <!-- Basic dropdown -->
            </div>
            <button class="btn red lighten-1 text-white p-2  text-left" type="button" data-toggle="collapse" data-target="#gestaoVeiculos" aria-expanded="false" aria-controls="gestaoVeiculos">
                <span class="icone line-block">
                    <i class="fas fa-car text-white"></i>
                </span>
                GESTÃO DE VEÍCULOS
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="gestaoVeiculos">
                <li tabindex="6" onclick="acessPage('fornecedores.php')">
                    <span class="icone line-block">
                        <i class="fas fa-tools"></i>
                    </span>
                    <span>FORNECEDORES</span>
                </li>

                <li tabindex="6" onclick="acessPage('veiculos.php')">
                    <span class="icone line-block">
                        <i class="fas fa-car"></i>
                    </span>
                    <span>VEÍCULOS</span>
                </li>

                <li tabindex="6" onclick="acessPage('gestaoDeOS.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-tasks"></i>
                    </span>
                    <span>GESTÃO DE OS</span>
                </li>

                <li tabindex="6" onclick="acessPage('check-list.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-clipboard-list"></i>
                    </span>
                    <span>CHECK-LIST</span>
                </li>
                <!-- Basic dropdown -->
            </div>
            <button class="btn red lighten-1 text-white p-2 text-left" type="button" data-toggle="collapse" data-target="#rastreamento" aria-expanded="false" aria-controls="rastreamento">
                <span class="icone line-block">
                    <i class="fas fa-compass text-white"></i>
                </span>
                RASTREAMENTO
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="rastreamento">
                <li tabindex="6" onclick="acessPage('localizacaoVeiculos.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-map"></i>
                    </span>
                    <span>LOC. VEÍCULOS</span>
                </li>
            </div>
            <div class="collapse red lighten-5 overflow-auto" id="rastreamento">
                <li tabindex="6" onclick="acessPage('roteirizacao.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-map"></i>
                    </span>
                    <span>ROTEIRIZAÇÃO</span>
                </li>
            </div>



       
            <li tabindex="6" onclick="acessPage('mapaControleMov.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-car"></i>
                </span>
                <span>CONTROLE DE VEÍCULOS</span>
            </li>
            <li tabindex="6" onclick="acessPage('anomaliasCmv.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fab fa-autoprefixer"></i>
                </span>
                <span>ANOMALIAS</span>
            </li>
      
          


          




            <li tabindex="0" class="align-text-top" onclick="acessPage('./includes/logout.php')">
                <span class="icone line-block">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span>SAIR</span>
            </li>

        <?php } ?>






        <?php if ($_SESSION["acesso"] == 2) { ?>

            <li tabindex="0" onclick="acessPage('menu.php')">
                <span class="icone line-block">
                    <i class="fas fa-columns"></i>
                </span>
                <span class="font-weight-medium">DASHBOARD</span>
            </li>

            <button class="btn red lighten-1 text-white p-2  text-left" type="button" data-toggle="collapse" data-target="#gestaoDeEscalas" aria-expanded="false" aria-controls="gestaoDeEscalas">
                <span class="icone line-block">
                    <i class="fas fa-calendar-alt text-white"></i>
                </span>
                GESTÃO DE ESCALAS
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="gestaoDeEscalas">
                <li tabindex="1" onclick="acessPage('escalas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-truck"></i>
                    </span>
                    <span>ESCALAS</span>
                </li>
                <li tabindex="2" onclick="acessPage('mapa-de-escalas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-map"></i>
                    </span>
                    <span>MAPA DE ESCALAS</span>
                </li>
                <li tabindex="3" onclick="acessPage('banco-de-horas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-stopwatch"></i>
                    </span>
                    <span>BANCO DE HORAS</span>
                </li>
                <li tabindex="4" onclick="acessPage('faltas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <span>FALTAS</span>
                </li>

                <li tabindex="8" onclick="acessPage('ferias.php')">
                    <span class="icone line-block">
                        <i class="fas fa-plane-departure"></i>
                    </span>
                    <span>FÉRIAS</span>
                </li>

                <li tabindex="5" onclick="acessPage('substituicoes.php')">
                    <span class="icone line-block">
                        <i class="fas fa-exchange-alt"></i>
                    </span>
                    <span>SUBSTITUIÇÕES</span>
                </li>
                <li tabindex="6" onclick="acessPage('plantao_avulso.php')">
                    <span class="icone line-block">
                        <i class="fas fa-calendar-plus"></i>
                    </span>
                    <span>PLANTÃO AVULSO</span>
                </li>
                <!-- Basic dropdown -->
            </div>
          
            <li tabindex="6" onclick="acessPage('motoristas.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-user"></i>
                </span>
                <span>FUNCIONÁRIOS</span>
            </li>
     
            <li tabindex="6" onclick="acessPage('anomaliasCmv.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fab fa-autoprefixer"></i>
                </span>
                <span>ANOMALIAS</span>
            </li>
            <li tabindex="6" onclick="acessPage('rhged.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-address-book"></i>
                </span>
                <span>CONTROLE DE RH</span>
            </li>
            <li tabindex="6" onclick="acessPage('controleDePonto.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-clipboard-check"></i>
                </span>
                <span>CONTROLE DE PONTO</span>
            </li>
            <li tabindex="7" onclick="acessPage('usuarios.php')">
                <span class="icone line-block">
                    <i class="fas fa-location-arrow"></i>
                </span>
                <span>USUÁRIOS</span>
            </li>





            <li tabindex="0" class="align-text-top" onclick="acessPage('./includes/logout.php')">
                <span class="icone line-block">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span>SAIR</span>
            </li>
        <?php } ?>


















        <?php if ($_SESSION["acesso"] == 1) { ?>
            <li tabindex="0" onclick="acessPage('menu.php')">
                <span class="icone line-block">
                    <i class="fas fa-columns"></i>
                </span>
                <span class="font-weight-medium">DASHBOARD</span>
            </li>

            <button class="btn red lighten-1 text-white p-2  text-left" type="button" data-toggle="collapse" data-target="#gestaoDeEscalas" aria-expanded="false" aria-controls="gestaoDeEscalas">
                <span class="icone line-block">
                    <i class="fas fa-calendar-alt text-white"></i>
                </span>
                GESTÃO DE ESCALAS
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="gestaoDeEscalas">
                <li tabindex="1" onclick="acessPage('escalas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-truck"></i>
                    </span>
                    <span>ESCALAS</span>
                </li>
                <li tabindex="2" onclick="acessPage('mapa-de-escalas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-map"></i>
                    </span>
                    <span>MAPA DE ESCALAS</span>
                </li>
                <li tabindex="3" onclick="acessPage('banco-de-horas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-stopwatch"></i>
                    </span>
                    <span>BANCO DE HORAS</span>
                </li>
                <li tabindex="4" onclick="acessPage('faltas.php')">
                    <span class="icone line-block">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <span>FALTAS</span>
                </li>

                <li tabindex="8" onclick="acessPage('ferias.php')">
                    <span class="icone line-block">
                        <i class="fas fa-plane-departure"></i>
                    </span>
                    <span>FÉRIAS</span>
                </li>

                <li tabindex="5" onclick="acessPage('substituicoes.php')">
                    <span class="icone line-block">
                        <i class="fas fa-exchange-alt"></i>
                    </span>
                    <span>SUBSTITUIÇÕES</span>
                </li>
                <li tabindex="6" onclick="acessPage('plantao_avulso.php')">
                    <span class="icone line-block">
                        <i class="fas fa-calendar-plus"></i>
                    </span>
                    <span>PLANTÃO AVULSO</span>
                </li>
                <!-- Basic dropdown -->
            </div>

            <button class="btn red lighten-1 text-white p-2  text-left" type="button" data-toggle="collapse" data-target="#gestaoVeiculos" aria-expanded="false" aria-controls="gestaoVeiculos">
                <span class="icone line-block">
                    <i class="fas fa-car text-white"></i>
                </span>
                GESTÃO DE VEÍCULOS
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="gestaoVeiculos">
                <li tabindex="6" onclick="acessPage('fornecedores.php')">
                    <span class="icone line-block">
                        <i class="fas fa-tools"></i>
                    </span>
                    <span>FORNECEDORES</span>
                </li>

                <li tabindex="6" onclick="acessPage('veiculos.php')">
                    <span class="icone line-block">
                        <i class="fas fa-car"></i>
                    </span>
                    <span>VEÍCULOS</span>
                </li>

                <li tabindex="6" onclick="acessPage('gestaoDeOS.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-tasks"></i>
                    </span>
                    <span>GESTÃO DE OS</span>
                </li>

                <li tabindex="6" onclick="acessPage('check-list.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-clipboard-list"></i>
                    </span>
                    <span>CHECK-LIST</span>
                </li>
                <!-- Basic dropdown -->
            </div>

            <button class="btn red lighten-1 text-white p-2 text-left" type="button" data-toggle="collapse" data-target="#rastreamento" aria-expanded="false" aria-controls="rastreamento">
                <span class="icone line-block">
                    <i class="fas fa-compass text-white"></i>
                </span>
                RASTREAMENTO
            </button>

            <div class="collapse red lighten-5 overflow-auto" id="rastreamento">
                <li tabindex="6" onclick="acessPage('localizacaoVeiculos.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-map"></i>
                    </span>
                    <span>LOC. VEÍCULOS</span>
                </li>
            </div>
            <div class="collapse red lighten-5 overflow-auto" id="rastreamento">
                <li tabindex="6" onclick="acessPage('roteirizacao.php')" class="lighten-4">
                    <span class="icone line-block">
                        <i class="fas fa-map"></i>
                    </span>
                    <span>ROTEIRIZAÇÃO</span>
                </li>
            </div>



            <li tabindex="6" onclick="acessPage('motoristas.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-user"></i>
                </span>
                <span>FUNCIONÁRIOS</span>
            </li>
            <li tabindex="6" onclick="acessPage('mapaControleMov.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-car"></i>
                </span>
                <span>CONTROLE DE VEÍCULOS</span>
            </li>
            <li tabindex="6" onclick="acessPage('anomaliasCmv.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fab fa-autoprefixer"></i>
                </span>
                <span>ANOMALIAS</span>
            </li>
            <li tabindex="6" onclick="acessPage('rhged.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-address-book"></i>
                </span>
                <span>CONTROLE DE RH</span>
            </li>
            <li tabindex="6" onclick="acessPage('controleDePonto.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-clipboard-check"></i>
                </span>
                <span>CONTROLE DE PONTO</span>
            </li>
            <li tabindex="7" onclick="acessPage('usuarios.php')">
                <span class="icone line-block">
                    <i class="fas fa-location-arrow"></i>
                </span>
                <span>USUÁRIOS</span>
            </li>


            <li tabindex="0" class="align-text-top" onclick="acessPage('./includes/logout.php')">
                <span class="icone line-block">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span>SAIR</span>
            </li>
        <?php } ?>








        <?php if ($_SESSION["acesso"] == 5) { ?>
            <h6 class="red lighten-1 text-white p-2">
                <span class="icone line-block">
                    <i class="fas fa-car text-white"></i>
                </span>
                GESTÃO DE VEÍCULOS
            </h6>


            <li tabindex="6" onclick="acessPage('localizacaoVeiculos.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-map"></i>
                </span>
                <span>LOC. VEÍCULOS</span>
            </li>

            <li tabindex="6" onclick="acessPage('guiasRecolhimento.php')" class="lighten-4">
                <span class="icone line-block">
                    <i class="fas fa-car"></i>
                </span>
                <span>GUIA DE RECOLHIMENTO</span>
            </li>



            <li tabindex="0" class="align-text-top" onclick="acessPage('./includes/logout.php')">
                <span class="icone line-block">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span>SAIR</span>
            </li>
        <?php } else { ?>

        <?php } ?>
    </ul>
</nav>

<!-- To change the direction of the modal animation change .right class -->
<div class="modal fade right" id="modalSenhaUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <!-- Add class .modal-side and then add class .modal-top-right (or other classes from list above) to set a position to the modal -->
    <div class="modal-dialog modal-side modal-top-left" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Redefinir senha</h4>
            </div>
            <div class="modal-body">
                <div class="p-1">
                    <i class="fas fa-lock prefix text-dark"></i>
                    <label for="novaSenha">senha</label>
                    <input type="password" id="novaSenha" class="form-control" placeholder="Digite a senha" onkeypress="resetHelper('passHelpCad') ">
                    <small id="passHelpUser" class="text-danger"></small>
                </div>

                <div class="p-1">
                    <i class="fas fa-lock prefix text-dark"></i>
                    <label for="novaRepetir">Repetir senha</label>
                    <input type="password" id="novaRepetir" class="form-control" placeholder="Repita a senha">
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <a type="submit" class="btn btn-success" id="btnNovaSenha">Salvar</a>
                <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
            </div>
        </div>
    </div>
</div>
<!-- Side Modal Top Right -->

<!-- Modal senha com sucesso -->
<div class="modal fade" id="modificadoComSucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-sm modal-dialog modal-notify modal-success" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header p-2">
                <p class="heading p-2 lead">Sucesso</p>

                <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                    <p>Senha modificada com sucesso</p>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Ok</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

<!-- Fim -->