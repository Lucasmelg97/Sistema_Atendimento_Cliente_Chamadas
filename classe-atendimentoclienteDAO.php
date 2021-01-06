<?php 

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/* Inclui bibliotecas de classes */
include 'classe-atendimentocliente.php';
include_once "config.php";


class Classe_AtendimentoCliente_DAO{

	/* Variável privada que armazena o identificador da conexão com o banco */
	private $conexao = null;

		/* Construtor da classe: estabelece conexão com o banco */
		/* Utiliza o método estático da classe GerenciadorConexao */
		public function __construct(){
			/* Recebe o identificador da conexão e armazena */
			$this->conexao = GerenciadorConexao::conectar();
		}

		/* Destrutor da classe: finaliza conexão com o banco */
		public function __destruct(){
			/* Verifica se a conexão havia sido estabelecida anteriormente */
			if($this->conexao)
				mysqli_close($this->conexao);
		}

/* -----------------------------------------------------------------------------
 * Aqui começa a implementação do CRUD
 *
 * C = Create 		-> 		Insere novas linhas na tabela
 * R = Retrieve 	-> 		Busca entradas na tabela
 * U = Update 		-> 		Atualiza linhas da tabela
 * D = delete 		->		Deleta linhas da tabela
 -----------------------------------------------------------------------------*/
				

		 /*Função para inserir nova chamada na tabela produto do banco de dados*/
		/* public function inserir($Atendimentocliente)*/

