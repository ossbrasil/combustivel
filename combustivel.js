function executaTabelaAbs() {
    $('#Abstable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#Abstable').DataTable({
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


function listarAbs() {
    //Conecta com o metodo get de listar usuários
    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/retornaCombs",
        success: function(data) {
            console.log(data);
            $('#Abstable').DataTable().destroy();
            $table = '';

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {

                var it = mydata[i];

                $table += "<tr>";

                $table += "<td class='th-sm text-center align-middle'>" + it.tipo + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.quantidade_total + " Litro(s) </td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.quantidade_atual + " Litro(s) </td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.data + " " + it.hora + "</td>";

                $table += "<td class='th-sm text-center align-middle'><button id=" + it.id + " onclick='modalInfo(this.id)' type='button' class='btn btn-primary p-2 editButton'><i class='fas fa-info fa-lg'></i></button>";

                //$table += "<button id=" + 1 + " onclick='abrirmodalDeletar(this.id)' type='button' class='btn btn-danger p-2'><i class='fas fa-trash'></i></button></td>";

                $table += "</tr>";

            }
            $('#cadastroVeiculostable').html($table);
            executaTabelaAbs();

        }
    });
}

//puxa as informações para o modal de editar
function modalInfo(id) {
    $('#viewInfoAbs').modal('show');

    $.ajax({
        type: "get",
        url: "./web_services/ws-abs.php/infoCombs/" + id,
        success: function(data) {
            console.log(data)
            var mydata = JSON.parse(data);
            var it = mydata[0];

            try {
                $('#infoTipoComb').val(it.tipo);
                $('#infoQT').val(it.quantidade_total);
                $('#infoData').val(it.data);
                $('#infoHora').val(it.hora);
                $('#infoVal').val(it.valor);
                $('#infoNF').val(it.nota_fiscal);

                if (it.assinatura == null) {
                    $('#imgs').html(``);
                } else {
                    $('#imgs').html(`
                    
                        <img class="img-fluid" src="
                        ${it.assinatura}">`);
                }

            } catch (e) {
                Alert(e);
            }
        }
    });
}

listarAbs();
executaTabelaAbs();