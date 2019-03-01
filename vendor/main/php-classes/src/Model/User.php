<?php

//mysql> desc tb_users;
//+-------------+--------------+------+-----+-------------------+----------------+
//| Field       | Type         | Null | Key | Default           | Extra          |
//+-------------+--------------+------+-----+-------------------+----------------+
//| iduser      | int(11)      | NO   | PRI | NULL              | auto_increment |
//| idperson    | int(11)      | NO   | MUL | NULL              |                |
//| deslogin    | varchar(64)  | NO   |     | NULL              |                |
//| despassword | varchar(256) | NO   |     | NULL              |                |
//| inadmin     | tinyint(4)   | NO   |     | 0                 |                |
//| dtregister  | timestamp    | NO   |     | CURRENT_TIMESTAMP |                |
//+-------------+--------------+------+-----+-------------------+----------------+

//mysql> show tables;
//+-----------------------------+
//| Tables_in_db_ecommerce      |
//+-----------------------------+
//| tb_addresses                |
//| tb_carts                    |
//| tb_cartsproducts            |
//| tb_categories               |
//| tb_orders                   |
//| tb_ordersstatus             |
//| tb_persons                  |
//| tb_products                 |
//| tb_productscategories       |
//| tb_users                    |
//| tb_userslogs                |
//| tb_userspasswordsrecoveries |
//+-----------------------------+

namespace main\Model;

use \main\DB\Sql;
use \main\Model;
use \main\Mailer;
use \main\Validate;

define('SECRET_IV', pack('a16','senha'));
define('SECRET', pack('a16','senha'));
date_default_timezone_set('America/Bahia');    

class User extends Model{

    const SESSION = "User";
    const RULES = [
                        "deslogin" =>   [
                                            "unique" => [
                                                            "msg" => "LOGIN EM USO",
                                                            "table" => "tb_users",
                                                            "field" => "deslogin"
                                                        ],
                                            "required"=>[
                                                            "msg" => "O LOGIN É UM CAMPO OBRIGATORIO"
                                                        ]                        
                                        ],
                        "nrphone" =>    [
                                            "number"=>  [     
                                                            "msg" => "INFORME UM NUMERO DE TELEFONE VÁLIDO"
                                                        ],
                                            "required"=>[
                                                "msg" => "O TELEFONE É UM CAMPO OBRIGATORIO"
                                            ]            
                                        ],
                        "desperson" =>  [
                                            "regex"=>   [
                                                            "msg" => "INFORME APENAS LETRAS NO CAMPO NOME",
                                                            "rule"=> ".*"
                                                        ],
                                            "required"=>[
                                                            "msg" => "O NOME É UM CAMPO OBRIGATORIO"
                                                        ]
                                        ],
                        "despassword" =>   [
                                            "regex"=> [
                                                            "msg" => "SENHA INVÁLIDA",
                                                            "rule" => ".*"
                                                        ],
                                            "required"=>[
                                                            "msg" => "A SENHA É UM CAMPO OBRIGATÓRIO"
                                                        ]
                                            ],
                                        "desemail" =>   [
                                            "email"=>[
                                                            "msg" => "INFORME UM EMAIL VALIDO"
                                            ],
                                            "unique"=> [
                                                            "msg" => "EMAIL EM USO",
                                                            "table" => "tb_persons",
                                                            "field" => "desemail"
                                                        ],
                                            "required"=>[
                                                            "msg" => "O EMAIL É UM CAMPO OBRIGATORIO"
                                                        ]
                                        ]                
                    ];
    /** 
     * Essa função valida os dados antes de serem salvos no banco. As regras estão escritas na constante RULE. 
     * Se for uma verificação para um usuário existente o id deste usuário deve ser passado, se for um objeto novo
     * nada deve ser informado.
    */
    public static function validate($data,$iduser = null){
        if(isset($iduser)){
            $data_from_db = USER::find($iduser);
            foreach($data as $key => $value){
                if($value == $data_from_db[$key])
                    unset($data[$key]);
            }
        }        
        $validator = new Validate(User::RULES);        
        $validator->you_shall_not_pass($data);
    }

