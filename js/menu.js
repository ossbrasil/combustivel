function executaTabela1() {
    $('#Abstable').DataTable().destroy();
    $('.dataTables_length').addClass('bs-select');

    $('#Abstable').DataTable({
        "bLengthChange": false, //thought this line could hide the LengthMenu
        "bInfo": false,
        "searching": false,
        "scrollY": "350px",
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

function isEmpty(obj) {
    return Object.keys(obj).length === 0 && obj.constructor === Object;
}

function listarAbs() {
    //Conecta com o metodo get de listar usuários
    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/retornaAbs",
        success: function (data) {
            // console.log(data);
            $('#Abstable').DataTable().destroy();
            $table = '';

            if (data == false) {
                $table += `<tr>
                    <td class="th-sm text-center align-middle" colspan="5">SEM REGISTROS</td>
                </tr>`
                $('#cadastroVeiculostable').html($table);
                executaTabela1();
            } else {
                var mydata = JSON.parse(data);
                for (var i = 0; i < mydata.length; i++) {
                    var it = mydata[i];

                    $table += `<tr onclick="modalAbs(${it.id})">
                        <td class="th-sm text-center align-middle">${it.prefixo}</td>
                        <td class="th-sm text-center align-middle">${it.placa}</td>
                        <td class="th-sm text-center align-middle">${it.nomeMot}</td>
                        <td class="th-sm text-center align-middle">${it.abastecimento_tipo_comb}</td>
                        <td class="th-sm text-center align-middle">${it.abastecimento_litros}</td>
                        <td class="th-sm text-center align-middle">${it.abastecimento_data} ${it.abastecimento_hora}</td>
                    </tr>`;
                }
                $('#cadastroVeiculostable').html($table);
                executaTabela1();
            }
        }
    });
}

function addDays(date, daysToAdd, seven) {
    var _24HoursInMilliseconds = 86400000;
    return new Date(date.getTime() + daysToAdd * _24HoursInMilliseconds);
};

function LineChart() {
    var date = []
    var lb = [];
    var dados = []
    var i = 7;
    var d = 0;
    // for (i = 7; i < 0; i--) {
    //     date[i] = addDays(new Date(), i)
    // }

    while (i >= 0) {
        date[i] = addDays(new Date(), -d)
        d = d + 1;
        i = i - 1;
    }
    console.log(date);
    data = {
        "data": date
    }

    $.ajax({
        type: "PUT",
        data: JSON.stringify(data),
        url: "./web_services/ws-abs.php/retornaGrap",
        success: function (data) {
            // console.log(data);

            var mydata = JSON.parse(data);
            for (var i = 0; i < mydata.length; i++) {
                var it = mydata[i];
                if (it.soma == null) {
                    if (date[i].getDate() <= 9) {
                        lb[i] = "0" + date[i].getDate() + "/" + (date[i].getMonth() + 1);
                        dados[i] = 0;
                    } else {
                        lb[i] = date[i].getDate() + "/" + (date[i].getMonth() + 1);
                        dados[i] = 0;
                    }
                } else {
                    if (date[i].getDate() <= 9) {
                        lb[i] = "0" + date[i].getDate() + "/" + (date[i].getMonth() + 1);
                        dados[i] = it.soma;
                    } else {
                        lb[i] = date[i].getDate() + "/" + (date[i].getMonth() + 1);
                        dados[i] = it.soma;
                    }
                }
            }
            console.log(lb, dados)

            var ctx = document.getElementById('linechart');
            var linechart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: lb,
                    datasets: [{
                        label: 'Litros por dia',
                        data: dados,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            //data: data,
            //options: options
            //});
        }
    });
}

function BarChart() {
    var comb = ['GASOLINA', 'ETANOL', 'DIESEL'];
    var lb = [];
    var dados = [];

    $.ajax({
        type: "PUT",
        data: JSON.stringify(data),
        url: "./web_services/ws-abs.php/retornaGrap2",
        success: function (data) {
            //console.log(data);

            var mydata = JSON.parse(data);
            for (var i = 0; i < mydata.length; i++) {
                var it = mydata[i];

                if (it.soma == null) {
                    lb[i] = comb[i];
                    dados[i] = 0;
                } else {
                    lb[i] = comb[i];
                    dados[i] = it.soma;
                }

            }
            // console.log(dados)
            // console.log(lb)

            var ctx = document.getElementById('barchart');
            var barchart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: lb,
                    datasets: [{
                        label: ' Total de Litros',
                        data: dados,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            //data: data,
            //options: options
            //});
        }
    });
}
//}

function totalCarros() {
    var cont = 0;
    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro_veiculo.php/retornaVeiculos",
        success: function (data) {
            // console.log(data);

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {
                console.log("entrei", i);
                cont = cont + 1;
            }
            $('#totalCar').text(cont);
        }
    });
}

function totalAbs() {
    var cont = 0;
    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/retornaAbs",
        success: function (data) {
            // console.log(data);

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {
                // console.log("entrei", i);
                cont = cont + 1;
            }
            $('#totalAbs').text(cont);
        }
    });
}

function totalFunc() {
    var cont = 0;
    $.ajax({
        type: "GET",
        url: "./web_services/ws-cadastro_funcionarios.php/retornafuncionario",
        success: function (data) {
            // console.log(data);

            var mydata = JSON.parse(data);

            for (var i = 0; i < mydata.length; i++) {
                cont = cont + 1;
            }
            $('#totalFunc').text(cont);
        }
    });
}

function SpacingsModals() {
    $('.js-signature').addClass('notSigned')

    var sizing
    var screenSize = screen.width

    if (screenSize <= 360) {
        sizing = screenSize / 1.4
    } else if (screenSize <= 375) {
        sizing = screenSize / 1.3
    } else if (screenSize <= 641) {
        sizing = screenSize / 1.9
    } else if (screenSize <= 1070) {
        sizing = screenSize / 2.2
    } else if (screenSize <= 1280) {
        sizing = screenSize / 1.2
    } else if (screenSize <= 1366) {
        sizing = screenSize / 1.3
    } else if (screenSize <= 1440) {
        sizing = screenSize / 1.4
    } else if (screenSize <= 1920) {
        sizing = screenSize / 1.8
    }

    $('.js-signature').jqSignature({
        width: sizing,
        height: 300,
        lineColor: 'black',
        lineWidth: 3
    });
}

function modalGasolina() {
    clearCanvas()
    $('#EditarValorG').mask('#.##0.00', { reverse: true });
    $('#EditarNotaG').mask('##.000', { reverse: true });
    $('#modalGasolina').modal('show');
    $('#canvasModalGas').removeClass('d-none');
    $('#imagemModalGas').addClass('d-none');
    $('#EditarQuantGasolina').val('');
    $('#EditarNotaG').val('');
    $('#EditarValorG').val('');
    SpacingsModals();
}

function modalEtanol() {
    clearCanvas()
    $('#EditarValorE').mask('#.##0.00', { reverse: true });
    $('#EditarNotaE').mask('##.000', { reverse: true });
    $('#modalEtanol').modal('show');
    $('#canvasModalEta').removeClass('d-none');
    $('#imagemModalEta').addClass('d-none');
    $('#EditarQuantEtanol').val('');
    $('#EditarNotaE').val('');
    $('#EditarValorE').val('');
    SpacingsModals();
}

function modalDiesel() {
    clearCanvas()
    $('#EditarValorD').mask('#.##0.00', { reverse: true });
    $('#EditarNotaD').mask('##.000', { reverse: true });
    $('#modalDiesel').modal('show');
    $('#canvasModalDie').removeClass('d-none');
    $('#imagemModalDie').addClass('d-none');
    $('#EditarQuantDiesel').val('');
    $('#EditarNotaD').val('');
    $('#EditarValorD').val('');
    SpacingsModals();
}

function modalAbs(id) {
    modalInfo(id)
    $('#viewInfoAbs').modal('show');
}

function modalInfo(id) {
    $.ajax({
        type: "GET",
        url: "./web_services/ws-abs.php/listarInfos/" + id,
        success: function(data) {
            var mydata = JSON.parse(data);
            var it = mydata[0];

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
                $('#imgs').html(`<img style="width: auto; height: 250px;" src="${it.url_frentista}">`);
            } else if (it.url_frentista == null) {
                $('#imgs').html(`<img style="width: auto; height: 250px;" src="${it.url_motorista}">`);
            } else {
                $('#imgs').html(`
                <img style="width: auto; height: 250px;" src="${it.url_motorista}">
                <img style="width: auto; height: 195px;" src="${it.url_frentista}">`);
            }
        }
    });
}

