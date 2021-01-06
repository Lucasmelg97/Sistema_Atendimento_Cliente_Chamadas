<!--
Fazer o include deste arquivo e adicionar a div modal comentada no 'body' deste arquivo 
dentro da div class="tab-content" do arquivo que estiver chamando

Adicionar para servir de gatilho para abrir o modal o código:
<div class="alinhado" data-id="'.$row_usuarios["id"].'">
  <button class="deletar" data-target="#id01" onclick="pegaID(this)">Deletar</button>
</div>

<a href='cadastros-financeiros-basicos.php?id=".$row_usuarios["id"]."' class='editar'>Editar</a>

-->

<!--
Para chamar o modal de confirmação eu utilizo o comando abaixo (exemplo):
if (isset($_POST['delete'])) { 
    deletaBanco();
    if (isset($_SESSION['msg'])) { 
        echo "<script type= 'text/javascript'>modalConfirm();</script>";
        unset($_SESSION['msg']);
    }
}

-->

<!doctype html>
<html lang="pt-br">

<head>

    <!-- MODAL CONFIRMAÇÃO -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- MODAL CONFIRMAÇÃO -->

</head>
<style>
.alinhado {
    display: inline;
}

.alerta {
    padding: 25px;
    border: 1px solid gray;
    border-radius: 3px;
    margin: 10px;
    font-size: 18px;
}

.error {
    border-color: #e8273b;
    color: #FFF;
    background-color: #ed5565;
}

.sucesso {
    border-color: #87c940;
    color: #FFF;
    background-color: #a0d468;
}

.atencao {
    border-color: #f4a911;
    color: #FFF;
    background-color: #f6bb42;
}

.deletar {
    background-color: #f44336;
    color: white;
    padding: 6px 8px;
    margin: 4px 0;
    border: none;
    cursor: pointer;
    width: 28%;
    opacity: 0.9;
}

.deletar:hover {
    opacity: 1;
}

.deletarOpenDataTable {
    background-color: #f44336;
    color: white;
    padding: 6px 8px;
    margin: 12px 0;
    border: none;
    cursor: pointer;
    width: 99%;
    opacity: 0.9;
}

.deletarOpenDataTable:hover {
    opacity: 1;
}

.editar {
    background-color: #F2C811;
    color: white;
    font-size: 15px;
    padding: 7px 25px;
    margin: 4px 0;
    border: none;
    cursor: pointer;
    width: 28%;
    opacity: 0.9;
}

.editar:hover {
    opacity: 1;
    text-decoration: none;
    color: white;
}

.editarOpenDataTable {
    background-color: #F2C811;
    color: white;
    padding: 7px 25px;
    margin: 4px 0;
    border: none;
    cursor: pointer;
    width: 28%;
    opacity: 0.9;
}

.editarOpenDataTable:hover {
    opacity: 1;
    text-decoration: none;
    color: white;
}

.atendimentoDataTable {
    background-color: #87c940;
    color: white;
    padding: 7px 25px;
    margin: 4px 0;
    border: none;
    cursor: pointer;
    width: 28%;
    opacity: 0.9;
}

.atendimentoDataTable:hover {
    opacity: 1;
    text-decoration: none;
    color: white;
}

.confirmEditar {
    background-color: #87c940;
    color: white;
    font-size: 15px;
    padding: 7px 25px;
    margin: 4px 0;
    border: none;
    cursor: pointer;
    width: 30%;
    opacity: 0.9;
}

.confirmEditar:hover {
    opacity: 0.5;
    text-decoration: none;
    color: white;
}

.cancelEditar {
    background-color: #ccc;
    color: black;
    font-size: 15px;
    padding: 7px 25px;
    margin: 4px 0;
    border: none;
    cursor: pointer;
    width: 30%;
    opacity: 0.9;
    text-decoration: none;
}

.cancelEditar:hover {
    opacity: 1;
    text-decoration: none;
    color: black;
}

.cancelbtn:hover,
.deletebtn:hover {
    opacity: 1;
}

/* Float cancel and delete buttons and add an equal width */
.cancelbtn,
.deletebtn {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
    float: left;
    width: 50%;
}

.Voltarbotao,
.Returnbotao {
    background-color: #292b2c;
    color: white;
    font-size: 15px;
    padding: 7px 25px;
    margin: 4px 0;
    border: none;
    cursor: pointer;
    width: 30%;
    opacity: 0.9;


}