    /** 
     * Retorna os dados do usuário logado que está armazenado na Session,
    */
    public static function find_by_session(){
        $user = array();
        if(isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION] > 0){
            $user = $_SESSION[User::SESSION];
        }
        return $user;
    }

    /**
     * Esta classe verifica se há um usuário logado e por padrão verifica se é um usuário admin.
     * Caso seja um usuário sem provilégios deverá ser informado false ao invocar a função.
    */
    public static function check_login($inadmin = true){
        
        //verifico se existe uma sessão para aquele cliente
        if(
            //verifico se a sessão existe 
            !isset($_SESSION[User::SESSION])
            ||  //sessão vazia
            !$_SESSION[User::SESSION]
            ||  //valida id
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
        ){ 
             //ñ ta logado
            return false;
        //verifico se o usuário está em área administrativa    
        }else if($inadmin === true){
            if((bool)$_SESSION[User::SESSION]["inadmin"] === true)
                return true;
            else
                return false;
        }
            return true; 
    }

    /** 
     * Verifica se há um usuário logado, com ou sem privilégios administrativos 
    */
    public static function verify_login(){
   
        if(!User::check_login(false))
        {   
            //redireciono para a tela de login
            header("Location: /eco/index.php/login");
            exit;                  
        }    
    }

    /** 
     * Verifica se há um usuário logado com privilégios administrativos 
    */
    public static function verify_admin_login(){
        
        if(!User::check_login(true))
        {     
            //redireciono para a tela de login
            header("Location: /eco/index.php/admin/login");
            exit;                  
        } 
    }

    /** 
     * Desligo o usuário do sistema 
    */
    public static function logout(){
        $_SESSION[User::SESSION] = null;
    }

    /** 
     *  CRUD: Deleto o usuário e seus dados pessoais
    */
    public function del(){
        $sql = new Sql();
        $sql->query("delete from tb_persons where idperson = :idperson;",array(":idperson"=>$this->getidperson()));
        $sql->query("delete from tb_users where iduser = :iduser;",array(":iduser"=>$this->getiduser()));
    }

    /** 
     *  CRUD: Atualizo o usuário e seus dados pessoais, validate deve ser invocada antes desta função
    */
    public function update($data = null)
    {
        $sql = new Sql();
        $deslogin = isset($data['deslogin'])?$data['deslogin']:$this->getdeslogin();
        $despassword = isset($data['despassword'])?User::paz_sword_cripta($data['despassword']):$this->getdespassword();
        $inadmin = isset($data['inadmin'])?1:0;
        $sql->query("update tb_users set deslogin = :deslogin, despassword = :despassword, inadmin = :inadmin where iduser = :iduser;",array(":deslogin" => $deslogin,":despassword" => $despassword,":inadmin" => $inadmin,":iduser" => $this->getiduser()));
        $desperson = $data['desperson'];
        $desemail = $data['desemail'];
        $nrphone = $data['nrphone'];
        $sql->query("update tb_persons set desperson = :desperson, desemail = :desemail, nrphone = :nrphone where idperson = :idperson;",array(":desperson" => $desperson,":desemail" => $desemail,":nrphone" => $nrphone,":idperson" => $this->getidperson()));


    }
    
    /**
     * Logo o usuário no sistema
     */
    public static function login($login,$password)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN",array(":LOGIN" => $login));
        if(count($results) === 0)
        {
            throw new \Exception("A Usuário inexistente ou senha inválida");
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
            throw new \Exception("O Usuário inexistente ou senha inválida");
        }

    }

     /** 
     * Lista todos os usuários cadastrados com respectivos dados pessoais 
     */
    public static function listAll(){
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
    }

    /** 
     * Localiza um usuário cadastrado e seus dados cadastrados apartir de seu id
     */
    public static function find($id){
        $sql = new Sql();
        return $sql->select("select * from tb_users join tb_persons on tb_users.idperson = tb_persons.idperson where iduser = $id")[0];
         
    }

   /** 
    *  CRUD: Insere no banco os dados pessoais, validate deve ser invocada antes desta função
    */
    public static function create_person($data){
        $sql = new Sql();
        $desperson = $data["desperson"];
        $desemail = $data["desemail"];
        $nrphone = $data["nrphone"];        
        $sql->query("insert into tb_persons values (default,'$desperson','$desemail','$nrphone',default);");
        return $sql->select('select max(idperson) from tb_persons;')[0]["max(idperson)"];
    
    }

    /** 
     *  CRUD: Insere no banco os dados referentes ao usuário, validate deve ser invocada antes desta função
     */
    public static function create_user($data){
        $sql = new Sql();
        $idperson = User::create_person($data);
        $deslogin = $data['deslogin'];
        $despassword = User::paz_sword_cripta($data['despassword']);
        $inadmin = isset($data['inadmin'])?1:0;
        $sql->select("insert into tb_users values (default,'$idperson','$deslogin','$despassword','$inadmin',default);");

    }

    /** 
     * Dispara um email para o usuário recuperar a senha, o token é composto pelo 
     * id do log e do usuário cifrados com ssl  
     */
    public static function getForgot($email){
        $sql = new Sql;
        if(isset($sql->select("select * from tb_persons where desemail = '$email';")[0])){           
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
            $link = "http://localhost/eco/index.php".($user->getinadmin()==1?'/admin':'')."/forgot/reset/".$code;
            $mailer = new Mailer($user->getdesemail(),$user->getdesperson(),"SENHA","forgot",array('name'=>$user->getdesperson(),'link'=>$link));
            $mailer->send();
            return $user;           

        }else{
            throw new \Exception("EMAIL INVÁLIDO");
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