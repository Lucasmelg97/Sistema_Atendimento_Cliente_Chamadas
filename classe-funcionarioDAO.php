<?php
session_start();
/* Inclui bibliotecas de classes */
include 'classe-funcionario.php';
include_once "config.php";


class Classe_Funcionario_DAO{

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

 		/*Função para inserir novo produto na tabela produto do banco de dados*/
 		public function inserir($Func){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO funcionarios (idFunc, nomeFunc, cpfFunc, idLojaFunc, funcaoFunc, ativo) VALUES (DEFAULT,'".$Func->nomeFunc."','".$Func->cpfFunc."',".$Func->idLojaFunc.",".$Func->funcaoFunc.",".$Func->ativo.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir funcionário: " . mysql_error() );

 		}

 		/* Função para atualizar os dados de um dos produtos já cadastrados */
 		public function atualizar($Func){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE funcionarios SET nomeFunc = '".$Func->nomeFunc."', cpfFunc = '".$Func->cpfFunc."', idLojaFunc = ".$Func->idLojaFunc.", funcaoFunc = ".$Func->funcaoFunc.", ativo = ".$Func->ativo." WHERE idFunc = ".$Func->idFunc;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar funcionário: " . mysql_error() );
 							
 		}

 		/* Função para excluir uma entrada de produto do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM funcionarios WHERE idFunc = " . $id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir funcionário: " . mysql_error() );

 		}


		 /* Função que retorna posição de determinado ID dentro de um select em ordem alfabética */
 		public function posicaoSelect($id){

			/* Primeiro cria a query do MySQL */
			$list_query = "SELECT * FROM funcionarios ORDER BY nomeFunc";

			/* Envia a query para o banco de dados e verifica se funcionou */
			$result = mysqli_query($this->conexao, $list_query)
			or die("Erro ao listar funcionário: ");

			$i = 0;
			$j = 0;
			/* Loop que que vai pegando linha por linha do resultado obtido */
			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
				$i = $i + 1;
				if($id == $row["idFunc"]){
					$j = $i;
				}
			}
			
			return $j;

		}

 		/* Função que lista todos os produtos e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM funcionarios ORDER BY nomeFunc";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar funcionários: " . mysql_error() );

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Produto
 				$retorno = new Funcionario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idFunc = $row["idFunc"];
 				$retorno->nomeFunc = $row["nomeFunc"];
 				$retorno->cpfFunc = $row["cpfFunc"];
				 $retorno->idLojaFunc = $row["idLojaFunc"];
				 $retorno->funcaoFunc = $row["funcaoFunc"];
				 $retorno->ativo = $row["ativo"];
			
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

		 }

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM funcionarios WHERE idFunc = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar funcionario por ID: " . mysql_error() );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Funcionario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idFunc = $row["idFunc"];
 				$retorno->nomeFunc = $row["nomeFunc"];
 				$retorno->cpfFunc = $row["cpfFunc"];
				$retorno->idLojaFunc = $row["idLojaFunc"];
				$retorno->funcaoFunc = $row["funcaoFunc"];
				$retorno->ativo = $row["ativo"];
				$retorno->email = $row ["email"];

 			}
 			
 			return $retorno;

 		}

}
?>