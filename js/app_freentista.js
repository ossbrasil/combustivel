var idCar;
var idMot;
var tpComb;
var litro;
var km;
var ultKm;
var qDia;
var total;
var val;
var nota;
var dataURI;
var scanner;
$("#cam2").addClass('d-none');
$("#cam3").addClass('d-none');

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
            "info": "Exibindo página _PAGE_ de _PAGES_",
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
    scan(1);
    $("#dadosCheck").removeClass('d-none');
    $('#textQR').text('Digitaliza o QR-Code do Carro');
    $('#textBody').text('Aponte a câmera no QR-Code localizado no para-brisa do veículo e aguarde o processamento');
}

function listarAbs() {
    document.querySelector("#menu").style.setProperty("display", "none", "important");
    // document.querySelector("#dadosCheck").style.setProperty("display", "show", "important");
    $("#listarAbs").removeClass('d-none');

    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/retornaAbsFunc/" + 2,
        success: function (data) {
            console.log(data);
            $('#Abstable').DataTable().destroy();
            $table = '';

            if (data == false) {
                $table += `<tr>
                    <td class="th-sm text-center align-middle" colspan="5">SEM REGISTROS</td>`;
                $('#cadastroVeiculostable').html($table);
                executaTabela1();
            } else {
                var mydata = JSON.parse(data);
                for (var i = 0; i < mydata.length; i++) {
                    var it = mydata[i];

                    $table += `<tr>
                        <td class="th-sm text-center align-middle">${it.placa}</td>
                        <td class="th-sm text-center align-middle">${it.abastecimento_tipo_comb}</td>
                        <td class="th-sm text-center align-middle">${it.abastecimento_litros}</td>
                        <td class="th-sm text-center align-middle">${it.abastecimento_hora}</td>
                    </tr>`;
                }
                $('#cadastroVeiculostable').html($table);
                executaTabela1();
            }
        }
    });
}

