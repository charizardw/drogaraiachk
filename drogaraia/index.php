<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>#OPChecker#</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(45deg, #f2f2f2 25%, #ffffff 25%, #ffffff 50%, #f2f2f2 50%, #f2f2f2 75%, #ffffff 75%, #ffffff 100%);
            background-size: 20px 20px;
        }

        textarea:hover, input:hover, textarea:active, input:active, textarea:focus, input:focus {
            outline: none;
        }

        button:focus {
            outline: none;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: black;
        }

        ::-webkit-scrollbar-thumb {
            background: blue;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: blue;
        }

        /* Adicione seus estilos CSS aqui, se necessário */
        .result-box {
            height: 200px;
            width: 650px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 0;
            font-size: 12px; /* Letras pequenas */
            text-align: left; /* Alinhamento à esquerda */
            margin-right: 10px; /* Espaço na margem direita */
            background-color: #f2f2f2; /* Cor cinza claro */
        }

        .result-title {
            text-align: center;
        }

        /* Alinhamento centralizado dos botões */
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <center>
        <div id="cor">
            <br>
            <h1><span class="badge badge-pill badge-info">OPChecker</span></h1>
            <h4><span class="badge badge-warning">Drogaraia + Pedidos</span></h4>
        </div>
    </center>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <hr>
                    <input type="text" class="form-control round" id="token" disabled style="width: 100%; height: 30px; border: auto 1px #0078FF; overflow: auto; resize: none;" placeholder="TOKEN [USA]">
                    <input type="text" class="form-control round" id="tokendois" disabled style="width: 100%; height: 30px; border: auto 1px #0078FF; overflow: auto; resize: none;" placeholder="TOKEN [BR]">
                    <hr>
                    <textarea id="lista" name="lista" class="form-control" style="width: 100%; height: 100px; border: auto 1px #0078FF; text-align: center; overflow: auto; resize: none;" placeholder="4444000000000000|00|0000|000"></textarea>
                </div>
                <div class="progress">
                    <div id="progresstest" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
                <div>
                    <font color="black">
                        <b>Aprovadas: </b><span id="cLive" class="badge badge-pill badge-success">0</span> -
                        <b>Reprovadas: </b><span id="cDie" class="badge badge-pill badge-danger">0</span> -
                        <b>Testadas: </b><span id="testadas" class="badge badge-pill badge-info">0</span> -
                        <b>Total </b><span id="total" class="badge badge-pill badge-secondary">0</span>
                    </font>
                    <hr>
                </div>
                <div class="btn-container">
                    <button class="btn btn-outline-primary" style="outline: none;" id="iniciarchk">✅ Iniciar</button>
                    <button disabled class="btn btn-outline-primary" style="outline: none;" id="pararchk">🛑 Parar</button>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="result-title"><span class="badge badge-pill badge-success">APROVADAS</span></h3>
                <div class="result-box aprovadas"></div>
                <hr>
                <h3 class="result-title"><span class="badge badge-pill badge-danger">REPROVADAS</span></h3>
                <div class="result-box reprovadas"></div>
            </div>
        </div>
    </div>
</body>

</html>












<script>