function signatureStart() {
    $('.js-signature').removeClass('notSigned')
}

function clearCanvas() {
    $('.js-signature').jqSignature('clearCanvas')
    // $('.js-signature').addClass('notSigned')
}

$("#btnGasSave").click(function () {
    if ($('#EditarQuantGasolina').val() < 1) {
        $('#gasolinaHelpCad').text('Valor inválido')
    } else {
        data = {
            "tp": "Gasolina",
            "ass": $('#assinaturaGas').jqSignature('getDataURL'),
            "quant": $('#EditarQuantGasolina').val(),
            "nota": $('#EditarNotaG').val(),
            "valor": $('#EditarValorG').val()
        }

        $.ajax({
            type: "PUT",
            url: "./web_services/ws-abs.php/ass/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (data) {
                // console.log(data);
                $('#modalGasolina').modal('hide');
                $('#EditadoComSucesso').modal('show');
                LineChart();
                listarAbs();
                totalAbs();
                totalFunc();
                totalCarros();
                BarChart();
                totalComb()
            }
        });
    }
});

$("#btnEtaSave").click(function () {
    if ($('#EditarQuantEtanol').val() < 1) {
        $('#etanolHelpCad').text('Valor inválido')
    } else {
        data = {
            "tp": "Etanol",
            "ass": $('#assinaturaEta').jqSignature('getDataURL'),
            "quant": $('#EditarQuantEtanol').val(),
            "nota": $('#EditarNotaE').val(),
            "valor": $('#EditarValorE').val()
        }

        $.ajax({
            type: "PUT",
            url: "./web_services/ws-abs.php/ass/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (data) {
                // console.log(data);
                $('#modalEtanol').modal('hide');
                $('#EditadoComSucesso').modal('show');
                LineChart();
                listarAbs();
                totalAbs();
                totalFunc();
                totalCarros();
                BarChart();
                totalComb()
            }
        });
    }
});