//Retorna a Placa de Todos os Veículos ao Abrir Modar de Adicionar OS
function carregaVeiculos() {
    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/listaPlacaVeiculo",
        success: function (data) {
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

function resetModal() {
    document.location.reload(true);
}

// function infoVeiculo(id) {
//     $("#carSelect").removeClass('d-none');
//     valorPlaca = id
//     $('#dropName').html(id)
//     if (id == 0) {
//         //Caso não existe opção Selecionado, é executado a função que reseta o modal
//         resetModal();
//     } else {
//         //Limpa os campos do modal antes de carregar os novos dados
//         //resetModal();
//         $.ajax({
//             type: "GET",
//             url: "./web_services/ws-abs.php/retorna/" + id,
//             success: function(data) {
//                     //Carrega os dados e Ativa os Campos
//                     var mydata = JSON.parse(data);
//                     console.log(mydata);
//                     $('#placa').text(id);
//                     $('#texto').text("Prefixo: " + mydata[0].prefixo +
//                         " Marca:" + mydata[0].marca + " Modelo: " + mydata[0].modelo + " Ano: " + mydata[0].ano + " Combustível: " + mydata[0].combustivel);

//                 } ///
//         });
//     }
// }

// function filtroPlacas() {
//     var input, filter, ul, li, a, i;
//     input = $("#inputFiltro");
//     filter = input.val().toUpperCase();
//     div = $("#placasFiltro");
//     a = $("#placasFiltro a");
//     for (i = 0; i < a.length; i++) {
//         txtValue = a[i].textContent || a[i].innerText;
//         if (txtValue.toUpperCase().indexOf(filter) > -1) {
//             a[i].style.display = "block";
//         } else {
//             a[i].style.display = "none";
//         }
//     }
// }

function scan(t) {
    console.log(t)
    scanner = new Instascan.Scanner({
        video: document.getElementById('cam'),
        scanPeriod: 5,
        mirror: false,
    });
    console.log(scanner)

    Instascan.Camera.getCameras().then(cameras => {
        var selectedCamera;
        if (cameras.length > 0) {
            for (let c = 0; c < cameras.length; c++) {
                console.log(cameras[c])
                if (cameras[c].name.indexOf('back') != -1) {
                    selectedCamera = cameras[c];
                }
            }
            console.log(cameras.length)
            // console.log(selectedCamera)
            if (selectedCamera) {
                scanner.start(cameras[1]);
            } else {
                scanner.start(cameras[0]);
                console.error("Não há cameras back.");
            }
        }

        console.log(t)

        scanner.addListener('scan', content => {
            console.log(content);
            console.log(t);
            if (content != null) {
                if (t == 1) {
                    checkCarQR(content, scanner);
                } else {
                    checkMotQR(content);
                }
            }
        })
    });
}

function checkMotQR(content) {
    idMot = content;
    $.ajax({
        type: "PUT",
        url: "./web_services/ws-abs.php/consMot/" + content,
        success: function (data) {
            console.log(data);
            if (data == '' || data == null || data == 'false' || data == false) {
                $("#modalAlerta").modal('show');
                $('#menssagemAlerta').text('QR-Code Inválido ou motorista indisponível')
            } else {
                $("#divCam").addClass('d-none');
                $("#motSelect").removeClass('d-none');
                $("#carSelect").removeClass('d-none');
                //Carrega os dados e Ativa os Campos
                var mydata = JSON.parse(data);
                console.log(mydata);
                $('#motNome').text(mydata[0].nome);
                $('#texto').text("");
                let st = 1;
            }
        }
    });
}

function confirmCar() {
    km = $('#cadastrarKM').val();
    ultKm = parseInt(ultKm);
    qDia = parseInt(qDia);
    console.log(km, ultKm);
    console.log($("#cadastrarComb").val());
    if ($('#cadastrarLitros').val() < 1 || $('#cadastrarLitros').val() >= qDia) {
        $("#modalAlerta").modal('show');
        $('#menssagemAlerta').text('Verifique o campo Litros')
        $('#ltHelpCad').html('Valor máximo: ' + qDia);
    } else {
        if ($('#cadastrarKM').val() == 0 || $('#cadastrarKM').val() <= ultKm) {
            $("#modalAlerta").modal('show');
            $('#menssagemAlerta').text('Verifique o campo KM')
            $('#ltHelpCad').html('');
            $('#kmHelpCad').html('Valor mínimo: ' + (ultKm + 1));
            console.log(km, ultKm);
        } else {
            if ($("#cadastrarComb").val == null) {
                $("#modalAlerta").modal('show');
                $('#menssagemAlerta').text('Verifique o campo Combustível')
            } else {
                if ($('#cadastrarVal').val() == null || $('#cadastrarVal').val() <= 0) {
                    $("#modalAlerta").modal('show');
                    $('#menssagemAlerta').text('Verifique o campo Valor(R$)');
                } else {
                    if ($('#cadastrarVal').val() == null) {
                        $("#modalAlerta").modal('show');
                        $('#menssagemAlerta').text('Verifique o campo da Nota ');
                    } else {
                        km = $('#cadastrarKM').val();
                        litro = $('#cadastrarLitros').val();
                        tpComb = $('#cadastrarComb').val();
                        val = $('#cadastrarVal').val();
                        nota = $('#cadastrarComb').val();
                        // $("#cam").addClass('d-none')
                        $("#carSelect").addClass('d-none');
                        $("#qrCheck").addClass('d-none');
                        $('#cadastrarLitros').attr('disabled', true);
                        $("#cadastrarKM").attr('disabled', true);
                        $("#cadastrarNota").attr('disabled', true);
                        $("#cadastrarVal").attr('disabled', true);
                        $("#divCam").removeClass('d-none');
                        $("#btnSnap").removeClass('d-none');
                        // $('#textQR').text('Digitaliza o QR-Code do Motorista');
                        $('#textQR').text('Tire uma foto da Bomba de Combustível ou da NF');
                        $('#textBody').text('Enquadre na foto o valor e a quantidade de litro no abastecimento');
                        $("#cir2").addClass('bg-success');
                        $("#cir2").removeClass('blue');
                        $("#cir3").removeClass('bg-light');
                        $("#cir3").addClass('blue');
                        // abrirModalFoto()
                        // scan(2);
                    }
                }
            }
        }
    }
}

function abrirModalFoto() {
    // $('#modalCarregar').modal('show');
    // $("#imageP").html('');
    // Captura elemento de vídeo
    var video = document.querySelector("#cam");

    video.setAttribute('autoplay', '');
    video.setAttribute('muted', '');
    video.setAttribute('playsinline', '');
    //--
    // Verifica se o navegador pode capturar mídia

    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ audio: false, video: { facingMode: 'environment' } })
            .then(function (stream) {
                // $('#modalCarregar').modal('hide');
                $('#tirarFoto').modal({ backdrop: 'static', keyboard: false })
                // Definir o elemento vídeo a carregar o capturado pela webcam
                video.srcObject = stream;
            })
            // Quando não encontrar uma web-cam disponível
            .catch(function (error) {
                // $('#modalCarregar').modal('hide');
                // $('#tirarFoto').modal('hide');
                // alert("Não foi detectado uma Web-cam.");
            });
    }
}

