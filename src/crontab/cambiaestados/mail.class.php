<?php
require_once "config.php";
require_once LIB_MAIL_DEMO;		
class envio_mail{

private $_host;	
private $_user;	
private $_pass;

//Peques831979.
//function __construct($host='mail.administracionpublica.gob.ec',$user='intranet@administracionpublica.gob.ec',$pass='@Intranet.89!')
	function __construct($host='mail.mdi.gob.ec',$user='seguimiento',$pass='Segu1m1ent@')
 	{
		$this->_host=$host;
		$this->_user=$user;
		$this->_pass=$pass;		
 	}
	public function envio($from,$fromname,$maildestinatario,$nombredestinatario,$subject,$mensaje,$archivoadjunto,$nombrearchivoadjunto,$mailCC='',$mailCC1='',$nombreCC1='',$archivoadjunto1,$nombrearchivoadjunto1,$mailCC2=''){
		$mail = new PHPMailer;
		$mail->SMTPDebug  = 0;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
		$mail->Host = $this->_host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $this->_user; // SMTP username
		$mail->Password = $this->_pass;                         // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                     // TCP port to connect to
		
		$mail->From = $from;
		$mail->FromName = utf8_decode($fromname);
		$mail->addAddress($maildestinatario, utf8_decode($nombredestinatario) );     // Add a recipient
		//$mail->addAddress('jonatan.diaz@administracionpublica.gob.ec', utf8_decode('Diego Díaz') );     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo($from, utf8_decode($fromname));
		if($mailCC!=""){
			//$mail->addCC($mailCC,utf8_decode($fromname));               // Name is optional
			//$mail->addBCC($mailCC);
			$mail->addCC($mailCC);
		}
		if($mailCC1!=""){
			$mail->addCC($mailCC1,utf8_decode($nombreCC1));               // Name is optional
			//$mail->addBCC($mailCC);
			//$mail->addCC($mailCC);
		}
		if($mailCC2!=""){
			$mail->addCC($mailCC2,utf8_decode($nombreCC2));               // Name is optional
			//$mail->addBCC($mailCC);
			//$mail->addCC($mailCC);
		}
		//$mail->addBCC('bcc@example.com');
		
		//$mail->addAttachment('/var/www/html/portalweb/envio_demo/nomina/2014/DICIEMBRE/001-C-1715922959.pdf');
		if($archivoadjunto!=""){
			$mail->addAttachment($archivoadjunto,$nombrearchivoadjunto);
		}
		if($archivoadjunto1!=""){
			$mail->addAttachment($archivoadjunto1,$nombrearchivoadjunto1);
		}
        // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject=utf8_decode($subject);
		//$mail->Subject = 'SEÑOR(A) '.(utf8_decode($nombredestinatario));
		$mail->Body    = utf8_decode($mensaje);
		//$mail->AltBody = utf8_decode($mensaje);
		
//		$mail->Body    = utf8_decode('Adjunto el formulario 107 "COMPROBANTE DE RETENCIONES EN LA FUENTE DEL IMPUESTO A LA RENTA POR INGRESOS DEL TRABAJO EN RELACIÓN DE DEPENDENCIA" correspondiente al año 2014.<br>Dicho documento legalizado se encargara de enviar la dirección Administrativa Financiera una vez firmado por el Agente de Retención y la Contadora<br>Saludos Cordiales<br>Dirección de Talento Humano');
	//	$mail->AltBody = utf8_decode('Adjunto el formulario 107 "COMPROBANTE DE RETENCIONES EN LA FUENTE DEL IMPUESTO A LA RENTA POR INGRESOS DEL TRABAJO EN RELACIÓN DE DEPENDENCIA" correspondiente al año 2014.');
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		/* else {
			echo 'Message has been sent';
		}*/


	}

