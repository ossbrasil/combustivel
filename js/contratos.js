// Data Tables Contratos

function executaTabelaContratos() {
    $('#ListarContratostable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#ListarContratostable').DataTable({
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

executaTabelaContratos();

// Modal de Registrar Contratos

function abrirmodalContratos() {
    $('#registrarContratos').modal('show');
}

//modal de editar Contratos

function abrirmodalEditar() {
    $('#editarContratos').modal('show');
}

//modal de editado com sucesso

// function abrirmodalEditado() {
//     $('#editadoComSucesso').modal('show');
// }

//modal de excluir Contratos

function abrirmodalDeletar() {
    $('#deletarContratos').modal('show');
}

//modal de excluido com sucesso

// function abrirmodalDeletado() {
//     $('#deletadoComSucesso').modal('show');
// }