$(document).ready(function () {
    var i = 1;
    $('#iniciarchk').attr('disabled', null);

    $('#iniciarchk').click(function () {
        if (!$('#lista').val().trim()) {
            $('#status_ccs').html(
                Swal.fire({
                    title: '<span style="color:#8C91B6">Aviso<span>',
                    icon: 'warning',
                    confirmButtonColor: "#AE7AF3",
                    background: '#1D203F',
                    html: '<span style="color:#8C91B6">Insira uma lista para começarmos.<span>'
                })
            );
        } else {
            var line = $('#lista').val().replace(',', '').split('\n');
            line = line.filter(function (item, index, inputArray) {
                return inputArray.indexOf(item) == index;
            });

            var token = $('#token').val();
            var tokendois = $('#tokendois').val();
            var total = line.length;
            var ap = 0;
            var rp = 0;
            var ts = 0;
            var st = 'Aguardando...';
            var testador = $("#SelectOptions option:selected").val();
            $('#total').html(total);
            $('#status_ccs').html(st);
            $("#lista").val(line.join("\n"));
            $('#lista').attr('disabled', 'disabled');
            $('#SelectOptions').attr('disabled', 'disabled');

            line.forEach(function (value) {
                if (value == "") {
                    removelinha();
                    return;
                }

                var ajaxCall = $.ajax({
                    url: 'api.php',
                    type: 'GET',
                    data: 'lista=' + value + '&token=' + token + '&tokendois=' + tokendois,
                    async: true,
                    beforeSend: function () {
                        $('#pararchk').attr('disabled', null);
                        $('#iniciarchk').attr('disabled', 'disabled');
                        $('#SelectOptions').attr('disabled', 'disabled');
                        var st = 'Testando...';
                        $('#status_ccs').html(st);
                    },
                    success: function (data) {
                        if (data.match("#Aprovada")) {
                            ap = ap + 1;
                            ts = ts + 1;
                            Swal.fire({
                                title: '<span style="color:#8C91B6">+1 Aprovada!<span>',
                                icon: 'success',
                                background: '#1D203F',
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end',
                                timer: 3000
                            });
                            aprovadas(data + "");
                            removelinha();
                        } else if (data.match("#ipduplo")) {
                            Swal.fire({
                                title: '<span style="color:#8C91B6">Acessou em outro local<span>',
                                icon: 'warning',
                                confirmButtonColor: "#AE7AF3",
                                background: '#1D203F',
                                html: '<span style="color:#ffffff"> <b> Proibido acesso multiplos. </b></span><br> <span style="color:#ffffff"> <b> Sua Lista foi apagada, seus testes não foram salvos. </b></span> Redirecionando ...'
                            })
                            ajaxCall.abort();
                            limpar();
                            setTimeout(function () {
                                window.location.href = "acessoduplo.php";
                            }, 3500);
                        } else {
                            rp = rp + 1;
                            ts = ts + 1;
                            reprovadas(data + "");
                            removelinha();
                        }

                        var fila = parseInt(ap) + parseInt(rp);
                        $('#cLive').html(ap);
                        $('#cDie').html(rp);
                        $('#testadas').html(fila);

                        porcentagem(total, fila);

                        if (fila == total) {
                            $('#iniciarchk').attr('disabled', null);
                            $('#pararchk').attr('disabled', 'disabled');
                            $('#lista').attr('disabled', null);
                            $('#SelectOptions').attr('disabled', null);
                            var st = 'Finalizado';
                            Swal.fire({
                                title: '<span style="color:#8C91B6">Finalizado<span>',
                                icon: 'success',
                                confirmButtonColor: "#AE7AF3",
                                background: '#1D203F',
                                html: '<span style="color:#8C91B6">Sua lista foi testada com sucesso<span>'
                            })
                            $('#status_ccs').html(st);
                        }
                    }
                });

                $('#pararchk').click(function () {
                    ajaxCall.abort();
                    $('#iniciarchk').attr('disabled', null);
                    $('#pararchk').attr('disabled', 'disabled');
                    $('#lista').attr('disabled', null);
                    $('#SelectOptions').attr('disabled', null);
                    var st = 'Pausado...';
                    $('#status_ccs').html(st);
                });
            });
        }
    });
});

function limpar() {
    document.getElementById("lista").value = "";
}

function porcentagem(total, pctm) {
    var porcentagem = (pctm / total) * 100 + "%";
    var el = document.getElementById("progresstest");
    el.style.width = porcentagem;
}

function aprovadas(str) {
    $(".aprovadas").append(str + "<br>");
}

function reprovadas(str) {
    $(".reprovadas").append(str + "<br>");
}

function error(str) {
    $(".error").append(str + "<br>");
}

function removelinha() {
    var lines = $("#lista").val().split('\n');
    lines.splice(0, 1);
    $("#lista").val(lines.join("\n"));
}
</script>


</html>