/******* ADICIONAR O CÓDIGO JAVASCRIPT ABAIXO NA PÁGINA QUE DESEJA ADICIONAR A TABELA *******


    <!--TABELA DESPESAS-->
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
     <link rel="stylesheet" type="text/css" href="tabelaDespesas/style.css">
     <script src="tabelaDespesas/OpenDataTable.js"></script>
     <script type="text/javascript">
    $(document).ready(function(){
      $(".OpenDataTable").OpenDataTable({  
        url:"tabelaDespesas/simple_php_datasource.php",
      });
    });
     </script>
     <!--TABELA DESPESAS-->





/******* ADICIONAR O CÓDIGO ABAIXO ONDE DESEJA QUE A TABELA APAREÇA *******

<table class="OpenDataTable">
                                                <thead>
                                                    <tr>
                                                        <th >Editar / Deletar</th>
                                                        <th data-colsearch="yes" >Favorecido</th>
                                                        <th data-colsearch="yes" >Plano de Contas</th>
                                                        <th data-colsearch="yes" >Loja</th>
                                                        <th data-colsearch="yes" >Descricao</th>
                                                        <th data-colsearch="yes" >Nr. DOC</th>
                                                        <th data-colsearch="yes" >Data Emissão</th>
                                                        <th data-colsearch="yes" >Valor</th>
                                                        <th data-colsearch="yes" >Data Vencimento</th>
                                                        <th data-colsearch="yes" >Situacao</th>
                                                        <th data-colsearch="yes" >Pagamento</th>
                                                        <th data-colsearch="yes" >Banco</th>
                                                        <th data-colsearch="yes" >Modalidade</th>
                                                        <th data-colsearch="yes" >Nr. Cheque</th>
                                                        <th data-colsearch="yes" >Conciliado</th>
                                                        <th data-colsearch="yes" >Observação</th>
                                                        <th data-colsearch="yes" >Data Pagamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>


/******* NO ARQUIVO simple_php_datasource ALTERAR CONEXÃO E ALTERAR NOME DA VIEW E CAMPOS DESSA VIEW QUE DEVERÁ SER CRIADA NO BANCO CONFORME ORIENTAÇÃO ABAIXO *******

/******* CRIAR VIEW PARA ADICIONAR NO CÓDIGO DO ARQUIVO simple_php_datasource *******

CREATE VIEW nomeBanco.nomeVIEW AS SELECT ..........