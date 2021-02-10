<?php

session_start();
include 'bootstrap-confirm.php';

//include 'unset-sessions.php'
?>

<link href="./main.css" rel="stylesheet">
</head>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Atendimento cliente</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Controle Financeiro GMT">
    <meta name="msapplication-tap-highlight" content="no">

    <link href="./main.css" rel="stylesheet">

    <!--TABELA DESPESAS-->
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <link rel="stylesheet" type="text/css" href="dataTable-atendimento/style.css">
    <script src="dataTable-atendimento/OpenDataTable.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".OpenDataTable").OpenDataTable({
            url: "dataTable-atendimento/simple_php_datasource_Atendimento.php",
        });
    });
    async function deletaChamada(idchamada) { //FUNÇÃO AUXILIAR DE EXCLUSÃO
        await fetch(`?deletaChamada=${idchamada}`);
        location.reload();

    }
    function setEdit_Atendimento(atendeu,notaAtendimento,debitoOfertado,debitoAutomatico,motivoPlano,FoiNaoConformidade,dataChamada,observacao) {
            $(document).ready(function()
            {   
                
                
               // $("#valor").val(valor);

                let elementatendeu = document.getElementById('AtendeuSelect');
                elementatendeu.value = atendeu;
                
                let elementnota = document.getElementById('NotaSelect');
                elementnota.value = notaAtendimento;
                
                let elementdebitoOfertado = document.getElementById('DEBautlojaSelect');
                elementdebitoOfertado.value = debitoOfertado;

                let elementdebitoAutomatico = document.getElementById('DEBautSelect');
                elementdebitoAutomatico.value = debitoAutomatico;

                let elementmotivoPlano = document.getElementById('MotPlanoSelect');
                elementmotivoPlano.value = motivoPlano;

                let elementFoiNaoConformidade = document.getElementById('selectNaoconf');
                elementFoiNaoConformidade.value = FoiNaoConformidade;

                $("#dataChamada").val(dataChamada);
                $("#textOBS").val(observacao);
                
                //$("#data").val(data);

                //let elementConciliacao = document.getElementById('conciliacao');
               // elementConciliacao.value = conciliacao;
            });
        }
    
    </script>
    <!--TABELA DESPESAS-->

</head>

<body>
    <!-- Modal -->
    <div class="modal" id="modalConfirmacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

        <?php


//Configuração de submit//
if (isset($_POST['selectNaoconf'])) {                                    
   
    echo "<script type= 'text/javascript'>alert('Enviando..');</script> ";
    if(isset($_POST['atualizabotao'])){
        
        unset($_SESSION['idEdit']);
       
        AtualizaAtendimentoCliente();
        unset($_POST['atualizabotao']);}
        
    
    else if(isset($_POST['enviabotao'])){
        
        insereAtendimentoCliente();
        
    }
    
    //insereAtendimentoCliente();
    if (isset($_SESSION['msg'])) { 
        echo "<script type= 'text/javascript'>modalConfirm();</script>";
    }
    

}
                     
if(isset($_GET['idchamada'])){
    $_SESSION['idEdit']=$_GET['idchamada'];
    echo "<script type= 'text/javascript'>alert('Abrindo para alterações...');</script> ";
    require_once 'classe-atendimentoclienteDAO.php';
    $busca = new Classe_AtendimentoCliente_DAO();
    $recebe=$busca->buscaPorId($_GET['idchamada']);
    //echo "<script type= 'text/javascript'>alert('$recebe->atendeu e $recebe->observacao');</script> ";
    //echo "<script type= 'text/javascript'>alert('1..');</script> ";
    echo '<script type="text/javascript">',
                                'setEdit_Atendimento('.$recebe->atendeu.','.$recebe->notaAtendimento.','.$recebe->debitoOfertado.','.$recebe->debitoAutomatico.','.$recebe->motivoPlano.','.$recebe->FoiNaoConformidade.',"'.$recebe->dataChamada.'","'.$recebe->observacao.'");',
                                '</script>';
                                //echo "<script type= 'text/javascript'>alert('2..');</script> ";
                                
}


  if (isset($_GET['deletaChamada'])) { return ExcluiAtendimentoCliente($_GET['deletaChamada']); }






        //********Post no banco de dados*************//