    public function envio_copia($from,$fromname,$maildestinatario,$nombredestinatario,$subject,$mensaje,$mailCopia){
        $mail = new PHPMailer;
        $mail->SMTPDebug  = 0;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Host = $this->_host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $this->_user; // SMTP username
        $mail->Password = $this->_pass;                         // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                     // TCP port to connect to

        $mail->From = $from;
        $mail->FromName = utf8_decode($fromname);
        $mail->addAddress($maildestinatario, utf8_decode($nombredestinatario) );     // Add a recipient
        //$mail->addAddress('jonatan.diaz@administracionpublica.gob.ec', utf8_decode('Diego Díaz') );     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo($from, utf8_decode($fromname));
        foreach ($mailCopia as &$valor) {
            if ($valor!=""){
                $mail->addCC($valor);
            }
        }
        /*if($mailCopia!=""){
            //$mail->addCC($mailCC,utf8_decode($fromname));               // Name is optional
            //$mail->addBCC($mailCC);
            $mail->addCC($mailCopia);
        }*/

        //$mail->addBCC('bcc@example.com');

        //para añadir archivos adjuntos
        /*if($archivoadjunto!=""){
            $mail->addAttachment($archivoadjunto,$nombrearchivoadjunto);
        }*/

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject=utf8_decode($subject);
        //$mail->Subject = 'SEÑOR(A) '.(utf8_decode($nombredestinatario));
        $mail->Body    = utf8_decode($mensaje);
        //$mail->AltBody = utf8_decode($mensaje);

//		$mail->Body    = utf8_decode('Adjunto el formulario 107 "COMPROBANTE DE RETENCIONES EN LA FUENTE DEL IMPUESTO A LA RENTA POR INGRESOS DEL TRABAJO EN RELACIÓN DE DEPENDENCIA" correspondiente al año 2014.<br>Dicho documento legalizado se encargara de enviar la dirección Administrativa Financiera una vez firmado por el Agente de Retención y la Contadora<br>Saludos Cordiales<br>Dirección de Talento Humano');
        //	$mail->AltBody = utf8_decode('Adjunto el formulario 107 "COMPROBANTE DE RETENCIONES EN LA FUENTE DEL IMPUESTO A LA RENTA POR INGRESOS DEL TRABAJO EN RELACIÓN DE DEPENDENCIA" correspondiente al año 2014.');
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        /* else {
            echo 'Message has been sent';
        }*/


    }


	 function  __destruct() {
	  	$this->_host='';
		$this->_user='';
		$this->_pass='';	
  }
  
  
  