$("#btnDieSave").click(function () {
    if ($('#EditarQuantDiesel').val() < 1) {
        $('#dieselHelpCad').text('Valor inválido')
    } else {
        data = {
            'tp': "Diesel",
            'ass': $('#assinaturaDie').jqSignature('getDataURL'),
            'quant': $('#EditarQuantDiesel').val(),
            'nota': $('#EditarNotaD').val(),
            'valor': $('#EditarValorD').val()
        }

        $.ajax({
            type: "PUT",
            url: "./web_services/ws-abs.php/ass/",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (data) {
                // console.log(data);
                totalComb();
                $('#modalDiesel').modal('hide');
                $('#EditadoComSucesso').modal('show');
                LineChart();
                listarAbs();
                totalAbs();
                totalFunc();
                totalCarros();
                BarChart();
                totalComb()
            }
        });
    }
});

function totalComb() {
    var cont = 0;
    $.ajax({
        type: "PUT",
        url: "./web_services/ws-abs.php/consCombs",
        success: function (data) {
            var mydata = JSON.parse(data);
            // console.log(mydata);
            $("#totalGasolina").text(mydata[2].quantidade_atual + " L");
            $("#totalEtanol").text(mydata[5].quantidade_atual + " L");
            $("#totalDiesel").text(mydata[8].quantidade_atual + " L");

            total = mydata[1].quantidade_total
            atual = mydata[2].quantidade_atual;

            total2 = mydata[4].quantidade_total
            atual2 = mydata[5].quantidade_atual;

            total3 = mydata[7].quantidade_total
            atual3 = mydata[8].quantidade_atual;

            var vp1 = ((total - atual) / total) * 100;
            var vp2 = ((total2 - atual2) / total2) * 100;
            var vp3 = ((total3 - atual3) / total3) * 100;

            // console.log(vp1);
            $("#pGas").text(parseFloat(vp1.toFixed(2)) + "% utilizado de " + mydata[1].quantidade_total + "L");
            document.getElementById("prGas").style.width = vp1 + "%";
            $("#pEtanol").text(parseFloat(vp2.toFixed(2)) + "% utilizado de " + mydata[4].quantidade_total + "L");
            document.getElementById("prEtanol").style.width = vp2 + "%";
            $("#pDies").text(parseFloat(vp2.toFixed(2)) + "% utilizado de " + mydata[7].quantidade_total + "L");
            document.getElementById("prDies").style.width = vp3 + "%";

            if (vp1 <= 59) {
                $("#prGas").addClass('bg-sucess')
            } else if (vp1 >= 60 && vp1 <= 79) {

                $("#prGas").removeClass('bg-sucess')
                $("#prGas").addClass('bg-warning')
            } else {
                $("#prGas").removeClass('bg-sucess')
                $("#prGas").removeClass('bg-warning')
                $("#prGas").addClass('bg-danger')
            }

            if (vp2 <= 59) {
                $("#prEtanol").addClass('bg-sucess')
            } else if (vp2 >= 60 && vp2 <= 79) {

                $("#prEtanol").removeClass('bg-sucess')
                $("#prEtanol").addClass('bg-warning')
            } else {
                $("#prEtanol").removeClass('bg-sucess')
                $("#prEtanol").removeClass('bg-warning')
                $("#prEtanol").addClass('bg-danger')
            }

            if (vp3 <= 59) {
                $("#prDiesel").addClass('bg-sucess')
            } else if (vp3 >= 60 && vp3 <= 79) {
                $("#prDiesel").removeClass('bg-sucess')
                $("#prDiesel").addClass('bg-warning')
            } else {
                $("#prDiesel").removeClass('bg-sucess')
                $("#prDiesel").removeClass('bg-warning')
                $("#prDiesel").addClass('bg-danger')
            }
        }
    });
}

LineChart();
listarAbs();
totalAbs();
totalFunc();
totalCarros();
BarChart();
totalComb()