//Método de inserção//
 function insereAtendimentoCliente(){

    
    require_once 'classe-atendimentoclienteDAO.php';
    $obj_insereAtendimento = new Classe_AtendimentoCliente_DAO();
    $obj_insereAtendimento->atendeu = $_POST['selectAtendeu'];       
    //$obj_insereAtendimento->refProduto = $_POST['selectRefProd'];
    $obj_insereAtendimento->motivoPlano = $_POST['selectMotPlano'];
    $obj_insereAtendimento->notaAtendimento = $_POST['selectNota'];
    //$obj_insereAtendimento->dataVencimento = $_POST['selectDataV'];
    $obj_insereAtendimento->debitoAutomatico = $_POST['selectDEBaut'];
    $obj_insereAtendimento->debitoOfertado = $_POST['selectDEBautloja'];
    $obj_insereAtendimento->FoiNaoConformidade = $_POST['selectNaoconf'];
    if(($_POST['selectNaoconf']=="1")){
     $obj_insereAtendimento->dataChamada = $_POST['dataChamada'];
     }
    $obj_insereAtendimento->observacao = $_POST['textOBS'];
    
    //$obj_obs->idVendaServico= $_GET['idvendaservico'];
    $obj_insereAtendimento->idVendaServico =  $_GET['idvendaservico'];
    $obj_insereAtendimento->inserir($obj_insereAtendimento);

    //alimenta o campo observação na importvendaservicos
    //require_once 'classe-importvendaservicoDAO.php';
   // $obj_obs=new Classe_ImportVendaServico_DAO();
    //$aux_obs =  $obj_obs->retornaobs($_GET['idvendaservico']);
    //$aux_obs->observacao = $_POST['textOBS'];
    //$obj_obs->atualizarOBS($aux_obs);
    //$_SESSION['obsconfirm']=1;

    
    
}
function ExcluiAtendimentoCliente($idchamada){
    require_once 'classe-atendimentoclienteDAO.php';
    $obj_excluiAtendimento= new Classe_AtendimentoCliente_DAO();

    $obj_excluiAtendimento->excluir($idchamada);
    

}

//Método de atualização//

function AtualizaAtendimentoCliente(){

    
    require_once 'classe-atendimentoclienteDAO.php';
    $obj_atualizaAtendimento = new Classe_AtendimentoCliente_DAO();
    $aux_atualizaAtendimento =  $obj_atualizaAtendimento->buscaPorID($_GET['idchamada']);
    $aux_atualizaAtendimento->atendeu = $_POST['selectAtendeu'];       
    $aux_atualizaAtendimento->motivoPlano = $_POST['selectMotPlano'];
    $aux_atualizaAtendimento->notaAtendimento = $_POST['selectNota'];
    $aux_atualizaAtendimento->debitoAutomatico = $_POST['selectDEBaut'];
    $aux_atualizaAtendimento->debitoOfertado = $_POST['selectDEBautloja'];
    $aux_atualizaAtendimento->FoiNaoConformidade = $_POST['selectNaoconf'];
    if(($_POST['selectNaoconf']=="1")){
    $aux_atualizaAtendimento->dataChamada = $_POST['dataChamada'];
    }
    $aux_atualizaAtendimento->observacao = $_POST['textOBS'];
    $obj_atualizaAtendimento->atualizar($aux_atualizaAtendimento);
    
    
}
function unsetsessions()
             {
                unset($_SESSION['idEdit']);
             }
                                           

