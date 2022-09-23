<?php include("./includes/head.php"); ?>
<?php include_once("./includes/navbar.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cadastro de Secretarias</title>
</head>

<body>
    <div id="cadastroSecretarias" class="container">
        <h1 class="w-100 text-center p-3 font-weight-bold">Cadastro de Secretarias</h1>
        <section id="tabela" class="text-nowrap">
            <span class="table-add float-right mb-3 mr-2"><a class="text-success" data-toggle="modal" data-target="#registrar"><i class="fas fa-plus fa-2x" aria-hidden="true" onclick="abrirmodalSecretaria()" style="margin-top: 15;"></i></a></span>
            <!-- Start your project here-->
            <table id="ListarSecretariastable" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead class='blue-grey lighten-4'>
                    <tr>
                        <th class="text-center th-sm">Nome
                        </th>
                        <th class="text-center th-sm">Endereço
                        </th>
                        <th class="text-center th-sm">Número
                        </th>
                        <th class="text-center th-sm">CEP
                        </th>
                        <th class="text-center th-sm">Ações
                        </th>
                    </tr>
                </thead>
                <tbody id="cadastrosecretariatable">
                    <tr id="1">
                        <td class='th-sm text-center align-middle'>Nome Teste</td>
                        <td class='th-sm text-center align-middle'>Endereço Teste</td>
                        <td class='th-sm text-center align-middle'>123456</td>
                        <td class='th-sm text-center align-middle'>CEP teste</td>
                        <td class='th-sm text-center align-middle'>
                            <button onclick='abrirmodalEditar()' type='button' class='btn btn-primary p-2'><i class='fas fa-pen'></i></button>
                            <button onclick='abrirmodalDeletar()' type='button' class='btn btn-danger p-2'><i class='fas fa-trash'></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</body>

<section id="modaisDoCrud">

    <!-- Modal cadastrar Secretaria -->
    <div class="modal fade" id="registrarSecretaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Cadastrar Secretaria</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="p-1">
                        <label for="cadastrarNome">Nome</label>
                        <input type="text" id="nomecad" class="form-control" placeholder="Digite o Nome">
                    </div>
                    <div class="p-1">
                        <label for="cadastrarEndereco">Endereço</label>
                        <input type="text" id="enderecocad" class="form-control" placeholder="Digite o Endereço">
                    </div>
                    <div class="p-1">
                        <label for="cadastrarNúmero">Número</label>
                        <input type="text" id="numerocad" class="form-control" placeholder="Digite o Número">
                    </div>
                    <div class="p-1">
                        <label for="cadastrarCEP">CEP</label>
                        <input type="text" id="cepcad" class="form-control" placeholder="Digite o CEP">
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" onclick="criarSecretaria()" id="btnRegistrarSecretaria">Cadastrar</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal Editar Secretaria -->
    <div class="modal fade" id="editarSecretaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Editar Secretaria</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="p-1">
                        <label for="cadastrarNome">Nome</label>
                        <input type="text" id="nome" class="form-control" placeholder="Digite o Nome">
                    </div>
                    <div class="p-1">
                        <label for="cadastrarEndereço">Endereço</label>
                        <input type="text" id="endereçocad" class="form-control" placeholder="Digite o Endereço">
                    </div>
                    <div class="p-1">
                        <label for="cadastrarNumero">Número</label>
                        <input type="text" id="Numero" class="form-control" placeholder="Digite o Número">
                    </div>
                    <div class="p-1">
                        <label for="cadastrarCEP">CEP</label>
                        <input type="text" id="cep" class="form-control" placeholder="Digite o CEP">
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" onclick="alterarSecretaria()" id="btnRegistrarSecretaria">Salvar</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal deletar Secretaria -->
    <div class="modal fade" id="deletarSecretaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-sm modal-dialog modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header p-2 d-flex justify-content-center">
                    <p class="heading p-2">Deletar Secretaria</p>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <p>Deseja mesmo deletar a Secretaria?</p>
                    <i class="fas fa-times fa-4x animated rotateIn"></i>

                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" id="btnDeletarSecretaria">Sim</a>
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
                        <p>Secretaria criada com sucesso</p>
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
                        <p>Secretaria editada com sucesso</p>
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
                        <p>Secretaria excluída com sucesso</p>
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

<script src="./js/cadastrosecretaria.js"></script>