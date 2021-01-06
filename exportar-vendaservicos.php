<?php
ob_start();
include_once "config.php";

$conect = null;
$conect = GerenciadorConexao::conectar();

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Despesas GMT</title>
	<head>
	<body>
		<?php
        $arquivo = 'vendaservicos.xls';
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="9">VENDA DE SERVIÇOS GMT</tr>';
		$html .= '</tr>';
		$html .= '<tr>';
        $html .= '<td><b>idVendaServico</b></td>';
        $html .= '<td><b>Filial</b></td>';
		$html .= '<td><b>Serviço</b></td>';
		$html .= '<td><b>Data do Seriviço</b></td>';
		$html .= '<td><b>Plano</b></td>';
        $html .= '<td><b>Valor do Plano</b></td>';
		$html .= '<td><b>Nome Cliente</b></td>';
        $html .= '<td><b>Nome Vendedor</b></td>';
        $html .= '<td><b>Acesso</b></td>';
        $html .= '<td><b>Portabilidade</b></td>';
		$html .= '</tr>';
		//$result_msg_contatos = "select despesas.id AS id,despesas.favorecido AS favorecido,plano_contas.plano_contas AS plano_contas,lojas.nomeLoja AS nomeLoja,despesas.descricao AS descricao,despesas.num_doc AS num_doc,
		//IF(date_format(despesas.data_emissao,'%d-%m-%Y') like '00-00-0000', '', date_format(despesas.data_emissao,'%d-%m-%Y')) AS data_emissao,despesas.valor AS valor,IF(date_format(despesas.data_vencimento,'%d-%m-%Y') like '00-00-0000','', date_format(despesas.data_vencimento,'%d-%m-%Y')) AS data_vencimento,situacao.situacao AS situacao,pagamento.pagamento AS pagamento,
		//banco.banco AS banco,modalidade.modalidade AS modalidade,despesas.num_cheque AS num_cheque,conciliacao.conciliacao AS conciliacao,despesas.obs AS obs,IF(date_format(despesas.data_pagamento,'%d-%m-%Y') like '00-00-0000', '', date_format(despesas.data_pagamento,'%d-%m-%Y')) AS 
		//data_pagamento from (((((((despesas join plano_contas) join lojas) join situacao) join pagamento) join banco) join modalidade) join conciliacao) where despesas.plano_contas = plano_contas.id and 
        //despesas.loja = lojas.idLoja and despesas.situacao = situacao.id and despesas.pagamento = pagamento.id and despesas.banco = banco.id and despesas.modalidade = modalidade.id and despesas.conciliacao = conciliacao.id";
        $result_msg_vendas="Select idVendaServico,nomeLoja, servico, data, plano, valorPlano,nomeCliente,nomeFunc, acesso, portabilidade from viewimportvendaservico";
		$resultado_msg_vendas = mysqli_query($conect, $result_msg_vendas);
		while($row_msg_vendas = mysqli_fetch_assoc($resultado_msg_vendas)){
			$html .= '<tr>';
            $html .= '<td>'.$row_msg_vendas["idVendaServico"].'</td>';
            $html .= '<td>'.$row_msg_vendas["nomeLoja"].'</td>';
			$html .= '<td>'.$row_msg_vendas["servico"].'</td>';
			$html .= '<td>'.$row_msg_vendas["data"].'</td>';
			$html .= '<td>'.$row_msg_vendas["plano"].'</td>';
			$html .= '<td>'.$row_msg_vendas["valorPlano"].'</td>';
			$html .= '<td>'.$row_msg_vendas["nomeCliente"].'</td>';
			$html .= '<td>'.$row_msg_vendas["nomeFunc"].'</td>';
			$html .= '<td>'.$row_msg_vendas["acesso"].'</td>';
			$html .= '<td>'.$row_msg_vendas["portabilidade"].'</td>';
			
			$html .= '</tr>';
			;
		}
// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit;
		if($conect)
                mysqli_close($conect);
                ?>
	</body>
</html>