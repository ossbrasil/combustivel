function executaTabelaAbs() {
    $('#Abstable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');
    $('#Abstable').DataTable({
        "scrollY": "600px",
        "scrollX": true,
        "order": [
            [0, "desc"]
        ],
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
        url: "./web_services/ws-abs.php/retornaAbs",
        success: function(data) {
            console.log(data);
            $('#Abstable').DataTable().destroy();
            $table = '';

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {

                var it = mydata[i];

                $table += "<tr>";

                $table += "<td class='th-sm text-center align-middle'>" + it.id + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.prefixo + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.placa + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.abastecimento_data + " " + it.abastecimento_hora + "</td>";

                $table += "<td class='th-sm text-center align-middle'>" + it.abastecimento_litros + "</td>";

                $table += "<td class='th-sm text-center align-middle'><button id=" + it.id + " onclick='modalInfo(this.id)' type='button' class='btn btn-primary p-2 editButton'><i class='fas fa-info fa-lg'></i></button>";

                $table += "<button id=" + it.id + " onclick='abrirmodalDeletar(this.id)' type='button' class='btn btn-danger p-2'><i class='fas fa-trash'></i></button></td>";

                $table += "</tr>";

            }
            $('#cadastroVeiculostable').html($table);
            executaTabelaAbs();

        }
    });
}

//puxa as informações para o modal de editar
function modalInfo(id) {

    $.ajax({
        type: "get",
        url: "./web_services/ws-abs.php/listarInfos/" + id,
        success: function(data) {

            var mydata = JSON.parse(data);
            var it = mydata[0];

            try {
                console.log(it);
                $('#infoFrentista').val(it.nomeFre);
                $('#infoVeiculo').val(it.modelo);
                $('#infoMotorista').val(it.nomeMot);
                $('#infoLitros').val(it.abastecimento_litros);
                $('#infoTipoComb').val(it.abastecimento_tipo_comb);
                $('#infoDtAbs').val(it.abastecimento_data);
                $('#infoHrAbs').val(it.abastecimento_hora);
                $('#infoVal').val(it.valor_total);
                $('#infoNF').val(it.nota_fiscal);
                $('#viewInfoAbs').modal('show');
                if (it.url_motorista == null && it.url_frentista == null) {
                    $('#imgs').html('');
                } else if (it.url_motorista == null) {
                    $('#imgs').html(`                        
                        <img style="width: auto; height: 250px;" src="
                        ${it.url_frentista}">`);
                } else if (it.url_frentista == null) {
                    $('#imgs').html(`                        
                        <img style="width: auto; height: 250px;" src="
                        ${it.url_motorista}">`);
                } else {
                    $('#imgs').html(`
                    
                        <img style="width: auto; height: 250px;" src="
                        ${it.url_motorista}">
                        
                        <img style="width: auto; height: 195px;"  src="
                        ${it.url_frentista}">`);
                }



            } catch (e) {
                Alert(e);
            }
        }
    });
}

listarAbs();
executaTabelaAbs();