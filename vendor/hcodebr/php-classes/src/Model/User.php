<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model{

	const SESSION = "User";

	public static function login($login, $password)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));

		if(count($results) === 0){

			throw new \Exception("Usuário inexistente ou senha inválida.");
			
		}

		$data = $results[0];

		if (password_verify($password, $data["despassword"]) === true) {

			$user = new User();

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {
			throw new \Exception("Usuário inexistente ou senha inválida.");
		}

	}

	public static function verifyLogin($inadmin = true)
	{
		if(
			!isset($_SESSION[User::SESSION]) //verifica se foi definida uma seção
			||
			!$_SESSION[User::SESSION] //verifica quanto ao preenchimento da variável de seção
			||
			!(int)$_SESSION[User::SESSION]['iduser'] > 0 //A recuperação do valor da variável de seção, e vazia, quando transformada para um tipo inteiro retorna 0, portanto, verificar o preenchimento aqui é equivalente a verificar se é maior que zero
			||
			(bool)$_SESSION[User::SESSION]['inadmin'] !== $inadmin //verifica se o usuário autenticado tem permissão de administrador. O campo 'inadmin' do banco é preenchido com 1 para permissão de administrador ou 0 para usuário comum, quando transformado para booleano, 1 equivale a true e 0 a false

			//passa desse teste, então, o usuário 
		) {
			header("Location: /admin/login");
			exit;
		}
	}

	public static function logout()
	{
		$_SESSION[User::SESSION] = NULL;
	}

}

?>