?>


        <div class="modal-dialog-personalizado" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Mensagem</h4>
                </div>

                <?php
                                            if (strpos($_SESSION['msg'], 'Erro') !== false) {
                                                echo '<div class="alerta error">';
                                                echo $_SESSION['msg'];
                                                unset($_SESSION['msg']);
                                                echo '</div>';
                                            }
                                            elseif (strpos($_SESSION['msg'], 'sucesso') !== false) {
                                                echo '<div class="alerta sucesso">';
                                                echo $_SESSION['msg'];
                                                unset($_SESSION['msg']);
                                                echo '</div>';
                                            }
                                            elseif (strpos($_SESSION['msg'], 'Nenhum') !== false) {
                                                echo '<div class="alerta atencao">';
                                                echo $_SESSION['msg'];
                                                unset($_SESSION['msg']);
                                                echo '</div>';
                                            }
                                        ?>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        onclick="document.getElementById('modalConfirmacao').style.display='none'">OK</button>
                </div>
            </div>
        </div>
    </div>


    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <?php require 'menu-superior.php';?>
        </div>
        <div class="ui-theme-settings">
            <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button>
            <div class="theme-settings__inner">
                <div class="scrollbar-container">
                    <div class="theme-settings__options-wrapper">
                        <h3 class="themeoptions-heading">Layout Options
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class"
                                                    data-class="fixed-header">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle"
                                                            data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Header
                                                </div>
                                                <div class="widget-subheading">Makes the header top fixed, always
                                                    visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class"
                                                    data-class="fixed-sidebar">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle"
                                                            data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Sidebar
                                                </div>
                                                <div class="widget-subheading">Makes the sidebar left fixed, always
                                                    visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class"
                                                    data-class="fixed-footer">
                                                    <div class="switch-animate switch-off">
                                                        <input type="checkbox" data-toggle="toggle"
                                                            data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Footer
                                                </div>
                                                <div class="widget-subheading">Makes the app footer bottom fixed, always
                                                    visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>
                                Header Options
                            </div>
                            <button type="button"
                                class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class"
                                data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-header-cs-class"
                                            data-class="bg-primary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-header-cs-class"
                                            data-class="bg-secondary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-header-cs-class"
                                            data-class="bg-success header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-header-cs-class"
                                            data-class="bg-info header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-header-cs-class"
                                            data-class="bg-warning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-header-cs-class"
                                            data-class="bg-danger header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-header-cs-class"
                                            data-class="bg-light header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-header-cs-class"
                                            data-class="bg-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-header-cs-class"
                                            data-class="bg-focus header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-header-cs-class"
                                            data-class="bg-alternate header-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-header-cs-class"
                                            data-class="bg-vicious-stance header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-header-cs-class"
                                            data-class="bg-midnight-bloom header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-header-cs-class"
                                            data-class="bg-night-sky header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-header-cs-class"
                                            data-class="bg-slick-carbon header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-header-cs-class"
                                            data-class="bg-asteroid header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-header-cs-class"
                                            data-class="bg-royal header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-header-cs-class"
                                            data-class="bg-warm-flame header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-header-cs-class"
                                            data-class="bg-night-fade header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-header-cs-class"
                                            data-class="bg-sunny-morning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-header-cs-class"
                                            data-class="bg-tempting-azure header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-header-cs-class"
                                            data-class="bg-amy-crisp header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-header-cs-class"
                                            data-class="bg-heavy-rain header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-header-cs-class"
                                            data-class="bg-mean-fruit header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-header-cs-class"
                                            data-class="bg-malibu-beach header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-header-cs-class"
                                            data-class="bg-deep-blue header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-header-cs-class"
                                            data-class="bg-ripe-malin header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-header-cs-class"
                                            data-class="bg-arielle-smile header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-header-cs-class"
                                            data-class="bg-plum-plate header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-header-cs-class"
                                            data-class="bg-happy-fisher header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-header-cs-class"
                                            data-class="bg-happy-itmeo header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-header-cs-class"
                                            data-class="bg-mixed-hopes header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-header-cs-class"
                                            data-class="bg-strong-bliss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-header-cs-class"
                                            data-class="bg-grow-early header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-header-cs-class"
                                            data-class="bg-love-kiss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-header-cs-class"
                                            data-class="bg-premium-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-header-cs-class"
                                            data-class="bg-happy-green header-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Sidebar Options</div>
                            <button type="button"
                                class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class"
                                data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-sidebar-cs-class"
                                            data-class="bg-primary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-sidebar-cs-class"
                                            data-class="bg-secondary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-sidebar-cs-class"
                                            data-class="bg-success sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-sidebar-cs-class"
                                            data-class="bg-info sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-sidebar-cs-class"
                                            data-class="bg-warning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-sidebar-cs-class"
                                            data-class="bg-danger sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-sidebar-cs-class"
                                            data-class="bg-light sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-sidebar-cs-class"
                                            data-class="bg-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-sidebar-cs-class"
                                            data-class="bg-focus sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-sidebar-cs-class"
                                            data-class="bg-alternate sidebar-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class"
                                            data-class="bg-vicious-stance sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class"
                                            data-class="bg-midnight-bloom sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-sidebar-cs-class"
                                            data-class="bg-night-sky sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class"
                                            data-class="bg-slick-carbon sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-sidebar-cs-class"
                                            data-class="bg-asteroid sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-sidebar-cs-class"
                                            data-class="bg-royal sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class"
                                            data-class="bg-warm-flame sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-sidebar-cs-class"
                                            data-class="bg-night-fade sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class"
                                            data-class="bg-sunny-morning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class"
                                            data-class="bg-tempting-azure sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class"
                                            data-class="bg-amy-crisp sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class"
                                            data-class="bg-heavy-rain sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class"
                                            data-class="bg-mean-fruit sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class"
                                            data-class="bg-malibu-beach sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class"
                                            data-class="bg-deep-blue sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class"
                                            data-class="bg-ripe-malin sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class"
                                            data-class="bg-arielle-smile sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class"
                                            data-class="bg-plum-plate sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class"
                                            data-class="bg-happy-fisher sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class"
                                            data-class="bg-happy-itmeo sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class"
                                            data-class="bg-mixed-hopes sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class"
                                            data-class="bg-strong-bliss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-sidebar-cs-class"
                                            data-class="bg-grow-early sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class"
                                            data-class="bg-love-kiss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class"
                                            data-class="bg-premium-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-sidebar-cs-class"
                                            data-class="bg-happy-green sidebar-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Main Content Options</div>
                            <button type="button"
                                class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Page Section Tabs
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div role="group" class="mt-2 btn-group">
                                            <button type="button"
                                                class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class"
                                                data-class="body-tabs-line">
                                                Line
                                            </button>
                                            <button type="button"
                                                class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class"
                                                data-class="body-tabs-shadow">
                                                Shadow
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>


                <div class="scrollbar-sidebar">
                    <?php require 'menu-lateral.php';?>
                </div>

            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">



                    <div class="tab-content">

                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <div><?php 
                                                           require_once 'classe-importvendaservicoDAO.php';
                                                           require_once 'classe-viewimportvendaservicoDAO.php';
                                                           $objetoimport = new Classe_ImportVendaServico_DAO();
                                                           $objviewimport=new Viewimportvendaservico_DAO();
                                                           $retorno = $objetoimport->retornainfovenda($_GET['idvendaservico']);
                                                           $retornoview = $objviewimport->retornainfovenda($_GET['idvendaservico']);
                                                           echo "$retorno->nomeCliente : "; 
                                                           echo "  $retorno->plano"; 
                                                           echo " de R$$retorno->valorPlano<br>" ; 
                                                           echo "$retornoview->nomeLoja - ";
                                                           echo "$retornoview->nomeFunc - ";
                                                           echo "$retornoview->data <br>";
                                                           echo "Acesso: 0015 $retornoview->acesso  ";
                                                           if($retornoview->portabilidade!=NULL){
                                                           echo "/ Portabilidade : 0015 $retornoview->portabilidade";}
                                                           
                                                           
                                                    
                                             ?>
                                                </div>
                                            </h5>


                                        </div>
                                        <div class="col-lg-5">

                                            <div class="position-relative form-group">
                                                <?php 
                                                           require_once 'classe-opcoesrespostaDAO.php';

                                                           $obj_resposta = new Classe_Opcoes_Resposta_DAO();
                                                           $lista_resposta = $obj_resposta->buscaTodasChamadas();
                                                    
                                                    ?>
                                                <form class="" method="post" id="confirmaatualizacao">

                                                    <label for="exampleSelect" class="">Cliente Atendeu?</label><select
                                                        name="selectAtendeu" id="AtendeuSelect" required
                                                        class="form-control" class="form-control">
                                                        <option selected="" value="" disabled="">Selecione:</option>


                                                        <?php
                                                                            foreach ($lista_resposta as $indice => $each) {
                                                                               
                                                                
                                                                                echo "<option id=".$each->IDresposta." value=".$each->IDresposta.">".$each->Opcaoresposta."</option>";
                                                                            }
                                                                        ?>


                                                    </select>
                                            </div>
                                        </div>




                                        <!--NOTAS-->
                                        <div class="col-lg-5">
                                            <div class="position-relative form-group">

                                                <label for="exampleSelect" class="">Qual a nota para avaliação do
                                                    atendimento?</label><select name="selectNota" id="NotaSelect"
                                                    class="form-control">
                                                    <option> - </option>
                                                    <option id="1" value="1">1</option>
                                                    <option id="2" value="2">2</option>
                                                    <option id="3" value="3">3</option>
                                                    <option id="4" value="4">4</option>
                                                    <option id="5" value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--NOTAS-->

                                        <div class="col-lg-5">
                                            <div class="position-relative form-group">
                                                <?php 
                                                           require_once 'classe-opcoesrespostaDAO.php';

                                                           $obj_resposta = new Classe_Opcoes_Resposta_DAO();
                                                           $lista_resposta = $obj_resposta->buscaTodasChamadas();
                                                    
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="position-relative form-group">
                                                <?php 
                                                           require_once 'classe-opcoesrespostaDAO.php';

                                                           $obj_resposta = new Classe_Opcoes_Resposta_DAO();
                                                           $lista_resposta = $obj_resposta->buscaTodasChamadas();
                                                    
                                                    ?>
                                                <label for="exampleSelect" class="">Foi ofertado débito automático em
                                                    loja?</label><select name="selectDEBautloja" id="DEBautlojaSelect"
                                                    class="form-control">
                                                    <option> - </option>
                                                    <?php
                                                                            foreach ($lista_resposta as $indice => $each) {
                                                                                if($each->IDresposta!='4'){
                                                                                echo "<option id=".$each->IDresposta." value=".$each->IDresposta.">".$each->Opcaoresposta."</option>";
                                                                            }}
                                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="position-relative form-group">
                                                <?php 
                                                           require_once 'classe-opcoesrespostaDAO.php';

                                                           $obj_resposta = new Classe_Opcoes_Resposta_DAO();
                                                           $lista_resposta = $obj_resposta->buscaTodasChamadas();
                                                    
                                                    ?>
                                                <label for="exampleSelect" class="">Cliente possui interesse em débito
                                                    automático?</label><select name="selectDEBaut" id="DEBautSelect"
                                                    class="form-control">
                                                    <option> - </option>
                                                    <?php
                                                                            foreach ($lista_resposta as $indice => $each) {
                                                                                if($each->IDresposta!='4'){
                                                                                echo "<option id=".$each->IDresposta." value=".$each->IDresposta.">".$each->Opcaoresposta."</option>";
                                                                            }}
                                                                        ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="position-relative form-group">
                                                <?php 
                                                           require_once 'classe-opcoesrespostamotivoplanoDAO.php';

                                                           $obj_resposta = new Classe_Opcoes_Resposta_motivoplanoDAO();
                                                           $lista_resposta = $obj_resposta->buscaTodasChamadas();
                                                    
                                                    ?>
                                                <label for="exampleSelect" class="">Motivo que o levou a fazer o
                                                    plano?</label><select name="selectMotPlano" id="MotPlanoSelect"
                                                    class="form-control">

                                                    <option> - </option>

                                                    <?php
                                                                            foreach ($lista_resposta as $indice => $each) {
                                                                                
                                                                                echo "<option id=".$each->IDresposta." value=".$each->IDresposta.">".$each->Opcaoresposta."</option>";
                                                                            }
                                                                        ?>


                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="position-relative form-group">
                                                <?php 
                                                           require_once 'classe-opcoesrespostaDAO.php';

                                                           $obj_resposta = new Classe_Opcoes_Resposta_DAO();
                                                           $lista_resposta = $obj_resposta->buscaTodasChamadas();
                                                    
                                                    ?>
                                                <label for="exampleSelect" class="">Houve não
                                                    conformidade?</label><select name="selectNaoconf" id="selectNaoconf"
                                                    class="form-control" onchange="Habilitar(this,'dataChamada');">
                                                    <option> - </option>
                                                    <?php
                                                                            foreach ($lista_resposta as $indice => $each) {
                                                                                if($each->IDresposta!='4'){
                                                                                echo "<option id=".$each->IDresposta." value=".$each->IDresposta.">".$each->Opcaoresposta."</option>";
                                                                            }}
                                                                        ?>




                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="position-relative form-group">
                                                <script>
                                                function Habilitar(selectNaoconf, dataChamada) {
                                                    var cmp = document.getElementById(dataChamada);
                                                    let aux = document.getElementsByName("selectNaoconf")[0].value;
                                                    if (aux == "1") {
                                                        cmp.disabled = false;
                                                        //cmp.hidden = false;
                                                    } else {
                                                        cmp.disabled = true;
                                                        //cmp.hidden = true;
                                                    }
                                                }
                                                </script>


                                                <input type="date" name="dataChamada" id="dataChamada"
                                                    value="Data da Não conformidade" disabled ><br>




                                            </div>
                                        </div>

                                        <div class="position-relative form-group">
                                            <div class="col-md-10">
                                                <div class="position-relative form-group"><label for="exampleText"
                                                        class="">Observação:</label><textarea name="textOBS"
                                                        id="textOBS" class="form-control"></textarea></div>
                                            </div>



                                            </select>
                                        </div>




                                        <div class="col-lg-5">


                                            <div class="position-relative form-group">

                                                <?php
                                              
                                                if(isset($_SESSION['idEdit'])){
                                                echo '<button class="confirmEditar" name="atualizabotao" id="atualizabotao" type="submit">Atualizar</button>';
                                                unsetsessions();}
                                                  
                                                else{
                                                    echo '<button class="confirmEditar" name="enviabotao" id="enviabotao" type="submit">Enviar</button>';
                                                unsetsessions();}
                                             
                                            ?>

                                            </div>

                                        </div>

                                        <div class="col-lg-5">

                                            <div class="position-relative form-group">



                                                <a href="vendadeservicos.php">
                                                    <button type="button" class="Voltarbotao">Voltar</button>
                                                </a>


                                            </div>

                                        </div>
                                        <script>
                                        if (window.history.replaceState) {
                                            window.history.replaceState(null, null, window.location.href);
                                        }
                                        </script>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body">
                                                <h5 class="card-title">Busca - Chamadas Efetuadas</h5>


                                                <table class="OpenDataTable">
                                                    <thead>
                                                        <tr>

                                                            <th>Realizar atendimento</th>
                                                            <th data-colsearch="yes">Serviço</th>
                                                            <th data-colsearch="yes">Loja</th>
                                                            <th data-colsearch="yes">Data </th>
                                                            <th data-colsearch="yes">Plano</th>
                                                            <th data-colsearch="yes">Valor</th>
                                                            <th data-colsearch="yes">Vendedor</th>
                                                            <th data-colsearch="yes">Cliente</th>
                                                            <th data-colsearch="yes">Atendeu</th>
                                                            <th data-colsearch="yes">Não conformidade</th>
                                                            <th data-colsearch="yes">ID chamada</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>




                                                <center>
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info" onCLick="window.print()">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-business-time fa-w-20"></i>
                                            </span>
                                            Imprimir
                                        </button>

                                <div class="d-inline-block dropdown">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-business-time fa-w-20"></i>
                                            </span>
                                            Exportar
                                        </button>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                            <ul class="nav flex-column">
                                                                <li class="nav-item">
                                                                    <a href="exportar-atendimentocliente.php" class="nav-link">
                                                                        <i class="nav-link-icon lnr-picture"></i>
                                                                        <span>
                                                                            Excel
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                     </div>
                                            </div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>




                    </div>


                    <script type="text/javascript" src="./assets/scripts/main.js"></script>

</body>

</html>