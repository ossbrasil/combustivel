var idglobal = 0;

$(document).on('hidden.bs.modal', '.modal', function() {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

$('.myCollapsible').on('shown.bs.collapse', function() {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
});

// Data Tables Utilitários
function executaTabelaUtilitarios() {
    $('#listarUtilitariostable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#listarutilitariostable').DataTable({
        "scrollY": "600px",
        "scrollX": true,
        "scrollCollapse": true,
        "lengthMenu": [5, 10, 25],
        "language": {
            "info": "Exibindo pagina _PAGE_ de _PAGES_",
            "emptyTable": "Não foram encontrados registros",
            "infoEmpty": "Não foram encontrados registros",
            "sZeroRecords": "Não foram encontrados registros",
            "infoFiltered": " - filtrado _TOTAL_ de _MAX_ entradas",
            "info": "Exibindo página _PAGE_ de _PAGES_",
            "sLengthMenu": "Exibindo _MENU_ Registros",
            "search": "Buscar",
            "info": "Exibindo página _PAGE_ de _PAGES_",
            "sLengthMenu": "Exibindo _MENU_ Registros",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior"
            },
            "paging": "false",
            "searching": "false"
        }
    });
}




function listarVeiculo() {
    // Conecta com o metodo get de listar usuários
    listaEmpresas();
    $.ajax({
        type: "GET",
        url: "./web_services/ws-utilitarios.php/retornaVeiculos",
        success: function(data) {
            console.log(data);
            $('#listarutilitariostable').DataTable().destroy();
            $table = '';

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {

                var it = mydata[i];

                $table += "<tr>";

                $table += "<td class='th-sm text-center align-middle'>" + it.placa + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.marca + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.modelo + "</td>";

                $table += "<td class='th-sm text-center align-middle'><button id=" + it.id + " onclick='abrirmodalEditar(this.id)' type='button' class='btn btn-primary p-2'><i class='fas fa-pen fa-lg'></i></button>";

                $table += "<button id=" + it.id + " onclick='abrirmodalDeletar(this.id)' type='button' class='btn btn-danger p-2 deleteButton'><i class='fas fa-trash'></i></button></td>";

                $table += "</tr>";
                idfuncionario = it.id
            }
            $('#cadastroUtilitariostable').html($table);
            executaTabelaUtilitarios();

        }
    });
}

function listaEmpresas() {
    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro_veiculo.php/retornaEmpresas",
        success: function(data) {
            var mydata = JSON.parse(data);
            $('#editarTPVeic').html(`
            <option value="-1" selected disabled>Selecione o tipo</option>
            <option value="0">Própria Empresa</option> `);
            $('#cadastrarTPVeic').html(`
            <option value="-1" selected disabled>Selecione o tipo</option>
            <option value="0">Própria Empresa</option> `);
            for (var i = 0; i < mydata.length; i++) {
                var it = mydata[i];
                $('#editarTPVeic').append(`
                <option value="` + it.id + `">` + it.nome + `</option> `);
                $('#cadastrarTPVeic').append(`
                <option value="` + it.id + `">` + it.nome + `</option> `);
            }

        }
    });
}

// Modal de cadastrar Veiculo

function abrirmodalUtilitario() {
    $('#registrarUtilitario').modal('show');
}