.Voltarbotao:hover,
.Returnbotao:hover {
    opacity: 0.7;
    text-decoration: none;
    color: white;


}

/* Add a color to the cancel button */
.cancelbtn {
    background-color: #ccc;
    color: black;
}

/* Add a color to the delete button */
.deletebtn {
    background-color: #f44336;
}

/* Add padding and center-align text to the container */
.container {
    padding: 16px;
    text-align: center;
}

/* The Modal (background) */
.modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 50px;
}

/* Modal Content/Box */
.modal-content-personalizado {
    background-color: #fefefe;
    margin: 5% auto 15% 25%;
    /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 60%;
    /* Could be more or less, depending on screen size */
}

/* Modal Content/Box */
.modal-dialog-personalizado {
    background-color: #fefefe;
    margin: 5% auto 15% 35%;
    /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 40%;
    /* Could be more or less, depending on screen size */
}

/* The Modal Close Button (x) */
.close {
    position: absolute;
    right: 35px;
    top: 15px;
    font-size: 40px;
    font-weight: bold;
    color: #f1f1f1;
}

.close:hover,
.close:focus {
    color: #f44336;
    cursor: pointer;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and delete button on extra small screens */
@media screen and (max-width: 300px) {

    .cancelbtn,
    .deletebtn {
        width: 100%;
    }
}
</style>

<body>
    <!--
<div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
    <form class="modal-content-personalizado" action="" method="post" id="">
        <div class="container">
        <h1>Delete Account</h1>
        <p>Are you sure you want to delete your account?</p>
        <input type="hidden" id="result" name="result">
        <div class="clearfix">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancelar</button>
            <button type="submit" onclick="document.getElementById('id01').style.display='none'" class="deletebtn" id="delete" name="delete">Deletar</button>
        </div>
        </div>
    </form>
</div>
-->


    <!--
<div class="modal" id="modalConfirmacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog-personalizado" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Mensagem</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('modalConfirmacao').style.display='none'">OK</button>
            </div>
        </div>
    </div>
</div>
-->


    <script>
    // Get the modal
    var modal = document.getElementById('idchamada');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

    <script>
    function pegaID(element) {
        $(document).ready(function() {
            document.getElementById('idchamada').style.display = 'block'
            var id_obj = element.parentNode.getAttribute('data-id');
            document.getElementById("result").value = id_obj;
        })
    }
    </script>


    <script>
    function pegaIDExclusaoDespesaLote(idDespesaLote) {
        $(document).ready(function() {
            document.getElementById('id02').style.display = 'block'
            var id_DespesaLote = idDespesaLote;
            document.getElementById("idDespesaLote").value = id_DespesaLote;
        })
    }
    </script>


    <script>
    function pegaIDExclusaoDespesaRateio(idDespesaRateio) {
        $(document).ready(function() {
            document.getElementById('id03').style.display = 'block'
            var id_DespesaRateio = idDespesaRateio;
            document.getElementById("idDespesaRateio").value = id_DespesaRateio;
        })
    }
    </script>


    <script>
    function alteraDespesaRateio(idDespesaRateio, num_doc, data_vencimento, situacao, pagamento, data_pagamento, banco,
        modalidade, num_cheque, conciliacao, obs, rateio) {
        $(document).ready(function() {
            document.getElementById('id05').style.display = 'block'

            var id_DespesaRateio = idDespesaRateio;
            document.getElementById("alteraRat_idDespesaRateio").value = id_DespesaRateio;

            var rat_num_doc = num_doc;
            document.getElementById("alteraRat_num_doc").value = rat_num_doc;

            var rat_data_vencimento = data_vencimento;
            document.getElementById("alteraRat_data_vencimento").value = rat_data_vencimento;

            var rat_situacao = situacao;
            document.getElementById("alteraRat_situacao").value = rat_situacao;

            var rat_pagamento = pagamento;
            document.getElementById("alteraRat_pagamento").value = rat_pagamento;

            var rat_data_pagamento = data_pagamento;
            document.getElementById("alteraRat_data_pagamento").value = rat_data_pagamento;

            var rat_banco = banco;
            document.getElementById("alteraRat_banco").value = rat_banco;

            var rat_modalidade = modalidade;
            document.getElementById("alteraRat_modalidade").value = rat_modalidade;

            var rat_num_cheque = num_cheque;
            document.getElementById("alteraRat_num_cheque").value = rat_num_cheque;

            var rat_conciliacao = conciliacao;
            document.getElementById("alteraRat_conciliacao").value = rat_conciliacao;

            var rat_obs = obs;
            document.getElementById("alteraRat_obs").value = rat_obs;

            var rat_rateio = rateio;
            document.getElementById("alteraRat_rateio").value = rat_rateio;
        })
    }
    </script>


    <script>
    function alteraDespesaLote(favorecido, idDespesaLote, num_doc, valor, data_vencimento, situacao, pagamento,
        data_pagamento, banco, modalidade, num_cheque, conciliacao, obs, lote) {
        $(document).ready(function() {
            document.getElementById('id06').style.display = 'block'

            var id_FavorecidoLote = favorecido;
            document.getElementById("alteraLot_favorecidoLote").value = id_FavorecidoLote;

            var id_DespesaLote = idDespesaLote;
            document.getElementById("alteraLot_idDespesaLote").value = id_DespesaLote;

            var lot_num_doc = num_doc;
            document.getElementById("alteraLot_num_doc").value = lot_num_doc;

            var lot_data_vencimento = data_vencimento;
            document.getElementById("alteraLot_data_vencimento").value = lot_data_vencimento;

            var lot_situacao = situacao;
            document.getElementById("alteraLot_situacao").value = lot_situacao;

            var lot_pagamento = pagamento;
            document.getElementById("alteraLot_pagamento").value = lot_pagamento;

            var lot_data_pagamento = data_pagamento;
            document.getElementById("alteraLot_data_pagamento").value = lot_data_pagamento;

            var lot_banco = banco;
            document.getElementById("alteraLot_banco").value = lot_banco;

            var lot_modalidade = modalidade;
            document.getElementById("alteraLot_modalidade").value = lot_modalidade;

            var lot_num_cheque = num_cheque;
            document.getElementById("alteraLot_num_cheque").value = lot_num_cheque;

            var lot_conciliacao = conciliacao;
            document.getElementById("alteraLot_conciliacao").value = lot_conciliacao;

            var lot_obs = obs;
            document.getElementById("alteraLot_obs").value = lot_obs;

            var lot_lote = lote;
            document.getElementById("alteraLot_lote").value = lot_lote;
        })
    }
    </script>

    <script>
    function pegaIDExclusaoDespesaLoteErateio(idDespesaLoteRateio) {
        $(document).ready(function() {
            document.getElementById('id04').style.display = 'block'
            var id_DespesaLoteRateio = idDespesaLoteRateio;
            document.getElementById("idDespesaLoteRateio").value = id_DespesaLoteRateio;
        })
    }
    </script>


    <script>
    // Get the modal
    var modal = document.getElementById('modalConfirmacao');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

    <script>
    function modalConfirm() {
        $(document).ready(function() {
            document.getElementById('modalConfirmacao').style.display = 'block'
        })
    }

    function modalFaltaMes() {
        $(document).ready(function() {
            document.getElementById('modalFaltaMes').style.display = 'block'
        })
    }

    function modalAlertaRateio() {
        $(document).ready(function() {
            document.getElementById('modalAlertaRateio').style.display = 'block'
        })
    }

    function modalAlertaLote() {
        $(document).ready(function() {
            document.getElementById('modalAlertaLote').style.display = 'block'
        })
    }

    function modalAlertaRateioLote() {
        $(document).ready(function() {
            document.getElementById('modalAlertaRateioLote').style.display = 'block'
        })
    }

    function modalFaltaAno() {
        $(document).ready(function() {
            document.getElementById('modalFaltaAno').style.display = 'block'
        })
    }

    function modalQtdLojasRateio() {
        $(document).ready(function() {
            document.getElementById('modalQtdLojasRateio').style.display = 'block'
        })
    }

    function modalSomaValorRateio() {
        $(document).ready(function() {
            document.getElementById('modalSomaValorRateio').style.display = 'block'
        })
    }

    function modalDataEmissaoVencimento() {
        $(document).ready(function() {
            document.getElementById('modalDataEmissaoVencimento').style.display = 'block'
        })
    }

    function modalDataEmissaoPagamento() {
        $(document).ready(function() {
            document.getElementById('modalDataEmissaoPagamento').style.display = 'block'
        })
    }

    function modalDataVencimentoLote() {
        $(document).ready(function() {
            document.getElementById('modalDataVencimentoLote').style.display = 'block'
        })
    }
    </script>

</body>

</html>