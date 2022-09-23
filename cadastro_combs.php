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
    <title>Cadastro de Combustível</title>
</head>

<body style="font-family: sans-serif;font-size: 1rem;">
    <div id="cadastroVeiculos" class="container">
        <h1 class="w-100 text-center p-3 font-weight-bold">Cadastro de Combustível</h1>
        <section id="tabela" class="text-nowrap">
            <!-- <span class="table-add float-right mb-3 mr-2"><a class="text-success" data-toggle="modal" data-target="#registrar"><i class="fas fa-plus fa-2x" aria-hidden="true" onclick="abrirmodalVeiculo()" style="margin-top: 15;"></i></a></span>
            Start your project here -->
            <table id="Abstable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                <thead class='blue-grey lighten-4'>
                    <tr>
                        <th class="text-center th-sm">Tipo
                        </th>
                        <th class="text-center th-sm">Quantidade Total
                        </th>
                        <th class="text-center th-sm">Quantidade Atual
                        </th>
                        <th class="text-center th-sm">Data - Hora
                        </th>
                        <th class="text-center th-sm">Ações
                        </th>
                    </tr>
                </thead>
                <tbody id="cadastroVeiculostable">

                </tbody>
            </table>
    </div>
</body>

<section id="modaisDoCrud">



    <!-- Modal Info Combs -->
    <div class="modal fade" id="viewInfoAbs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-notify modal-primary" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header p-2">
                    <p class="heading p-2 lead">Informações do Combustivel</p>

                    <button type="button" class="close p-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="infoTipoComb">Tipo de Combustível</label> <select id="infoTipoComb" class="w-100 custom-select" disabled onchange="resetHelper('edTpCombHelpCad')">
                                <option value="0">Selecione o tipo</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Etanol">Etanol</option>
                                <option value="Diesel">Diesel</option>
                            </select>
                            <small id="edTpCombHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="infoQT">Quantidade Total</label>
                            <input type="text" id="infoQT" class="form-control" placeholder="Digite o Prefixo" disabled onkeypress="resetHelper('edPrefixoHelpCad')">
                            <small id="edPrefixoHelpCad" class="text-danger"></small>
                        </div>

                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-md-6">
                            <label for="infoData">Data</label>
                            <input type="text" id="infoData" class="form-control" placeholder="Digite o Modelo" value="" maxlength="40" disabled onkeypress="resetHelper('edModeloHelpCad')">
                            <small id="edModeloHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="infoHora">Hora</label>
                            <input type="text" id="infoHora" class="form-control" placeholder="Digite o Modelo" value="" maxlength="40" disabled onkeypress="resetHelper('edModeloHelpCad')">
                            <small id="edModeloHelpCad" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-md-6">
                            <label for="infoVal">Valor Total (R$)</label>
                            <input type="text" id="infoVal" class="form-control" maxlength="40" disabled onkeypress="resetHelper('edModeloHelpCad')">
                            <small id="edModeloHelpCad" class="text-danger"></small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="infoNF">Nota</label>
                            <input type="text" id="infoNF" class="form-control" maxlength="40" disabled onkeypress="resetHelper('edModeloHelpCad')">
                            <small id="edModeloHelpCad" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="row justify-content-center" id='imgs'>

                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
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

<script src="./js/combustivel.js"></script>