 public function envio_cco($from,$fromname,$maildestinatario,$nombredestinatario,$subject,$mensaje,$archivoadjunto,$nombreadjunto){
		$mail = new PHPMailer;
		$mail->SMTPDebug  = 0;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $this->_host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = false;                               // Enable SMTP authentication
		$mail->Username = $this->_user; // SMTP username
		//$mail->Password = $this->_pass;                         // SMTP password
		//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;                                    // TCP port to connect to
		
		$mail->From = $from;
		$mail->FromName = utf8_decode($fromname);
		//$mail->addAddress($maildestinatario, utf8_decode($nombredestinatario) );     // Add a recipient
		//$mail->addAddress('jonatan.diaz@administracionpublica.gob.ec', utf8_decode('Diego Díaz') );     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addReplyTo($from, utf8_decode($fromname));
		
		$mail->addBCC($maildestinatario,utf8_decode($nombredestinatario));
		
		//$mail->addAttachment('/var/www/html/portalweb/envio_demo/nomina/2014/DICIEMBRE/001-C-1715922959.pdf');
		// Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		if($archivoadjunto!=""){
			$mail->addAttachment('/var/www/html/portalweb/tecnologia/src/contenido/adjuntos/'.$archivoadjunto,$nombreadjunto);
		}

		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject=utf8_decode($subject);
		//$mail->Subject = 'SEÑOR(A) '.(utf8_decode($nombredestinatario));
		$mail->Body    = utf8_decode($mensaje);
		//$mail->AltBody = utf8_decode($mensaje);

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		/* else {
			echo 'Message has been sent';
		}*/


	}


 public function envio_vinculacion($from,$fromname,$maildestinatario1,$nombredestinatario1,$maildestinatario2,$nombredestinatario2,$maildestinatario3,$nombredestinatario3,$subject,$mensaje,$maildestinatario4,$nombredestinatario4){
		$mail = new PHPMailer;
		$mail->SMTPDebug  = 0;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $this->_host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = false;                               // Enable SMTP authentication
		$mail->Username = $this->_user; // SMTP username
		//$mail->Password = $this->_pass;                         // SMTP password
		//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;                                    // TCP port to connect to
		
		$mail->From = $from;
		$mail->FromName = utf8_decode($fromname);
		//$mail->addAddress($maildestinatario, utf8_decode($nombredestinatario) );     // Add a recipient
		//$mail->addAddress('jonatan.diaz@administracionpublica.gob.ec', utf8_decode('Diego Díaz') );     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo($from, utf8_decode($fromname));
		
		$mail->addAddress($maildestinatario1,utf8_decode($nombredestinatario1));
		$mail->addAddress($maildestinatario2,utf8_decode($nombredestinatario2));
		if($maildestinatario3!=""){
			$mail->addAddress($maildestinatario3,utf8_decode($nombredestinatario3));
		}
		if($maildestinatario4!=""){
			$mail->addAddress($maildestinatario4,utf8_decode($nombredestinatario4));
		}
		//$mail->addBCC($maildestinatario,utf8_decode("jonatan.diaz@administracionpublica.gob.ec"));
		
		//$mail->addAttachment('/var/www/html/portalweb/envio_demo/nomina/2014/DICIEMBRE/001-C-1715922959.pdf');
		// Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject=utf8_decode($subject);
		//$mail->Subject = 'SEÑOR(A) '.(utf8_decode($nombredestinatario));
		$mail->Body    = utf8_decode($mensaje);
		//$mail->AltBody = utf8_decode($mensaje);

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		/* else {
			echo 'Message has been sent';
		}*/


	}
	
	public function envio_normal($from,$fromname,$maildestinatario1,$nombredestinatario1,$subject,$mensaje){
		$mail = new PHPMailer;
		$mail->SMTPDebug  = 0;
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $this->_host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = false;                               // Enable SMTP authentication
		$mail->Username = $this->_user; // SMTP username
		//$mail->Password = $this->_pass;                         // SMTP password
		//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;                                    // TCP port to connect to
		
		$mail->From = $from;
		$mail->FromName = utf8_decode($fromname);
		//$mail->addAddress($maildestinatario, utf8_decode($nombredestinatario) );     // Add a recipient
		//$mail->addAddress('jonatan.diaz@administracionpublica.gob.ec', utf8_decode('Diego Díaz') );     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo($from, utf8_decode($fromname));
		
		$mail->addAddress($maildestinatario1,utf8_decode($nombredestinatario1));
		//$mail->addBCC($maildestinatario,utf8_decode("jonatan.diaz@administracionpublica.gob.ec"));
		
		//$mail->addAttachment('/var/www/html/portalweb/envio_demo/nomina/2014/DICIEMBRE/001-C-1715922959.pdf');
		// Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject=utf8_decode($subject);
		//$mail->Subject = 'SEÑOR(A) '.(utf8_decode($nombredestinatario));
		$mail->Body    = utf8_decode($mensaje);
		//$mail->AltBody = utf8_decode($mensaje);

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		/* else {
			echo 'Message has been sent';
		}*/


	}



	
}

/*$envio_mail=new envio_mail;
$envio_mail->envio("diazd@fiscalia.gob.ec","Diego Díaz",$rsql[$i][1],ucwords($rsql[$i][0]), $subject, $mensaje,$archivo,$nombrearchivo);*/

?>