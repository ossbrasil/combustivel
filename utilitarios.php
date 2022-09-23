<?php include("./includes/head.php"); ?>
<?php include_once("./includes/navbar.php") ?>

<!DOCTYPE html>
<html lang="en">
<?php
if ($_SESSION['acesso'] >= 3) {
    echo "<script>window.location = './menu.php'</script>";
} ?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cadastro de Utilitários</title>
</head>

<body style="font-family: sans-serif;font-size: 1rem;">
    <div id="cadastroUtilitarios" class="container">
        <h1 class="w-100 text-center p-3 font-weight-bold">Cadastro de Utilitários</h1>
        <section id="tabela" class="text-nowrap">
            <span class="table-add float-right mb-3 mr-2"><a class="text-success" data-toggle="modal" data-target="#registrar"><i class="fas fa-plus fa-2x" aria-hidden="true" onclick="abrirmodalUtilitario()" style="margin-top: 15;"></i></a></span>
            <!-- Start your project here-->
            <table id="listarutilitariostable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead class='blue-grey lighten-4'>
                    <tr>
                        <th class="th-sm text-center">Nº Registro
                        </th>
                        <th class="th-sm text-center">Marca
                        </th>
                        <th class="th-sm text-center">Modelo
                        </th>
                        <th class="th-sm text-center">Ações
                        </th>
                    </tr>
                </thead>
                <tbody id="cadastroUtilitariostable">

                </tbody>
            </table>
    </div>
</body>

<section id="modaisDoCrud">
    <!-- Modal cadastrar Utilitario -->
    <div class="modal fade" id="registrarUtilitario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Cadastrar Veículo Utilitário</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cadastrarNReg">N° de registro</label>
                            <input type="number" id="cadastrarNReg" class="form-control" placeholder="Digite o N° de registro" onchange="resetHelper('cadNRegHelpCad')">
                            <small id="cadNRegHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cadastrarMarca">Marca</label>
                            <input type="text" id="cadastrarMarca" class="form-control" placeholder="Digite a marca" onchange="resetHelper('cadtrarMarcaHelpCad')">
                            <small id="cadtrarMarcaHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cadastrarTPVeic">Percente a</label>
                            <select id="cadastrarTPVeic" class="w-100 custom-select" onchange="resetHelper('cadTPVeicHelpCad')">

                            </select>
                            <small id="cadTPVeicHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-md-5">
                            <label for="cadastrarModelo">Modelo</label>
                            <input type="text" id="cadastrarModelo" class="form-control" placeholder="Digite o modelo" onchange="resetHelper('cadModeloHelpCad')" />
                            <small id="cadModeloHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cadastrarDesc">Descrição</label>
                            <input type="text" id="cadastrarDesc" class="form-control" placeholder="Digite a descrição" onchange="resetHelper('cadDescelpCad')" />
                            <small id="cadDescelpCad" class="text-danger"></small>
                        </div>
                        <?php $years = range(1970, strftime("%Y", time())); ?>
                        <div class="form-group col-md-3">
                            <label for="cadastrarAno">Ano</label>
                            <select id="cadastrarAno" class="w-100 custom-select" onchange="resetHelper('cadAnoHelpCad')">
                                <option value="0" selected>Selecione o ano</option>
                                <?php foreach ($years as $year) : ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="cadAnoHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-md-4">
                            <label for="cadastrarLitragem">Litragem do Tanque (Máxima)</label>
                            <input type="number" id="cadastrarLitragem" class="form-control" placeholder="Digite a litragem " onchange="resetHelper('litragemHelpCad')">
                            <small id="litragemHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cadastrarQuantidade">Quantidade Máxima (Por dia)</label>
                            <input type="number" id="cadastrarQuantidade" class="form-control" placeholder="Digite a quantidade" onchange="resetHelper('quantHelpCad')">
                            <small id="quantHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cadastrarTipoComb">Tipo de Combustível</label> <select id="cadastrarTipoComb" class="w-100 custom-select" onchange="resetHelper('tpCombHelpCad')">
                                <option value="0" selected disabled>Selecione o tipo</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Etanol">Etanol</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Flex">Flex</option>
                            </select>
                            <small id="tpCombHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" onclick="cadUtilitario()" id="btnRegistrarUtilitario">Cadastrar</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal Editar Utilitario -->
    <div class="modal fade" id="editarUtilitario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-primary" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Editar Veículo Utilirário</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="editarNReg">N° de registro</label>
                            <input type="number" id="editarNReg" class="form-control" placeholder="Digite o N° de registro" onchange="resetHelper('editNRegHelpCad')">
                            <small id="editNRegHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editarMarca">Marca</label>
                            <input type="text" id="editarMarca" class="form-control" placeholder="Digite a Marca" value="" maxlength="40" onchange="resetHelper('edMarcaHelpCad')">
                            <small id="edMarcaHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editarTPVeic">Pertence a</label>
                            <select id="editarTPVeic" class="w-100 custom-select" onchange="resetHelper('editTPVeicHelpCad')">

                            </select>
                            <small id="editTPVeicHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-md-5">
                            <label for="editarModelo">Modelo</label>
                            <input type="text" id="editarModelo" class="form-control" placeholder="Digite o Modelo" value="" maxlength="40" onchange="resetHelper('edModeloHelpCad')">
                            <small id="edModeloHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="editarDesc">Descrição</label>
                            <input type="text" id="editarDesc" class="form-control" placeholder="Digite a descrição" onchange="resetHelper('editDescelpCad')" />
                            <small id="editDescelpCad" class="text-danger"></small>
                        </div>
                        <?php $years = range(1970, strftime("%Y", time())); ?>
                        <div class="form-group col-md-2">
                            <label for="editarAno">Ano</label>
                            <select id="editarAno" class="w-100 custom-select" onchange="resetHelper('edAnoHelpCad')">
                                <option value='0' selected>Selecione o ano</option>
                                <?php foreach ($years as $year) : ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="edAnoHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="form-group col-md-4">
                            <label for="editarLitragem">Litragem do Tanque (Máxima)</label>
                            <input type="number" id="editarLitragem" min="1" max="90" max class="form-control" placeholder="Digite a Litragem" onchange="resetHelper('edLitragemHelpCad')">
                            <small id="edLitragemHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editarQuantidade">Quantidade Máxima (POR DIA)</label>
                            <input type="number" id="editarQuantidade" min="1" max="90" class="form-control" placeholder="Digite a Quantidade" onchange="resetHelper('edQuantHelpCad')">
                            <small id="edQuantHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editarTipoComb">Tipo de Combustível</label> <select id="editarTipoComb" class="w-100 custom-select" onchange="resetHelper('edTpCombHelpCad')">
                                <option value="0" selected disabled>Selecione o tipo</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Etanol">Etanol</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Flex">Flex</option>
                            </select>
                            <small id="edTpCombHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-primary" onclick="alterarUtilitario()" id="btnEditarUtilitario">Salvar</a>
                    <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <!-- Modal deletar Veiculo -->
    <div class="modal fade" id="deletarVeiculo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-sm modal-dialog modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header p-2 d-flex justify-content-center">
                    <p class="heading p-2">Deletar Veículo</p>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <p>Deseja mesmo deletar o Veículo?</p>
                    <i class="fas fa-times fa-4x animated rotateIn"></i>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="submit" class="btn btn-success" id="btnDeletarVeiculo">Sim</a>
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
                        <p>Veiculo criado com sucesso</p>
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
                        <p>Veículo editada com sucesso</p>
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
                        <p>Veículo excluído com sucesso</p>
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

<script src="./js/utilitarios.js"></script>