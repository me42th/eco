<?php
namespace main\Model;

use \main\DB\Sql;
use \main\Model;
use \main\Mailer;

define('SECRET_IV', pack('a16','senha'));
define('SECRET', pack('a16','senha'));
date_default_timezone_set('America/Bahia');    

class User extends Model{

    const SESSION = "User";
    
    public static function find_by_session(){
        $user = array();
        if(isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION] > 0){
            $user = $_SESSION[User::SESSION];
        }
        return $user;
    }

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

    public function del(){
        $sql = new Sql();
        $sql->query("delete from tb_persons where idperson = :idperson;",array(":idperson"=>$this->getidperson()));
        echo 'a';
        $sql->query("delete from tb_users where iduser = :iduser;",array(":iduser"=>$this->getiduser()));
    }

    public function update($data = null)
    {
        $sql = new Sql();
        $deslogin = $data['deslogin'];
        $despassword = isset($data['despassword'])?User::paz_sword_cripta($data['despassword']):$this->getdespassword();
        $inadmin = isset($data['inadmin'])?1:0;
        $sql->query("update tb_users set deslogin = :deslogin, despassword = :despassword, inadmin = :inadmin where iduser = :iduser;",array(":deslogin" => $deslogin,":despassword" => $despassword,":inadmin" => $inadmin,":iduser" => $this->getiduser()));
        $desperson = $data['desperson'];
        $desemail = $data['desemail'];
        $nrphone = $data['nrphone'];
        $sql->query("update tb_persons set desperson = :desperson, desemail = :desemail, nrphone = :nrphone where idperson = :idperson;",array(":desperson" => $desperson,":desemail" => $desemail,":nrphone" => $nrphone,":idperson" => $this->getidperson()));


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

    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
    }

    public static function find($id){
        $sql = new Sql();
        return $sql->select("select * from tb_users join tb_persons on tb_users.idperson = tb_persons.idperson where iduser = $id")[0];
         
    }

    public static function create_person($data){
        $sql = new Sql();
        $desperson = $data["desperson"];
        $desemail = $data["desemail"];
        $nrphone = $data["nrphone"];        
        $sql->query("insert into tb_persons values (default,'$desperson','$desemail','$nrphone',default);");
        return $sql->select('select max(idperson) from tb_persons;')[0]["max(idperson)"];
    
    }

    public static function create_user($data){
        $sql = new Sql();
        $idperson = User::create_person($data);
        $deslogin = $data['deslogin'];
        $despassword = User::paz_sword_cripta($data['despassword']);
        $inadmin = isset($data['inadmin'])?1:0;
        $sql->select("insert into tb_users values (default,'$idperson','$deslogin','$despassword','$inadmin',default);");

    }

    public static function getForgot($email){
        $sql = new Sql;
        if(count($sql->select("select * from tb_persons where desemail = '$email';") > 0)){
            $user = new User; 
            $user->setdata( $sql->select("select * from tb_persons a join tb_users b on a.idperson = b.idperson where desemail = '$email';")[0]);
            //captura os dados do cliente solicitante
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $user_id = $user->getiduser();
            //registra a solicitação na tabela de log
            $sql->query("insert into tb_userspasswordsrecoveries values (default,'$user_id','$user_ip',null,default);");
            $log_id = $sql->select("select max(idrecovery) from tb_userspasswordsrecoveries;")[0]["max(idrecovery)"];
            //gera a url com o codigo cifrado
            $code = User::ssl_crypt(array("log" => $log_id,"user" => $user_id));
            $link = "http://localhost/eco/index.php/admin/forgot/reset/".$code;
            $mailer = new Mailer($user->getdesemail(),$user->getdesperson(),"Rec de Senha","forgot",array('name'=>$user->getdesperson(),'link'=>$link));
            $mailer->send();
            return $user;
            

        }else{
            echo "email inválido";
        };
    }

    public static function verifyCode($code){
        if(User::ssl_decrypt($code)) return true;
        else return false;
    }

    public static function verifyTimeCode($code){
        $log = json_decode(User::ssl_decrypt($code),true)['log'];
        $sql = new Sql;
        $log = $sql->select("select * from tb_userspasswordsrecoveries where idrecovery = '$log';")[0];
        $time_log = $log['dtregister'];
        $use_time_log = !isset($log['dtrecovery']);
       

        if((time()-strtotime($time_log))/3600 < 1)
            return ((bool)true*$use_time_log);
        return false;          
    }

    public static function paz_sword_update($code,$paz_sword){
       $sql = new Sql;
       $user_id = json_decode(User::ssl_decrypt($code),true)['user'];
       $log_id = json_decode(User::ssl_decrypt($code),true)['log'];
       $paz_sword = User::paz_sword_cripta($paz_sword);
       $now = date('Y-m-d H:i:s',time());
       $sql->select("update tb_users set despassword = '$paz_sword' where iduser = '$user_id';");
       $sql->select("update tb_userspasswordsrecoveries set dtrecovery = '$now' where idrecovery = '$log_id';");
        
    }

    public static function ssl_decrypt($data){


        $open_ssl = openssl_decrypt(
            base64_decode($data), //dados que serão encriptados
            'AES-128-CBC',      //algoritmo
            SECRET,             //chave    
            0,                  //...
            SECRET_IV           //chave II
        );        
        return $open_ssl;
    }    

    private static function ssl_crypt($data){
                
        $open_ssl = openssl_encrypt(
            json_encode($data), //dados que serão encriptados
            'AES-128-CBC',      //algoritmo
            SECRET,             //chave    
            0,                  //...
            SECRET_IV           //chave II
        );        
        return base64_encode($open_ssl);
    }

    private static function paz_sword_cripta($password){
        return password_hash($password, PASSWORD_DEFAULT, [
            "cost"=>12
        ]);
    }
}

?>