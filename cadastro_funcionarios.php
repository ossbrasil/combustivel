<?php include("./includes/head.php"); ?>
<?php include_once("./includes/navbar.php"); ?>

<?php include("./includes/imports.php"); ?>

<?php
if ($_SESSION['acesso'] >= 3) {
    echo "<script>window.location = './menu.php'</script>";
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cadastro de Funcionários</title>
</head>

<body>
    <div id="cadastroFuncionarios" class="container">
        <h1 class="w-100 text-center p-3 font-weight-bold">Cadastro de Funcionários</h1>
        <section id="tabela" class="text-nowrap">
            <?php
            if ($_SESSION['acesso'] >= 2) {
                echo '<span class="table-add float-right mb-3 mr-2"><a class="text-success" data-toggle="modal" data-target="#registrar"><i class="fas fa-plus fa-2x" aria-hidden="true" onclick="abrirmodalFuncionario()" style="margin-top: 15;"></i></a></span>';
            } ?>

            <!-- Start your project here-->
            <table id="ListarFuncionariostable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                <thead class='blue-grey lighten-4'>
                    <tr>
                        <th class="text-center th-sm">Nome
                        </th>
                        <th class="text-center th-sm">Matricula
                        </th>
                        <th class="text-center th-sm">E-mail
                        </th>
                        <th class="text-center th-sm">Ações
                        </th>
                    </tr>
                </thead>
                <tbody id="cadastrofuncionariotable">
                    <!-- <tr id="1">
                        <td class='th-sm text-center align-middle'>Teste1</td>
                        <td class='th-sm text-center align-middle'>123456789</td>
                        <td class='th-sm text-center align-middle'>teste@teste.com.br</td>
                        <td class='th-sm text-center align-middle'>
                            <button onclick='abrirmodalEditar()' type='button' class='btn btn-primary p-2'><i class='fas fa-pen'></i></button>
                            <button onclick='abrirmodalDeletar()' type='button' class='btn btn-danger p-2'><i class='fas fa-trash'></i></button>
                        </td>
                    </tr> -->
                </tbody>
            </table>
    </div>
</body>

<section id="modaisDoCrud">

    <!-- Modal cadastrar Funcionario -->
    <div class="modal fade" id="registrarFuncionario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Cadastrar Funcionário</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nomecad">Nome</label>
                            <input type="text" id="nomecad" class="form-control" placeholder="Digite o Nome" onkeypress="resetHelper('nomeHelpCad') ">
                            <small id="nomeHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="matriculacad">Matricula</label>
                            <input type="text" id="matriculacad" class="form-control" placeholder="Digite a Matricula" onkeypress="resetHelper('matriHelpCad') ">
                            <small id="matriHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emailcad">E-mail</label>
                            <input type="text" id="emailcad" class="form-control" placeholder="Digite o E-mail" onkeypress="resetHelper('emailHelpCad') ">
                            <small id="emailHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="cadastrarSenha">Senha</label>
                            <input type="password" id="senhacad" class="form-control" placeholder="Digite a Senha" onkeypress="resetHelper('passHelpCad') ">
                            <span toggle="#senhacad" class="fas fa-eye fa-fw field-icon toggle-password"></span>
                            <small id="passHelpCad" class="text-danger"></small>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="cadastrarConfSenha">Confirmar Senha</label>
                            <input type="password" id="confsenhacad" class="form-control" placeholder="Confirme a Senha" onkeypress="resetHelper('confPassHelpCad') ">
                            <span toggle="#confsenhacad" class="fas fa-fw fa-eye field-icon toggle-password"></span>
                            <small id="confPassHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nivel_acessocad">Nível de Acesso</label>
                            <select type="nivel_acesso" id="nivel_acessocad" class="form-control" onchange="resetHelper('nivelHelpCad')">
                                <option value="0" selected disabled>Selecione</option>
                                <option value="4">Administrador</option>
                                <option value="5">Funcionário</option>
                                <option value="6">Motorista</option>
                                <option value="7">Frentista </option>
                            </select>
                            <small id="nivelHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" onclick="criarFuncionario()" id="btnRegistrarFuncionario">Cadastrar</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal Editar Entrega -->
    <div class="modal fade" id="editarFuncionario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-primary" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Editar Funcionário</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nomeEdit">Nome</label>
                            <input type="text" id="nomeEdit" class="form-control" placeholder="Digite o Nome" onkeypress="resetHelper('nomeEditHelpCad')">
                            <small id="nomeEditHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emailEdit">E-mail</label>
                            <input type="email" id="emailEdit" class="form-control" placeholder="Digite o E-mail" onkeypress="resetHelper('emailEditHelpCad')">
                            <small id="emailEditHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="matriEdit">Matrícula</label>
                            <input type="text" id="matriEdit" class="form-control" placeholder="Digite o Plano" onkeypress="resetHelper('matriEditHelpCad')">
                            <small id="matriEditHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nivelEdit">Nível de Acesso</label>
                            <select type="tipo" id="nivelEdit" class="form-control" onchange="resetHelper('nivelEditHelpCad')">
                                <option value="0" selected disabled>Selecione</option>
                                <option value="4">Administrador</option>
                                <option value="5">Funcionário </option>
                                <option value="6">Motorista </option>
                                <option value="7">Frentista </option>
                            </select>
                            <small id="nivelEditHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="d-flex text-left col-6 justify-content-start">
                                <a type="submit" class="btn btn-primary btn-sm" onclick="abreTrocarSenha()" id="btnTrocarSenha">Trocar Senha</a>
                            </div>
                            <div class="d-flex text-right col-6 justify-content-end">
                                <a type="submit" class="btn btn-success btn-sm" onclick="alterarFuncionario()" id="btnEditarFuncionario">Salvar</a>
                                <a type="button" class="btn btn-danger btn-sm waves-effect" data-dismiss="modal">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal edição de senha -->
    <div class="modal fade" id="trocarSenha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-primary" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header p-2 d-flex justify-content-center">
                    <p class="heading p-2">Deseja a troca de senha?</p>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="cadastrarSenha">Senha</label>
                            <input type="password" id="senhaEdit" class="form-control" placeholder="Digite a Senha" onkeypress="resetHelper('senhaEditHelpCad')">
                            <span toggle="#senhaEdit" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <small id="senhaEditHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cadastrarConfSenha">Confirmar Senha</label>
                            <input type="password" id="confsenhaEdit" class="form-control" placeholder="Confirme a Senha" onkeypress="resetHelper('confsenhaEditHelpCad')">
                            <span toggle="#confsenhaEdit" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <small id="confsenhaEditHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" onclick="alterarSenha()" id="btnTrocarSenha">Sim</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>


    <!-- Modal editado com sucesso -->
    <div class="modal fade" id="senhaTrocada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-sm modal-dialog modal-notify modal-primary" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Senha alterada</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                        <p>Senha alterada com sucesso</p>
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

    <!-- Modal deletar Funcionario -->
    <div class="modal fade" id="deletarFuncionario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-sm modal-dialog modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header p-2 d-flex justify-content-center">
                    <p class="heading p-2">Deletar Funcionário</p>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <p>Deseja mesmo deletar a Funcionário?</p>
                    <i class="fas fa-times fa-4x animated rotateIn"></i>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" id="btnDeletarFuncionario">Sim</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal Criado com sucesso -->
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
                        <p>Funcionário criado com sucesso</p>
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
                        <p>Funcionário editado com sucesso</p>
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
                        <p>Funcionario excluído com sucesso</p>
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

<script src="./js/cadastrofuncionario.js"></script>