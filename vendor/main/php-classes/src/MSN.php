<?php
namespace main;

/*
    Classe responsável pelo envio de mensagens via sessão pelas diferentes partes da aplicação
*/

class MSN{

    const SESSION_ERROR = 'ERROR_MSG';
    const SESSION_ALERT = 'ALERT_MSG';
    const SESSION_SUCCESS = 'SUCCESS_MSG';

    public static function set_error_msg($msg){ 
        $_SESSION[MSN::SESSION_ERROR] = $msg;
    }

    public static function set_alert_msg($msg){ 
        $_SESSION[MSN::SESSION_ALERT] = $msg;
    }

    public static function set_success_msg($msg){ 
        $_SESSION[MSN::SESSION_SUCCESS] = $msg;
    }

    public static function del_error_msg(){ 
        $_SESSION[MSN::SESSION_ERROR] = null;
    }

    public static function del_alert_msg(){ 
        $_SESSION[MSN::SESSION_ALERT] = null;
    }

    public static function del_success_msg(){ 
        $_SESSION[MSN::SESSION_SUCCESS] = null;
    }

     //caso não informe false como argumento ele destroi a mensagem após a leitura
    public static function get_error_msg($del = true){ 
        $msg = isset($_SESSION[MSN::SESSION_ERROR])?$_SESSION[MSN::SESSION_ERROR]:false;
        if($del) MSN::del_error_msg();
        return $msg;
    }

    //caso não informe false como argumento ele destroi a mensagem após a leitura
    public static function get_alert_msg($del = true){ 
        $msg = isset($_SESSION[MSN::SESSION_ALERT])?$_SESSION[MSN::SESSION_ALERT]:false;
        if($del) MSN::del_alert_msg();
        return $msg;
    }

     //caso não informe false como argumento ele destroi a mensagem após a leitura
    public static function get_success_msg($del = true){ 
        $msg = isset($_SESSION[MSN::SESSION_SUCCESS])?$_SESSION[MSN::SESSION_SUCCESS]:false;
        if($del) MSN::del_success_msg();
        return $msg;    
    }

    
}

?>