function confirmSnap() {
    $("#cir3").addClass('bg-success');
    $("#cir3").removeClass('blue');
    $("#cir4").removeClass('bg-light');
    $("#cir4").addClass('blue');
    var video = document.querySelector("#cam");
    console.log(video.videoWidth);
    // Criando um canvas que vai guardar a imagem temporariamente
    var canvas = document.createElement('canvas');

    canvas.width = 595;
    canvas.height = 842;
    var ctx = canvas.getContext('2d');

    // Desenhando e convertendo as dimensões
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Criando o JPG

    dataURI = canvas.toDataURL('image/png', 1); //O resultado é um BASE64 de uma imagem.
    // console.log(dataURI)
    scanner.stop()
    // video.stop();
    $("#btnSnap").addClass('d-none');
    // $("#cam3").addClass('d-none');
    $("#cam").removeClass('d-none');
    $('#textQR').text('Digitaliza o QR-Code do Motorista');
    $('#textBody').text('Solicite ao motorista para mostrar o QR-Code, após isso aponte a câmera e aguarde o processamento');
    video.srcObject.getTracks().forEach(function (track) {
        track.stop();
    });
    video.srcObject = null
    scan(2);
}

function confirmAbs() {
    console.log("Entrei");
    $("#cadastrarComb").val('2');
    if (tpComb == 1) {
        tpComb = "Gasolina";
    } else if (tpComb == 2) {
        tpComb = "Etanol";
    } else {
        tpComb = "Diesel";
    }

    var data = {
        "url": dataURI,
        "km": km,
        "comb": tpComb,
        "litro": litro,
        "idMot": idMot,
        "idCar": idCar,
        "nota": nota,
        "val": val
    };
    console.log(data);
    $.ajax({
        type: "PUT",
        url: "./web_services/ws-abs.php/gerarAbs/",
        data: JSON.stringify(data),
        success: function (data) {
            console.log(data);
            $('#criadoComSucesso').modal('show');
        }
    });

    $("#dadosCheck").addClass('d-none');
    $("#menu").show();
}

function checkCarQR(content, scanner) {
    idCar = content;
    $.ajax({
        type: "PUT",
        url: "./web_services/ws-abs.php/consCar/" + content,
        success: function (data) {
            $("#cir1").addClass('bg-success');
            $("#cir1").removeClass('blue');
            $("#cir2").removeClass('bg-light');
            $("#cir2").addClass('blue');
            $('#cadastrarVal').mask('#.##0.00', { reverse: true });
            $('#cadastrarNota').mask('##.000', { reverse: true });
            if (data != false) {
                $("#divCam").addClass('d-none');
                $("#carSelect").removeClass('d-none');
                //Carrega os dados e Ativa os Campos
                var mydata = JSON.parse(data);
                console.log(mydata);
                $('#placa').text(mydata[0].placa);
                $('#texto').text("Prefixo: " + mydata[0].prefixo +
                    " Marca: " + mydata[0].marca + " Modelo: " + mydata[0].modelo + " Ano: " + mydata[0].ano);
                ultKm = mydata[0].km;
                $("#cadastrarComb").attr('disabled', true);
                console.log(ultKm);
                if (mydata[0].combustivel == 'Gasolina') {
                    $("#cadastrarComb").val('1');
                } else if (mydata[0].combustivel == 'Etanol') {
                    $("#cadastrarComb").val('2');
                } else if (mydata[0].combustivel == 'Diesel') {
                    $("#cadastrarComb").val('3');
                } else {
                    $("#cadastrarComb").val('1');
                    $("#cadastrarComb").removeAttr('disabled');
                    $("#labelComb").html('Selecione o Combustível (Carro Flex)');
                }

                qDia = mydata[0].limit_dia;
                total = mydata[0].limit_tanque;
                console.log(qDia);
                // $("#cam").addClass('d-none')
                // scanner.stop()
            } else {
                $("#modalAlerta").modal('show');
                $('#menssagemAlerta').text('QR-Code Inválido ou carro indisponível')
            }
        }
    });
}