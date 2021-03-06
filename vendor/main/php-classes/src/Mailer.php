<?php
namespace main;

use Rain\Tpl;

class Mailer{

    const EMAIL = "me42th@gmail.com";
    const NAME = 'me42th';
    const PAZ_SWORD = 'deadcafe';

    private $mail;
    
    
    public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
    {

        $config = array(
            //configuro a pasta de views
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/eco/views/email/",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/eco/views-cache/store/",
            "debug"         => false // set to false to improve the speed
            );
        Tpl::configure( $config );
        $tpl = new Tpl;    
        foreach($data as $key => $value){
            $tpl->assign($key,$value);
        }

        $html = $tpl->draw($tplName,true);


        $this->mail = new \PHPMailer;

        //Tell PHPMailer to use SMTP
        $this->mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->mail->SMTPDebug = 0;
        //Set the hostname of the mail server
        $this->mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $this->mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $this->mail->Username = Mailer::EMAIL;
        //Password to use for SMTP authentication
        $this->mail->Password = Mailer::PAZ_SWORD;
        //Set who the message is to be sent from
        $this->mail->setFrom(Mailer::EMAIL, Mailer::NAME);
        //Set an alternative reply-to address
        $this->mail->addReplyTo('david.meth@live.com', 'David Meth');
        //Set who the message is to be sent to
        $this->mail->addAddress($toAddress, $toName);
     
        //Set the subject line
        $this->mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $this->mail->msgHTML($html);
        //Replace the plain text body with one created manually
        $this->mail->AltBody = 'Email Alternativo';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        //send the message, check for errors
       

    }

    public function send(){
        return $this->mail->send();
    }

}

?>