function cadUtilitario() {

    var data = {
        "registro": $('#cadastrarNReg').val(),
        "marca": $('#cadastrarMarca').val(),
        "terceiros": $('#cadastrarTPVeic').val(),
        "modelo": $('#cadastrarModelo').val(),
        "descricao": $('#cadastrarDesc').val(),
        "ano": $('#cadastrarAno').val(),
        "qtdDia": $('#cadastrarQuantidade').val(),
        "qtdTotal": $('#cadastrarLitragem').val(),
        "tpComb": $('#cadastrarTipoComb').val()
    };
    if ($('#cadastrarNReg').val().length == 0) {
        $('#cadNRegHelpCad').html("Digite um N° de registro válido.")
    } else if ($('#cadastrarMarca').val().length == 0) {
        $('#cadastrarMarca').val("");
        $('#cadtrarMarcaHelpCad').html("Digite uma marca válida.");
    } else if ($('#cadastrarTPVeic').val().length == 0) {
        $('#cadastrarTPVeic').val("");
        $('#cadEmpresaHelpCad').html("Digite uma empresa válida.");
    } else if ($('#cadastrarModelo').val().length == 0) {
        $('#cadastrarModelo').val("");
        $('#cadModeloHelpCad').html("Digite um modelo válido.");
    } else if ($('#cadastrarDesc').val().length == 0) {
        $('#cadastrarDesc').val("");
        $('#cadDescelpCad').html("Digite uma descrição válida.");
    } else if ($('#cadastrarLitragem').val().length == 0 || $('#cadastrarLitragem').val() >= 99 || $('#cadastrarLitragem').val() <= 0) {
        $('#cadastrarLitragem').val("");
        $('#litragemHelpCad').html("Digite uma quantidade válida.");
    } else if ($('#cadastrarLitragem').val().length == 0 || $('#cadastrarLitragem').val() >= 99 || $('#cadastrarLitragem').val() <= 0) {
        $('#cadastrarLitragem').val("");
        $('#litragemHelpCad').html("Digite uma quantidade válida.");
    } else if ($('#cadastrarQuantidade').val().length == 0 || $('#cadastrarQuantidade').val() >= 99 || $('#cadastrarQuantidade').val() <= 0 || $('#cadastrarQuantidade').val() > $('#cadastrarLitragem').val()) {
        $('#quantHelpCad').html("Digite uma quantidade válida.");
        $('#cadastrarQuantidade').val("");
    } else if ($('#cadastrarTipoComb').val() == 0) {
        $('#tpCombHelpCad').html("Selecione um tipo de combustível.");
        $('#cadastrarTipoComb').val("");
    } else {
        $.ajax({
            method: 'POST',
            url: "./web_services/ws-utilitarios.php/criarVeiculos/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(data) {
                console.log(data);
                $('#registrarUtilitario').modal('hide');
                $('#criadoComSucesso').modal('show');
                listarVeiculo();
                idglobal = 0;
            }
        });
    }

}

function abrirmodalEditar(id) {

    idglobal = id;
    $.ajax({
        type: "get",
        url: "./web_services/ws-utilitarios.php/listaEditarVeiculo/" + id,
        success: function(data) {

            var mydata = JSON.parse(data);
            var it = mydata[0];

            try {
                console.log(it.registro)
                $('#editarNReg').val(it.registro);
                $('#editarMarca').val(it.marca);
                $('#editarTPVeic').val(it.terc);
                $('#editarModelo').val(it.modelo);
                $('#editarDesc').val(it.desc);
                $('#editarAno').val(it.ano);
                $('#editarLitragem').val(it.limit_tanque);
                $('#editarQuantidade').val(it.limit_dia);
                $('#editarTipoComb').val(it.combustivel);

                $('#editarUtilitario').modal('show');
            } catch (e) {
                Alert(e);
            }
        }
    });
}


function alterarUtilitario() {

    var id = idglobal;

    var registro = $('#editarNReg').val();
    var marca = $('#editarMarca').val();
    var empresa = $('#editarTPVeic').val();
    var modelo = $('#editarModelo').val();
    var descricao = $('#editarDesc').val();
    var ano = $('#editarAno').val();
    var tpComb = $('#editarTipoComb').val();
    var qtdDia = $('#editarQuantidade').val();
    var qtdTotal = $('#editarLitragem').val();

    var data = {
        "id": id,
        "terc": empresa,
        "registro": registro,
        "marca": marca,
        "empresa": empresa,
        "modelo": modelo,
        "descricao": descricao,
        "ano": ano,
        "tpComb": tpComb,
        "qtdDia": qtdDia,
        "qtdTotal": qtdTotal
    }

    console.log(data)

    $.ajax({
        method: 'POST',
        url: './web_services/ws-utilitarios.php/alterarVeiculo/',
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function(data) {
            console.log(data);
            $('#editarUtilitario').modal('hide');
            $('#editadoComSucesso').modal('show');
            listarVeiculo();
            idglobal = 0;
        }
    });
}



//modal de editado com sucesso

//modal de excluir veiculo
function abrirmodalDeletar(id) {
    idglobal = 0;
    idglobal = id;
    $('#deletarVeiculo').modal('show');
}

$("#btnDeletarVeiculo").click(function() {
    $.ajax({
        type: "DELETE",
        url: "./web_services/ws-cadastro_veiculo.php/deletarVeiculo/" + idglobal,
        success: function(data) {
            $('#deletarVeiculo').modal('hide');
            $('#deletadoComSucesso').modal('show');
            listarVeiculo();
            idglobal = 0;
        }
    });
});

function resetHelper(id) {
    var id_do_small = id
    $('#' + id_do_small).text('')
}

$(document).ready(function() {
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('input[type=text],input[type=time],input[type=date],input[type=password], textarea, smal').val('');
        $(this).find('select.selectValues').val('0');
        $(this).find(':checkbox').prop('checked', false);


    });
});

listarVeiculo();