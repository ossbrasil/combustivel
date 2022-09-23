var id;
var dataURI;

function executaTabela1() {
    $('#Abstable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');

    $('#Abstable').DataTable({
        "bLengthChange": false, //thought this line could hide the LengthMenu
        "bInfo": false,
        "searching": false,
        "scrollY": "400px",
        "scrollX": true,
        "bPaginate": false,
        "scrollCollapse": true,
        "language": {
            "info": "Exibindo pagina _PAGE_ de _PAGES_",
            "emptyTable": "Não foram encontrados registros",
            "infoEmpty": "",
            "sZeroRecords": "Não foram encontrados registros",
            "infoFiltered": "",
            "info": "",
            "sLengthMenu": "",
            "search": "Buscar",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior"
            }
        }
    });
}


function checkAbs() {
    document.querySelector("#menu").style.setProperty("display", "none", "important");
    // document.querySelector("#dadosCheck").style.setProperty("display", "show", "important");
    $("#dadosCheck").removeClass('d-none');

    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro_funcionarios.php/retornafuncQR/",
        success: function(data) {
                if (data != null) {
                    console.log(data);
                    new QRCode(document.getElementById('qrcode'), data);
                    $("#carSelect").addClass('d-none');
                    $('#qrCheck').removeClass('d-none');
                }
            } ///
    });
}

function listarAbs() {
    document.querySelector("#menu").style.setProperty("display", "none", "important");
    // document.querySelector("#dadosCheck").style.setProperty("display", "show", "important");
    $("#listarAbs").removeClass('d-none');

    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/retornaAbsFunc/" + 1,
        success: function(data) {

            $('#Abstable').DataTable().destroy();
            $table = '';


            if (data == false) {

                $table += "<tr>";
                $table += "<td class='th-sm text-center align-middle' colspan='5'>" + "SEM REGISTROS" + "</td>";
                $('#cadastroVeiculostable').html($table);
                executaTabela1();
            } else {
                var mydata = JSON.parse(data);
                for (var i = 0; i < mydata.length; i++) {
                    var color = 'table-success'
                    var it = mydata[i];
                    var aux = false
                    if (it.url_motorista == '' || it.url_motorista == null) {
                        color = 'table-danger'
                        aux = true;
                    } else {
                        color = 'table-success'
                    }
                    console.log(it)
                    $table += `<tr class= '${color}' onclick='abrirModalFoto(${it.id},${aux})'>`;

                    $table += "<td class='th-sm text-center align-middle'>" + it.placa + "</td>";

                    $table += "<td class='th-sm text-center align-middle'>" + it.abastecimento_tipo_comb + "</td>";

                    $table += "<td class='th-sm text-center align-middle'>" + it.abastecimento_litros + "</td>";

                    $table += "<td class='th-sm text-center align-middle'>" + it.abastecimento_hora + "</td>";

                    $table += "</tr>";

                }
                $('#cadastroVeiculostable').html($table);
                executaTabela1();
            }

        }
    });
}

function resetModal() {
    document.location.reload(true);
}



function abrirModalFoto(i, aux) {

    id = i;
    if (aux == true) {
        var video = document.querySelector("#cam3");
        $('#listarAbs').addClass('d-none')
        $('#snap').removeClass('d-none')
        $('#textQR').text('Tire uma foto!');
        $('#textBody').text('Capture uma foto do Painel do Veículo, mostrando o Odômetro e a Litragem no Tanque');
        video.setAttribute('autoplay', '');
        video.setAttribute('muted', '');
        video.setAttribute('playsinline', '');
        //--
        // //Verifica se o navegador pode capturar mídia

        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ audio: false, video: { facingMode: 'environment' } })
                .then(function(stream) {
                    // $('#modalCarregar').modal('hide');
                    $('#tirarFoto').modal({ backdrop: 'static', keyboard: false })
                        //Definir o elemento vídeo a carregar o capturado pela webcam
                    video.srcObject = stream;
                })
                //             //Quando não encontrar uma web-cam disponível
                .catch(function(error) {
                    // $('#modalCarregar').modal('hide');
                    // $('#tirarFoto').modal('hide');
                    // alert("Não foi detectado uma Web-cam.");
                });
        }
    }

}

function confirmSnap() {

    var video = document.querySelector("#cam3");
    console.log(video.videoWidth);
    //  //Criando um canvas que vai guardar a imagem temporariamente
    var canvas = document.createElement('canvas');

    canvas.width = 595;
    canvas.height = 842;
    var ctx = canvas.getContext('2d');

    ////Desenhando e convertendo as dimensões
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // //Criando o JPG

    dataURI = canvas.toDataURL('image/png', 1); //O resultado é um BASE64 de uma imagem.
    console.log(dataURI)

    data = {
        'url': dataURI,
        'id': id
    }
    $.ajax({
        type: "PUT",
        url: "./web_services/ws-abs.php/confirmAbsMot/",
        data: JSON.stringify(data),
        success: function(data) {
            $('#snap').addClass('d-none')
            listarAbs()
        }
    });
}

function confirmCar() {
    var placa = $('#placa').text();
    $.ajax({
        type: "PUT",
        url: "./web_services/ws-abs.php/gerarAbs/" + placa,
        success: function(data) {
                if (data != null) {
                    new QRCode(document.getElementById('qrcode'), data);
                    $("#carSelect").addClass('d-none');
                    $("#selectPlaca").addClass('d-none');
                    $('#textHead').text('Veículo da Placa: ' + placa);
                    $('#textFoot').text('Mostre esse código ao frentista para validar o abastecimento');
                }


            } ///
    });

    //$("#dadosCheck").hide();
}



//Retorna a Placa de Todos os Veículos ao Abrir Modar de Adicionar OS
function carregaVeiculos() {
    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/listaPlacaVeiculo",
        success: function(data) {
            //Escreve o Select das Placas dos Carros
            var mydata = JSON.parse(data);
            $dropElement = '';
            for (var i = 0; i < mydata.length; i++) {
                var it = mydata[i];
                $dropElement += "<a class=\"d-block\" id=" + it.placa + " onclick=\"infoVeiculo(this.id)\">" + it.placa + "</a>";
            }
            $('#placasFiltro').html($dropElement);
        }
    });
}

function infoVeiculo(id) {
    $("#carSelect").removeClass('d-none');
    valorPlaca = id
    $('#dropName').html(id)
    if (id == 0) {
        //Caso não existe opção Selecionado, é executado a função que reseta o modal
        resetModal();
    } else {
        //Limpa os campos do modal antes de carregar os novos dados
        //resetModal();
        $.ajax({
            type: "GET",
            url: "./web_services/ws-abs.php/retorna/" + id,
            success: function(data) {
                    //Carrega os dados e Ativa os Campos
                    var mydata = JSON.parse(data);
                    console.log(mydata);
                    $('#placa').text(id);
                    $('#texto').text("Prefixo: " + mydata[0].prefixo +
                        " Marca:" + mydata[0].marca + " Modelo: " + mydata[0].modelo + " Ano: " + mydata[0].ano + " Combustível: " + mydata[0].combustivel);

                } ///
        });
    }
}