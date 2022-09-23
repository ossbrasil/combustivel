var idglobal = 0;

$(document).on('hidden.bs.modal', '.modal', function() {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

$('.myCollapsible').on('shown.bs.collapse', function() {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
});

// Data Tables Empresa
function executaTabelaEmpresa() {
    $('#ListarEmpresatable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#ListarEmpresatable').DataTable({
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
            }
        }
    });
}

executaTabelaEmpresa();


function listarEmpresa() {
    //Conecta com o metodo get de listar usuários
    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro_empresa.php/retornaEmpresa",
        success: function(data) {
            console.log(data);
            $('#ListarEmpresatable').DataTable().destroy();
            $table = '';

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {

                var it = mydata[i];

                $table += "<tr>";

                $table += "<td class='th-sm text-center align-middle'>" + it.id + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.nome + "</td>";


                $table += "<td class='th-sm text-center align-middle'><button id=" + it.id + " onclick='abrirmodalEditar(this.id)' type='button' class='btn btn-primary p-2'><i class='fas fa-pen fa-lg'></i></button>";

                $table += "<button id=" + it.id + " onclick='abrirmodalDeletar(this.id)' type='button' class='btn btn-danger p-2 deleteButton'><i class='fas fa-trash'></i></button></td>";

                $table += "</tr>";
                idfuncionario = it.id

            }
            $('#cadastroEmpresatable').html($table);
            executaTabelaEmpresa();

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
// Modal de cadastrar Empresa

function abrirModalEmpresa() {
    $('#registrarEmpresa').modal('show');
}


function cadEmpresa() {

    var data = {

        "nome": $('#cadastrarNome').val(),

    };
    if ($('#cadastrarNome').val().length == 0) {
        $('#nomeHelpCad').html("Digite uma nome válido.")
    } else {
        $.ajax({
            method: 'POST',
            url: "./web_services/ws-cadastro_empresa.php/criarEmpresa/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(data) {
                console.log(data);
                $('#registrarEmpresas').modal('hide');
                // $('#criadoComSucesso').modal('show');
                listarEmpresa();

            }
        });
    }

}

function abrirmodalEditar(id) { $('#editarEmpresa').modal('show');
    idglobal = id; }




function alterarEmpresa() {

    var id = idglobal;

    var nome = $('#editNome').val();
    console.log(nome);

    var data = {
        "id": id,
        'nome': nome,

    }

    console.log(data)

    if ($('#editNome').val().length == 0) {
        $('#nomeHelpCad').html("Digite uma nome válido.")
    } else {
        $.ajax({
            type: "put",
            contentType: "application/json",
            data: JSON.stringify(data),
            url: "./web_services/ws-cadastro_empresa.php/alterarEmpresa/",
            success: function(data) {
                $('#editarEmpresa').modal('hide');
                $('#editadoComSucesso').modal('show');
                listarEmpresa();
                idglobal = 0;
            }
        });
    }

}
//modal de editado com sucesso

// function abrirmodalEditado() {
//     $('#editadoComSucesso').modal('show');
// }

//modal de excluir Empresa


function abrirmodalDeletar(id) {
    idglobal = 0;
    idglobal = id;
    $('#deletarEmpresa').modal('show');
}

$("#btnDeletarEmpresa").click(function() {
    $.ajax({
        type: "DELETE",
        url: "./web_services/ws-cadastro_empresa.php/deletarEmpresa/" + idglobal,
        success: function(data) {
            $('#deletarEmpresa').modal('hide');
            $('#deletadoComSucesso').modal('show');
            listarEmpresa();
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
listarEmpresa();


//modal de excluido com sucesso