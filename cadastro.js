var idglobal = 0;

$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

$('.myCollapsible').on('shown.bs.collapse', function () {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
});


function executaTabela() {
    $('#ListarEntregastable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#ListarEntregastable').DataTable({
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


executaTabela();


function listarEntregas() {
    //Conecta com o metodo get de listar usuários
    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro.php/retornacliente",
        success: function (data) {
            console.log(data);
            $('#ListarEntregastable').DataTable().destroy();
            $table = '';

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {

                var it = mydata[i];

                $table += "<tr>";

                $table += "<td class='th-sm text-center align-middle'>" + it.nome + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.plano + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.vencimento + "</td>";

                $table += "<td class='th-sm text-center align-middle'><button id='" + it.id + "' onclick='modalEditar(this.id)' type='button' class='btn btn-primary p-2'><i class='fas fa-pen'></i></button>";

                $table += "<button id='" + it.id + "' onclick='modalExcluir(this.id)' type='button' class='btn btn-danger p-2'><i class='fas fa-trash'></i></button></td>";

                $table += "</tr>";
                identrega = it.id
            }
            $('#Cadastrotable').html($table);
            executaTabela();

        }
    });
}

listarEntregas();

//criar cliente
function abrirmodalCad() {
    $('#registrarEntrega').modal('show');
}



function criarCliente() {

    //Regex de salvar usuário
    let minRegex = new RegExp("^(?=.{8,})");
    let specialRegex = new RegExp("^(?=.*[!@#\$%\^&\*])");
    let numbRegex = new RegExp("^(?=.*[0-9])");
    let letterRegex = new RegExp("^(?=.*[a-z])");
    let emailRegex = new RegExp("[a-zA-Z0-9_\\.\\+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-\\.]+");


    var nome = $('#nomecad').val();
    var plano = $('#planocad').val();
    var vencimento = $('#vencimentocad').val();
    var email = $('#emailcad').val();
    var senha = $('#senhacad').val();
    var confsenha = $('#confsenhacad').val();
    var nivel = $('#tipocad').val();

    var data = {
        "nome": nome,
        "plano": plano,
        "vencimento": vencimento,
        "email": email,
        "senha": senha,
        "nivel": nivel
    }
    console.log(data)
    

    if (nome.length == 0) {
        $('#nameHelpCad').html("Digite o nome válido.")
    } else if (email.length == 0) {
        $('#emailHelpCad').html("Digite um email válido.");
    } else if (!email.match(emailRegex)) {
        $('#emailHelpCad').html("Digite um email válido.");
    } else if (plano == 0) {
        $('#planoHelpCad').html("Digite um plano válido.");
    } else if(vencimento == "") {
        $('#vencHelpCad').html("Digite um vencimento válido.");
    } else if (senha == 0) {
        $('#passHelpCad').html("Digite uma senha.");
    } else if (!senha.match(minRegex)) {
        $('#passHelpCad').html("É necessário no mínimo 8 caracteres.");
    } else if (!senha.match(letterRegex)) {
        $('#passHelpCad').html('É necessário no mínimo 1 letra.');
    } else if (!senha.match(numbRegex)) {
        $('#passHelpCad').html('É necessário no mínimo 1 número.');
    } else if (!senha.match(specialRegex)) {
        $('#passHelpCad').html('É necessário no mínimo 1 caractere especial.');
    } else if (senha != confsenha) {
        $('#passHelpCad').html("Senhas não coincidem.");
    } else if (nivel == 0) {
        alert('Favor selecionar o Nível de acesso!');
    } else {
        $.ajax({
            method: 'POST',
            url: "./web_services/ws-cadastro.php/criarusuario/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (data) {
                console.log(data);
                $('#registrarEntrega').modal('hide');
                $('#criadoComSucesso').modal('show');
                listarEntregas();
                idglobal = 0;
            }
        });
    }
}

//puxa as informações para o modal de editar
function modalEditar(id) {
    resetModal();
    idglobal = id;

    $.ajax({
        type: "get",
        url: "./web_services/ws-cadastro.php/listaEditarCliente/" + id,
        success: function (data) {
            console.log('to aqui')

            var mydata = JSON.parse(data);
            console.log(mydata);
            var it = mydata[0];
            console.log(it);

            try {
                $('#nomeEdit').val(it.nome);
                $('#emailEdit').val(it.email);
                $('#planoEdit').val(it.plano);
                $('#vencimentoEdit').val(it.vencimento);
                $('#nivelEdit').val(it.acesso);
                $('#editarCliente').modal('show');
            } catch (e) {
                console.log(e);
            }
        }
    });
}

