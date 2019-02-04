<?php
namespace main\Model;

use \main\DB\Sql;
use \main\Model;

class User extends Model{

    const SESSION = "User";

    public static function verifyLogin(){
        //verifico se existe uma sessão para aquele cliente
        if(
                //verifico se a sessão existe 
            !isset($_SESSION[User::SESSION])
            ||  //sessão vazia
            !$_SESSION[User::SESSION]
            ||  //valida id
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||  //verifico se user é admin
            !(bool)$_SESSION[User::SESSION]["inadmin"]
            )
        {
            //redireciono para a tela de login
            header("Location: /eco/index.php/admin/login");
        exit;    
        } 
    }

    public static function logout(){
        $_SESSION[User::SESSION] = null;
    }

    public static function login($login,$password)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN",array(":LOGIN" => $login));

        if(count($results) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }

        $data = $results[0];

        if(password_verify($password, $data['despassword']))
        {
            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getData();
            
            return $user;
        }
        else
        {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }

    }
}
?>