 		public function inserir($Atendimentocliente){
			 if ($Atendimentocliente->FoiNaoConformidade=="1")
			 {
				
				$insert_query =	"INSERT INTO  atendimentocliente(idChamada, atendeu, 
			  motivoPlano, debitoAutomatico, 
			 debitoOfertado, observacao, dataChamada,idVendaServico,notaAtendimento,FoiNaoConformidade) 
			 VALUES (DEFAULT,'".$Atendimentocliente->atendeu."',
			 
			 '".$Atendimentocliente->motivoPlano."',
			
			 '".$Atendimentocliente->debitoAutomatico."',
			 '".$Atendimentocliente->debitoOfertado."',
			 '".$Atendimentocliente->observacao."',
			 '".$Atendimentocliente->dataChamada."',
			 '".$Atendimentocliente->idVendaServico."',
			 '".$Atendimentocliente->notaAtendimento."',
			 '".$Atendimentocliente->FoiNaoConformidade."'
			 
			 )"; 
			 }
			 else
			 {
				$insert_query =	"INSERT INTO  atendimentocliente(idChamada, atendeu, 
				 motivoPlano, debitoAutomatico,  
				 debitoOfertado, observacao, idVendaServico ,notaAtendimento,FoiNaoConformidade) 
				 VALUES (DEFAULT,'".$Atendimentocliente->atendeu."',
				 
				 '".$Atendimentocliente->motivoPlano."',
				 '".$Atendimentocliente->debitoAutomatico."','".$Atendimentocliente->debitoOfertado."',
				 '".$Atendimentocliente->observacao."',
				 '".$Atendimentocliente->idVendaServico."',
				 '".$Atendimentocliente->notaAtendimento."',
				 '".$Atendimentocliente->FoiNaoConformidade."')"; 
			 }
 			/* Primeiro cria a query do MySQL */
 			
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			
			mysqli_query($this->conexao, $insert_query)
			or $_SESSION['msg'] = "Erro de SQL ao inserir atendimento.$insert_query";

			$linhas=mysqli_affected_rows($this->conexao);
			
			if(($linhas>0) && (!isset($_SESSION['msg']))){
				enviaemail();
				$_SESSION['msg'] = "Atendimento inserido com sucesso!$insert_query";
				
			}elseif(($linhas<1) && (!isset($_SESSION['msg']))){
				$_SESSION['msg'] = "Nenhum registro foi inserido.$insert_query";
			}
			
 		}

 		/* Função para atualizar os dados de um dos produtos já cadastrados */
 		public function atualizar($Atendimentocliente){
 			
			 /* Primeiro cria a query do MySQL */
			 if ($Atendimentocliente->FoiNaoConformidade=="1"){
			
 			$update_query =	"UPDATE atendimentocliente 
			 SET atendeu = '".$Atendimentocliente->atendeu."',
			 
			 motivoPlano = '".$Atendimentocliente->motivoPlano."' ,
			 notaAtendimento = '".$Atendimentocliente->notaAtendimento."',
			  
			  debitoAutomatico = '".$Atendimentocliente->debitoAutomatico."', 
			  debitoOfertado = '".$Atendimentocliente->debitoOfertado."', 
			  observacao = '".$Atendimentocliente->observacao."', 
			  dataChamada = '".$Atendimentocliente->dataChamada."',
			 idVendaServico = '".$Atendimentocliente->idVendaServico."',
			 notaAtendimento = '".$Atendimentocliente->notaAtendimento."',
			 FoiNaoConformidade = '".$Atendimentocliente->FoiNaoConformidade."'

			 WHERE idChamada = ".$Atendimentocliente->idChamada;
			}

			else{
				$update_query =	"UPDATE atendimentocliente 
				SET atendeu = '".$Atendimentocliente->atendeu."',
				 
				motivoPlano = '".$Atendimentocliente->motivoPlano."' ,
				notaAtendimento = '".$Atendimentocliente->notaAtendimento."',
			
				debitoAutomatico = '".$Atendimentocliente->debitoAutomatico."', 
				debitoOfertado = '".$Atendimentocliente->debitoOfertado."',
				observacao = '".$Atendimentocliente->observacao."', 
				idVendaServico = '".$Atendimentocliente->idVendaServico."',
				notaAtendimento = '".$Atendimentocliente->notaAtendimento."',
			   FoiNaoConformidade = '".$Atendimentocliente->FoiNaoConformidade."'

				WHERE idChamada = ".$Atendimentocliente->idChamada;}

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or $_SESSION['msg'] = "Erro de SQL ao atualizar atendimento.$update_query";
			 
			$linhas=mysqli_affected_rows($this->conexao);
			if(($linhas>0) && (!isset($_SESSION['msg']))){
				enviaemail();
				$_SESSION['msg'] = "Atendimento atualizado com sucesso!$update_query";
				
			}elseif(($linhas<1) && (!isset($_SESSION['msg']))){
				$_SESSION['msg'] = "Nenhum registro foi atualizado.$update_query";
			}
			
						
						
 		}

 		/* Função para excluir uma entrada de atendimento do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM atendimentocliente WHERE idChamada = " . $id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or $_SESSION['msg'] = "Erro de SQL ao excluir atendimento.";

			$linhas=mysqli_affected_rows($this->conexao);
			if(($linhas>0) && (!isset($_SESSION['msg']))){
				$_SESSION['msg'] = "Atendimento excluído com sucesso!";
				
			}elseif(($linhas<1) && (!isset($_SESSION['msg']))){
				$_SESSION['msg'] = "Nenhum registro foi excluído.";
			}

 		}


 		/*  public function buscaPorId($id)*/
 		public function buscaPorId($id){
            
 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM atendimentocliente WHERE idChamada = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar produtos por ID: " . mysql_error() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				  $retorno = new Atendimentocliente();
 				//Preenche todos os campos do novo objeto
				  $retorno->idChamada = $row["idChamada"]; 
 				  $retorno->atendeu = $row["atendeu"];
				  $retorno->refProduto = $row["refProduto"];
				  $retorno->motivoPlano = $row["motivoPlano"];
				  $retorno->dataVencimento = $row["dataVencimento"];
				  $retorno->debitoAutomatico = $row["debitoAutomatico"];
				  $retorno->debitoOfertado= $row["debitoOfertado"];
				  $retorno->observacao = $row["observacao"];
				  $retorno->dataChamada = $row["dataChamada"];
				  $retorno->idVendaServico= $row["idVendaServico"];
				  $retorno->notaAtendimento = $row["notaAtendimento"];
				  $retorno->FoiNaoConformidade= $row["FoiNaoConformidade"];
				
				 

 				
 			}
 			
 			return $retorno;

		 }
		 public function buscaultimoid()
		 {
			 /* Primeiro cria a query do MySQL, fazendo select buscando a última chamada registrada */
 			$id_query = "SELECT idChamada, observacao FROM atendimentocliente order by idChamada desc limit 1";
            //
 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar produtos por ID: " . mysql_error() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				  $retorno = new Atendimentocliente();
 				//Preenche todos os campos do novo objeto
			
 				 
				  $retorno->idChamada = $row["idChamada"];
				  $retorno->observacao = $row["observacao"];
				 
 				
 			}
 			
 			return $retorno;
		 }

	

}

