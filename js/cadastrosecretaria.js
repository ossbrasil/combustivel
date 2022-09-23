// Data Tables Secretarias

function executaTabelaSecretarias() {
    $('#ListarSecretariastable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#ListarSecretariastable').DataTable({
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

executaTabelaSecretarias();

// Modal de Registrar Secretarias

function abrirmodalSecretaria() {
    $('#registrarSecretaria').modal('show');
}

//modal de editar Secretaria

function abrirmodalEditar() {
    $('#editarSecretaria').modal('show');
}

//modal de editado com sucesso

// function abrirmodalEditado() {
//     $('#editadoComSucesso').modal('show');
// }

//modal de excluir Secretaria

function abrirmodalDeletar() {
    $('#deletarSecretaria').modal('show');
}

//modal de excluido com sucesso

// function abrirmodalDeletado() {
//     $('#deletadoComSucesso').modal('show');
// }