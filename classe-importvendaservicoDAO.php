<?php
//session_start();
/* Inclui bibliotecas de classes */
include 'classe-importvendaservico.php';
include_once "config.php";


class Classe_ImportVendaServico_DAO{

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

 	
 		public function retornainfovenda($id){

			/* Primeiro cria a query do MySQL */
			$list_query = "SELECT nomeCliente,valorPlano,plano,data FROM importvendaservico WHERE idVendaServico=".$id;
            /* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar atendimentos por ID: " . mysqli_query() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Importvendaservico();
 				//Preenche todos os campos do novo objeto
				 $retorno->nomeCliente = $row["nomeCliente"];
				 $retorno->valorPlano = $row["valorPlano"];
				 $retorno->plano = $row["plano"];
				 $retorno->data = $row["data"];
				 //$retorno->observacao = $row["observacao"];
                 //$retorno->idVendaServico = $row["idVendaServico"];
 			}
 			
 			return $retorno;

	

		}
		
		


} 
?>