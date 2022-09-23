<?php include("./includes/head.php"); ?>
<?php include_once("./includes/navbar.php") ?>


<?php
    if ($_SESSION['acesso'] >=2) {
        echo "<script>window.location = './menu.php'</script>";
      }?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cadastro de Clientes</title>
</head>

<body class="font-weight">
    <div id="cadastro.php" class="container">
        <h1 class="w-100 text-center p-3 font-weight-bold">Cadastro de Clientes</h1>
        <section id="tabela" class="text-nowrap">
            <span class="table-add float-right mb-3 mr-2"><a class="text-success" data-toggle="modal" data-target="#registrar"><i class="fas fa-plus fa-2x" aria-hidden="true" onclick="abrirmodalCad()" style="margin-top: 15;"></i></a></span>
            <!-- Start your project here-->
            <table id="ListarEntregastable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                <thead  class='blue-grey lighten-4'>
                    <tr>
                        <th class="th-sm text-center">Nome do Cliente
                            <!-- <i class="fa fa-sort float-right" aria-hidden="true"></i> -->
                        </th>
                        <th class="th-sm text-center">Plano
                            <!-- <i class="fa fa-sort float-right" aria-hidden="true"></i> -->
                        </th>
                        <th class="th-sm text-center">Vencimento(data)
                            <!-- <i class="fa fa-sort float-right" aria-hidden="true"></i> -->
                        </th>
                        <th class="th-sm text-center">AÇÕES
                            <!-- <i class="fa fa-sort float-right" aria-hidden="true"></i> -->
                        </th>
                    </tr>
                </thead>
                <tbody id="Cadastrotable">
                </tbody>
            </table>
    </div>
</body>

<section id="modaisDoCrud">

    <!-- Modal cadastrar Entrega -->
    <div class="modal fade" id="registrarEntrega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Cadastrar Cliente</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nomecad">Nome do Cliente</label>
                            <input type="text" id="nomecad" class="form-control" placeholder="Digite o nome completo" onchange="resetHelper('nameHelpCad') ">
                            <small id="nameHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emailcad">E-mail</label>
                            <input type="email" id="emailcad" class="form-control" placeholder="Digite o E-mail" onchange="resetHelper('emailHelpCad') ">
                            <small id="emailHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="planocad">Plano</label>
                            <select id="planocad" class="form-control" onchange="resetHelper('planoHelpCad') ">
                            <option value="0" selected>Selecione</option>
                            <option value="1">Básico</option>
                            <option value="2">Intermediário</option>
                            <option value="3">Avançado</option>
                        </select>
                            <small id="planoHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vencimentocad">Vencimento(data)</label>
                            <input type="date" class="form-control datefield" id="vencimentocad" onchange="resetHelper('vencHelpCad')">
                            <small id="vencHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="senhacad">Senha</label>
                            <input type="password" id="senhacad" class="form-control" placeholder="Digite a Senha" onchange="resetHelper('passHelpCad') ">
                            <span toggle="#senhacad" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <small id="passHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="confsenhacad">Confirmar Senha</label>
                            <input type="password" id="confsenhacad" class="form-control" placeholder="Confirme a Senha" onchange="resetHelper('confpassHelpCad') ">
                            <span toggle="#confsenhacad" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="tipocad">Nível de Acesso</label>
                        <select id="tipocad" class="form-control" onchange="resetHelper('nivelHelpCad') ">
                            <option value="" selected>Selecione</option>
                            <option value="1">Administrador</option>
                            <option value="2 ">Cliente</option>
                        </select>
                        <small id="nivelHelpCad" class="text-danger"></small>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" onclick="criarCliente()" id="btnRegistrarUser">Cadastrar</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal Editar Entrega -->
    <div class="modal fade" id="editarCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-primary" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Editar Cliente</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nomeEdit">Nome do Cliente</label>
                            <input type="text" id="nomeEdit" class="form-control" placeholder="Digite o Nome" onchange="resetHelper('nomeEditHelpCad')">
                            <small id="nomeEditHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emailEdit">E-mail</label>
                            <input type="email" id="emailEdit" class="form-control" placeholder="Digite o E-mail" onchange="resetHelper('emailEditHelpCad')">
                            <small id="emailEditHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="planoEdit">Plano</label>
                            <select id="planoEdit" class="form-control" onchange="resetHelper('planoEditHelpCad') ">
                            <option value="0" selected>Selecione</option>
                            <option value="1">Básico</option>
                            <option value="2">Intermediário</option>
                            <option value="3">Avançado</option>
                        </select>
                            <small id="planoEditHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vencimentoEdit">Vencimento(data)</label>
                            <input type="date" maxlength="10" id="vencimentoEdit" class="form-control" placeholder="Vencimento" onchange="resetHelper('vencimentoEditHelpCad')">
                            <small id="vencimentoEditHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="senhaEdit">Senha</label>
                            <input type="password" id="senhaEdit" class="form-control" placeholder="Digite a Senha" onchange="resetHelper('senhaEditHelpCad')">
                            <span toggle="#senhaEdit" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <small id="senhaEditHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="confsenhaEdit">Confirmar Senha</label>
                            <input type="password" id="confsenhaEdit" class="form-control" placeholder="Confirme a Senha" onchange="resetHelper('confsenhaEditHelpCad')">
                            <span toggle="#confsenhaEdit" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <small id="confsenhaEditHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="nivelEdit">Nível de Acesso</label>
                        <select id="nivelEdit" class="form-control" onchange="resetHelper('nivelEditHelpCad') ">
                            <option value="" selected>Selecione</option>
                            <option value="1">Administrador</option>
                            <option value="2 ">Cliente</option>
                        </select>
                        <small id="nivelEditHelpCad" class="text-danger"></small>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" onclick="alterarEntrega()" id="btnRegistrarEntrega">Salvar</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal deletar Entrega -->
    <div class="modal fade" id="deletarEntrega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-sm modal-dialog modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header p-2 d-flex justify-content-center">
                    <p class="heading p-2">Deletar Cliente</p>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <p>Deseja mesmo deletar a Cliente?</p>
                    <i class="fas fa-times fa-4x animated rotateIn"></i>

                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" id="btnDeletarEntrega">Sim</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal CRiado com sucesso -->
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
                        <p>Entrega criada com sucesso</p>
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

    <!-- Modal editado com sucesso -->
    <div class="modal fade" id="editadoComSucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-sm modal-dialog modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Editado com sucesso</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                        <p>Entrega editada com sucesso</p>
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

    <!-- Modal deletado com sucesso -->
    <div class="modal fade" id="deletadoComSucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-sm modal-dialog modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Excluído com sucesso</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                        <p>Entrega excluída com sucesso</p>
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

</section>

</html>

<?php include("./includes/imports.php") ?>

<script src="./js/cadastro.js"></script>