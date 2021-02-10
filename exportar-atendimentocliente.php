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
        $arquivo = 'atendimentocliente.xls';
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="14">ATENDIMENTO CLIENTE GMT</tr>';
		$html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td><b>idChamada</b></td>';
        $html .= '<td><b>idVendaServico</b></td>';
        $html .= '<td><b>NomeLoja</b></td>';
        $html .= '<td><b>Serviço</b></td>';
        $html .= '<td><b>Data da Venda</b></td>';
		$html .= '<td><b>Plano</b></td>';
        $html .= '<td><b>Valor do Plano</b></td>';
        $html .= '<td><b>Nome Vendedor</b></td>';
		$html .= '<td><b>Nome Cliente</b></td>';
        $html .= '<td><b>Atendeu?</b></td>';
        $html .= '<td><b>Nota Atendimento</b></td>';
        $html .= '<td><b>Foi não Conformidade?</b></td>';
        $html .= '<td><b>Data Chamada</b></td>';
        $html .= '<td><b>Observacao</b></td>';
		$html .= '</tr>';
		//$result_msg_contatos = "select despesas.id AS id,despesas.favorecido AS favorecido,plano_contas.plano_contas AS plano_contas,lojas.nomeLoja AS nomeLoja,despesas.descricao AS descricao,despesas.num_doc AS num_doc,
		//IF(date_format(despesas.data_emissao,'%d-%m-%Y') like '00-00-0000', '', date_format(despesas.data_emissao,'%d-%m-%Y')) AS data_emissao,despesas.valor AS valor,IF(date_format(despesas.data_vencimento,'%d-%m-%Y') like '00-00-0000','', date_format(despesas.data_vencimento,'%d-%m-%Y')) AS data_vencimento,situacao.situacao AS situacao,pagamento.pagamento AS pagamento,
		//banco.banco AS banco,modalidade.modalidade AS modalidade,despesas.num_cheque AS num_cheque,conciliacao.conciliacao AS conciliacao,despesas.obs AS obs,IF(date_format(despesas.data_pagamento,'%d-%m-%Y') like '00-00-0000', '', date_format(despesas.data_pagamento,'%d-%m-%Y')) AS 
		//data_pagamento from (((((((despesas join plano_contas) join lojas) join situacao) join pagamento) join banco) join modalidade) join conciliacao) where despesas.plano_contas = plano_contas.id and 
        //despesas.loja = lojas.idLoja and despesas.situacao = situacao.id and despesas.pagamento = pagamento.id and despesas.banco = banco.id and despesas.modalidade = modalidade.id and despesas.conciliacao = conciliacao.id";
        $result_msg_atendimento="Select atendimentocliente.idChamada, atendimentocliente.idVendaServico, view_atendimentocliente.nomeLoja, view_atendimentocliente.servico, view_atendimentocliente.data, view_atendimentocliente.plano, view_atendimentocliente.valorPlano,view_atendimentocliente.nomeFunc,view_atendimentocliente.nomeCliente, view_atendimentocliente.Atendeu, atendimentocliente.notaAtendimento, view_atendimentocliente.FoiNaoConformidade,atendimentocliente.dataChamada,atendimentocliente.observacao from atendimentocliente,view_atendimentocliente";
		$resultado_msg_atendimento = mysqli_query($conect, $result_msg_atendimento);
		while($row_msg_atendimento = mysqli_fetch_assoc($resultado_msg_atendimento)){
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_atendimento["idChamada"].'</td>';
			$html .= '<td>'.$row_msg_atendimento["idVendaServico"].'</td>';
			$html .= '<td>'.$row_msg_atendimento["nomeLoja"].'</td>';
			$html .= '<td>'.$row_msg_atendimento["servico"].'</td>';
			$html .= '<td>'.$row_msg_atendimento["data"].'</td>';
			$html .= '<td>'.$row_msg_atendimento["plano"].'</td>';
			$html .= '<td>'.$row_msg_atendimento["valorPlano"].'</td>';
			$html .= '<td>'.$row_msg_atendimento["nomeFunc"].'</td>';
            $html .= '<td>'.$row_msg_atendimento["nomeCliente"].'</td>';
            $html .= '<td>'.$row_msg_atendimento["Atendeu"].'</td>';
            $html .= '<td>'.$row_msg_atendimento["notaAtendimento"].'</td>';
            $html .= '<td>'.$row_msg_atendimento["FoiNaoConformidade"].'</td>';
            $html .= '<td>'.$row_msg_atendimento["dataChamada"].'</td>';
            $html .= '<td>'.$row_msg_atendimento["observacao"].'</td>';
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