var idglobal = 0;

$(document).on('hidden.bs.modal', '.modal', function() {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

$('.myCollapsible').on('shown.bs.collapse', function() {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
});

// Data Tables Veiculos
function executaTabelaVeiculos() {
    $('#ListarVeiculostable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#ListarVeiculostable').DataTable({
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

        }
    });
}

executaTabelaVeiculos();


function listarVeiculo() {
    listaEmpresas()
        //Conecta com o metodo get de listar usuários
    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro_veiculo.php/retornaVeiculos",
        success: function(data) {
            console.log(data);
            $('#ListarVeiculostable').DataTable().destroy();
            $table = '';

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {

                var it = mydata[i];

                $table += "<tr>";

                $table += "<td class='th-sm text-center align-middle'>" + it.prefixo + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.placa + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.modelo + "</td>";

                $table += "<td class='th-sm text-center align-middle'><button id=" + it.id + " onclick='abrirmodalEditar(this.id)' type='button' class='btn btn-primary p-2'><i class='fas fa-pen fa-lg'></i></button>";

                $table += "<button id=" + it.id + " onclick='abrirmodalDeletar(this.id)' type='button' class='btn btn-danger p-2 deleteButton'><i class='fas fa-trash'></i></button></td>";

                $table += "</tr>";
                idfuncionario = it.id
            }
            $('#cadastroVeiculostable').html($table);
            executaTabelaVeiculos();

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

function resetModal() {
    document.location.reload(true);
}

function resetHelper(id) {
    var id_do_small = id
    $('#' + id_do_small).text('')
}
// Modal de cadastrar Veiculo

function abrirmodalVeiculo() {
    $('#registrarVeiculo').modal('show');
    $("#cadastrarPlaca").mask('AAA-9999');
    $("#cadastrarPrefixo").mask('999');

    $("#cadastrarPrefixo").mask('999');
}


function cadVeiculo() {

    var data = {
        "placa": $('#cadastrarPlaca').val(),
        "prefixo": $('#cadastrarPrefixo').val(),
        "marca": $('#cadastrarMarca').val(),
        "empresa": $('#cadastrarEmpresa').val(),
        "modelo": $('#cadastrarModelo').val(),
        "tpVeic": $('#cadastrarTPVeic').val(),
        "ano": $('#cadastrarAno').val(),
        "km": $('#cadastroKM').val(),
        "qtdDia": $('#cadastrarQuantidade').val(),
        "qtdTotal": $('#cadastrarLitragem').val(),
        "tpComb": $('#cadastrarTipoComb').val()
    };
    if ($('#cadastrarPlaca').val().length == 0) {
        $('#placaHelpCad').html("Digite uma pláca válida.")
    } else if ($('#cadastrarLitragem').val().length == 0 || $('#cadastrarLitragem').val() >= 99 || $('#cadastrarLitragem').val() <= 0) {
        $('#cadastrarLitragem').val("");
        $('#litragemHelpCad').html("Digite uma quantidade válida.");
    } else if ($('#cadastrarQuantidade').val().length == 0 || $('#cadastrarQuantidade').val() >= 99 || $('#cadastrarQuantidade').val() <= 0 || $('#cadastrarQuantidade').val() > $('#cadastrarLitragem').val()) {
        $('#quantHelpCad').html("Digite uma quantidade válida.");
        $('#cadastrarQuantidade').val("");
    } else if ($('#cadastrarTipoComb').val() == 0) {
        $('#tpCombHelpCad').html("Selecione um tipo de combustível.");
        $('#cadastrarQuantidade').val("");
    } else if ($('#cadastroKM').val().length == 0) {
        $('#cadKMHelpCad').html("Digite uma quantidade válida");
        $('#cadastroKM').val("");
    } else {
        $.ajax({
            method: 'POST',
            url: "./web_services/ws-cadastro_veiculo.php/criarVeiculos/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(data) {
                console.log(data);
                $('#registrarVeiculo').modal('hide');
                $('#criadoComSucesso').modal('show');
                listarVeiculo();
                idglobal = 0;
            }
        });
    }

}

//modal de editar veiculo
function abrirmodalEditar(id) {
    $('#qrcode').html('');
    idglobal = id;

    $.ajax({
        type: "get",
        url: "./web_services/ws-cadastro_veiculo.php/listaEditarVeiculo/" + id,
        success: function(data) {

            var mydata = JSON.parse(data);
            var it = mydata[0];

            try {

                new QRCode(document.getElementById('qrcode'), it.id);
                $('#qrCheck').removeClass('d-none');
                // var qr = document.getElementById('qrcode');
                // var img = qr.getElementsByTagName('img');
                // console.log(img[0].outerHTML)
                $('#editarPlaca').val(it.placa);
                $('#editarPrefixo').val(it.prefixo);
                $('#editarMarca').val(it.marca);
                // $('#cadastrarEmpresa').val();
                $('#editarModelo').val(it.modelo);
                console.log(it.empresa);
                $('#editarTPVeic').val(it.empresa);
                // $('#cadastrarTPVeic').val();
                $('#editarAno').val(it.ano);
                $('#editarLitragem').val(it.limit_tanque);
                $('#editarQuantidade').val(it.limit_dia);
                $('#editarTipoComb').val(it.combustivel);




                $('#editarVeiculo').modal('show');
            } catch (e) {
                Alert(e);
            }
        }
    });
}


function alterarVeiculo() {

    var id = idglobal;

    var placa = $('#editarPlaca').val();
    var prefixo = $('#editarPrefixo').val();
    var marca = $('#editarMarca').val();
    var empresa = $('#editarEmpresa').val();
    var modelo = $('#editarModelo').val();
    var tpVeic = $('#editarTPVeic').val();
    var ano = $('#editarAno').val();
    var tpComb = $('#editarTipoComb').val();
    var qtdDia = $('#editarQuantidade').val();
    var qtdTotal = $('#editarLitragem').val();


    var data = {
        "id": id,
        'placa': placa,
        "prefixo": prefixo,
        "marca": marca,
        "empresa": empresa,
        "modelo": modelo,
        "tpVeic": tpVeic,
        "ano": ano,
        "tpComb": tpComb,
        "qtdDia": qtdDia,
        "qtdTotal": qtdTotal
    }

    console.log(data)

    $.ajax({
        method: 'POST',
        url: './web_services/ws-cadastro_veiculo.php/alterarVeiculo/',
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function(data) {
            $('#editarVeiculo').modal('hide');
            $('#editadoComSucesso').modal('show');
            listarVeiculo();
            idglobal = 0;
        }
    });
    // }

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

$(document).ready(function() {
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('input[type=text],input[type=time],input[type=date],input[type=password], textarea, smal').val('');
        $(this).find('select.selectValues').val('0');
        $(this).find(':checkbox').prop('checked', false);


    });
});
listarVeiculo();


//modal de excluido com sucesso