function resetModal() {

    resetHelper('senhaEditHelpCad')
    resetHelper('planoEditHelpCad')
    resetHelper('emailEditHelpCad')
    resetHelper('nomeEditHelpCad')

}

function alterarEntrega() {

    var id = idglobal;

    //Regex de salvar usuário
    let minRegex = new RegExp("^(?=.{8,})");
    let specialRegex = new RegExp("^(?=.*[!@#\$%\^&\*])");
    let numbRegex = new RegExp("^(?=.*[0-9])");
    let letterRegex = new RegExp("^(?=.*[a-z])");
    let emailRegex = new RegExp("[a-zA-Z0-9_\\.\\+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-\\.]+");


    var nome = $('#nomeEdit').val();
    var plano = $('#planoEdit').val();
    var vencimento = $('#vencimentoEdit').val();
    var email = $('#emailEdit').val();
    var senha = $('#senhaEdit').val();
    var confsenha = $('#confsenhaEdit').val();
    var nivel = $('#nivelEdit').val();

    var data = {
        "id": id,
        "nome": nome,
        "plano": plano,
        "vencimento": vencimento,
        "email": email,
        "senha": senha,
        "nivel": nivel
    }
    console.log(data);

    if (nome.length == 0) {
        $('#nomeEditHelpCad').html("Digite o nome válido.")
    } else if (email.length == 0) {
        $('#emailEditHelpCad').html("Digite um email válido.");
    } else if (!email.match(emailRegex)) {
        $('#emailEditHelpCad').html("Digite um email válido.");
    } else if (plano == 0) {
        $('#planoEditHelpCad').html("Escolha um plano válido.");
    } else if (vencimento.length == 0) {
        $('#vencimentoEditHelpCad').html("Digite um vencimento válido.");
    } else if (senha == 0) {
        $('#senhaEditHelpCad').html("Digite uma senha.");
    } else if (!senha.match(minRegex)) {
        $('#senhaEditHelpCad').html("É necessário no mínimo 8 caracteres.");
    } else if (!senha.match(letterRegex)) {
        $('#senhaEditHelpCad').html('É necessário no mínimo 1 letra.');
    } else if (!senha.match(numbRegex)) {
        $('#senhaEditHelpCad').html('É necessário no mínimo 1 número.');
    } else if (!senha.match(specialRegex)) {
        $('#senhaEditHelpCad').html('É necessário no mínimo 1 caractere especial.');
    } else if (senha != confsenha) {
        $('#senhaEditHelpCad').html("Senhas não coincidem.");
    } else if (nivel == null) {
        alert('Favor selecionar o Nível de acesso!');
    } else {
        $.ajax({
            method: 'POST',
            url: './web_services/ws-cadastro.php/alterarCliente/',
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (data) {

                $('#editarCliente').modal('hide');
                $('#editadoComSucesso').modal('show');



                listarEntregas();
                idglobal = 0;
            }
        });
    }

}
//Exclui a Entrega selecionada
function modalExcluir(id) {
    idglobal = 0;
    idglobal = id;
    $('#deletarEntrega').modal('show')
}

$("#btnDeletarEntrega").click(function () {
    $.ajax({
        type: "put",
        url: "./web_services/ws-cadastro.php/deletarUsuario/" + idglobal,
        success: function (data) {
            console.log(data)
            $('#deletarEntrega').modal('hide');
            $('#deletadoComSucesso').modal('show');
            listarEntregas();
            idglobal = 0;
        }
    });
});

// Limpa os modais
$(document).ready(function () {
    $('.modal').on('hidden.bs.modal', function () {
        $(this).find('input[type=text],input[type=time],input[type=date],input[type=email],input[type=password], textarea').val('');
        $(this).find('select.selectValues').val('');
        $(this).find('select.selectValues').val('0');
        $(this).find(':checkbox').prop('checked', false);
        $('#nomeEditHelpCad').html("")
        $('#emailEditHelpCad').html("");
        $('#emailEditHelpCad').html("");
        $('#planoEditHelpCad').html("");
        $('#vencimentoEditHelpCad').html("");
        $('#senhaEditHelpCad').html("");
        $('#nameHelpCad').html("");
        $('#emailHelpCad').html("");
        $('#emailHelpCad').html("");
        $('#planoHelpCad').html("");
        $('#vencimentoHelpCad').html("");
        $('#passHelpCad').html("");

    });
});

$(".toggle-password").click(function () {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

//Reseta os <small> em baixo de cada input
function resetHelper(id) {
    var id_do_small = id
    $('#' + id_do_small).text('')
}

listarEntregas();