function enviaemail()
{      
	
	
	
	   date_default_timezone_set('America/Sao_Paulo');
	     
	    if(isset($_POST['atualizabotao'])){
			if(($_POST['selectNaoconf']=="1")){
			
			require_once 'classe-viewimportvendaservicoDAO.php';
			$recebe_atendimento=new Classe_AtendimentoCliente_DAO();
			$aux_atendimento=$recebe_atendimento->buscaPorId($_GET['idchamada']);
			$obj_chamada= new Viewimportvendaservico_DAO();
			$aux_chamada =  $obj_chamada->retornainfovenda($_GET['idvendaservico']);
			echo "<script type='text/javascript'>alert('Notificando a loja...');</script>";
			
			ob_start(); //Limpeza de texto
	    
			require_once ('PHPMailer.php');
			require_once ('SMTP.php');
			require_once ('Exception.php');
			require_once ('classe-funcionarioDAO.php');
			//Procura email para envio
			$obj_email= new Classe_Funcionario_DAO();
			$obj_vendedor= new Viewimportvendaservico_DAO();
			$aux_vendedor=$obj_vendedor->retornainfovenda($_GET['idvendaservico']);
			$aux_email=$obj_email->buscaPorId($aux_vendedor->vendedor);
             //busca realiza de email para envio
			$mail = new PHPMailer(true);
	        
			try {
				$mail->SMTPDebug = SMTP::DEBUG_SERVER;
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'qualidade.gmt@gmail.com';
				$mail->Password = 'qgmt2020';
				$mail->Port = 587;
	
				$mail->setFrom('qualidade.gmt@gmail.com');
				$mail->addAddress($aux_email->email);
				
				//$mail->addAddress('projetos1@grupominastelecom.com.br');
	
				$mail->isHTML(true);
				$dataatual=date('d/m/Y');
				$mail->Subject = "Não conformidade registrada - $dataatual" ;
				$mail->Body = "Nome Cliente: $aux_chamada->nomeCliente<br>
				Filial : $aux_chamada->nomeLoja<br>Venda realizada por : $aux_chamada->nomeFunc<br>
				Plano: $aux_chamada->plano<br>
				Valor: $aux_chamada->valorPlano<br>Data da venda: $aux_chamada->data<br>Acesso: $aux_chamada->acesso<br>
				Portabilidade: $aux_chamada->portabilidade<br>Observação :$aux_atendimento->observacao<br>";

				$mail->AltBody = "Nome Cliente: $aux_chamada->nomeCliente<br>
				Filial : $aux_chamada->nomeLoja<br>Venda realizada por : $aux_chamada->nomeFunc<br>
				Plano: $aux_chamada->plano<br>
				Valor: $aux_chamada->valorPlano<br>Data da venda: $aux_chamada->data<br>Acesso: $aux_chamada->acesso<br>
				Portabilidade: $aux_chamada->portabilidade<br>Observação :$aux_atendimento->observacao<br>";
	
				if($mail->send()) {
					echo 'Email enviado com sucesso';
					
				} else {
					echo 'Email nao enviado';
					
				}
			} catch (Exception $e) {
				echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
			 } 
			 ob_end_clean();	}
			}
		  else if(isset($_POST['enviabotao']))
		{   
			if(($_POST['selectNaoconf']=="1")){
			require_once 'classe-viewimportvendaservicoDAO.php';
			
			$recebe_atendimento=new Classe_AtendimentoCliente_DAO();
			$aux_atendimento=$recebe_atendimento->buscaultimoid();
			//echo "<script type='text/javascript'>alert('$aux_atendimento->idChamada');</script>";
			$obj_chamada= new Viewimportvendaservico_DAO();
			$aux_chamada =  $obj_chamada->retornainfovenda($_GET['idvendaservico']);
			echo "<script type='text/javascript'>alert('Notificando a loja...');</script>";
			
			
	
			//require_once 'classe-importvendaservicoDAO.php';
			//$recebe_atendimento=new Classe_ImportVendaServico_DAO();
			//if(($_SESSION['obsconfirm'])==1){
			//$aux_atendimento=$recebe_atendimento->retornaobs($_GET['idvendaservico']);
			//echo "<script type='text/javascript'>alert('$aux_atendimento->observacao');</script>";
			//$_SESSION['obsconfirm']=0;}
			ob_start(); //Limpeza de texto
	    
			require_once ('PHPMailer.php');
			require_once ('SMTP.php');
			require_once ('Exception.php');
			require_once ('classe-funcionarioDAO.php');
			//Procura email para envio
			$obj_email= new Classe_Funcionario_DAO();
			$obj_vendedor= new Viewimportvendaservico_DAO();
			$aux_vendedor=$obj_vendedor->retornainfovenda($_GET['idvendaservico']);
			$aux_email=$obj_email->buscaPorId($aux_vendedor->vendedor);
			 //busca realiza de email para envio
			$mail = new PHPMailer(true);
	
			try {
				$mail->SMTPDebug = SMTP::DEBUG_SERVER;
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'qualidade.gmt@gmail.com';
				$mail->Password = 'qgmt2020';
				$mail->Port = 587;
	
				$mail->setFrom('qualidade.gmt@gmail.com');
				$mail->addAddress($aux_email->email);
				
				//$mail->addAddress('projetos1@grupominastelecom.com.br');
	
				$mail->isHTML(true);
				$dataatual=date('d/m/Y');
				$mail->Subject = "Não conformidade registrada - $dataatual";

				$mail->Body = "Nome Cliente: $aux_chamada->nomeCliente<br>
				Filial : $aux_chamada->nomeLoja<br>Venda realizada por : $aux_chamada->nomeFunc<br>
				Plano: $aux_chamada->plano<br>
				Valor: $aux_chamada->valorPlano<br>Data da venda: $aux_chamada->data<br>Acesso: $aux_chamada->acesso<br>
				Portabilidade: $aux_chamada->portabilidade<br>Observação :$aux_atendimento->observacao<br>";

				$mail->AltBody = "Nome Cliente: $aux_chamada->nomeCliente<br>
				Filial : $aux_chamada->nomeLoja<br>Venda realizada por : $aux_chamada->nomeFunc<br>
				Plano: $aux_chamada->plano<br>
				Valor: $aux_chamada->valorPlano<br>Data da venda: $aux_chamada->data<br>Acesso: $aux_chamada->acesso<br>
				Portabilidade: $aux_chamada->portabilidade<br>Observação :$aux_atendimento->observacao<br>";
	
				if($mail->send()) {
					echo 'Email enviado com sucesso';
					
				} else {
					echo 'Email nao enviado';
					
				}
			} catch (Exception $e) {
				echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
			 } 
			 ob_end_clean();	}
		}
		  
	   
} 
?>