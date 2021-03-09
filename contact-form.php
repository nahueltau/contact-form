<?php
        /**
         * @version 1.0
         */

        require("class.phpmailer.php");
        require("class.smtp.php");
    //msg vars
    $msg="";
    $msgClass="";
    if(isset($_POST['submit'])){
        $name = htmlspecialchars($_POST["name"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $email = htmlspecialchars($_POST["email"]);
        $phone = htmlspecialchars($_POST["phone"]);
        $contact = htmlspecialchars($_POST["message"]);
        $body2= "<h2>Name:</h2>
        <p>".$name." ".$lastname."</p>
        <h2>Email:</h2>
        <p>".$email."</p>
        <h2>Teléfono:</h2>
        <p>".$phone."</p>
        <h2>Mensaje:</h2>
        <p>".$contact."</p>";
        $body= '<body style="margin: 0; padding: 0;font-family: sans-serif;">
        <table  border="0" cellpadding="0" cellspacing="0" width="100%">
           <tr>
               <td>
                   
                   <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
    
                       <tr bgcolor="#222222" style="color: #FFFFFF;">
                       
                      <td style="padding: 30px 0px 30px 00px;">
                       
                       <h2  align="center">Nuevo Mensaje</h2> 
                       
                      </td>
                       
                       </tr>
                       <tr>
                           <td style="padding: 50px 30px 80px 30px; color: #333333;">
                               <h3>Mensaje de '.$name.' '.$lastname.':</h3>
                               <p>'.$contact.'</p>
   
                           </td>
   
                       </tr>
                       <tr bgcolor="#555555" style="color: #FFFFFF;">
                           <td style="padding: 20px 30px 20px 30px;">
                               <h4>Información de Contacto</h4>
                               <p>Nombre: '.$name.'</p>
                               <p>Apellido: '.$lastname.'</p>
                               <p>Telefono: '.$phone.'</p>
                               <p>Email: '.$email.'</p>
                           </td>
   
                       </tr>
   
                      </table>
   
               </td>
           </tr>
   
        </table>
    </body>';
    if(!empty($name) && !empty($email) && !empty($contact) && !empty($lastname) && !empty($phone)){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)!==false){
            //PASSED


                                // Datos de la cuenta de correo utilizada para enviar vía SMTP
                    $smtpHost = "xxxxxxx.ferozo.com";  // Dominio alternativo brindado en el email de alta 
                    $smtpUsuario = "xxxxx@xxxxxx.com";  // Mi cuenta de correo
                    $smtpClave = "xxxxxxxxxxx";  // Mi contraseña

                    // Email donde se enviaran los datos cargados en el formulario de contacto
                    $emailDestino = "email@destino.com.ar";

                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Port = 465; 
                    $mail->SMTPSecure = 'ssl';
                    $mail->IsHTML(true); 
                    $mail->CharSet = "utf-8";


                    // VALORES A MODIFICAR //
                    $mail->Host = $smtpHost; 
                    $mail->Username = $smtpUsuario; 
                    $mail->Password = $smtpClave;

                    $mail->From = "email@from.ar"; // Email desde donde envío el correo.
                    $mail->FromName = $name." ". $lastname;
                    $mail->AddAddress($emailDestino); // Esta es la dirección a donde enviamos los datos del formulario

                    $mail->Subject = "Mensaje de contacto de " . $name; // Este es el titulo del email.
                    $mensajeHtml = nl2br($body);
                    $mail->Body = $mensajeHtml; // Texto del email en formato HTML
                    $mail->AltBody = $body; // Texto sin formato HTML
                    // FIN - VALORES A MODIFICAR //

                    $estadoEnvio = $mail->Send(); 
                    if($estadoEnvio){
                        $msg = "Gracias, pronto nos pondremos en contacto.";
                        $msgClass = "alert-success";
                    } else {
                        $msg = "Error: Intente nuevamente en unos instantes.";
                        $msgClass = "alert-danger";
                    }

        }else{
            $msg = "Por favor completar el E-mail.";
            $msgClass = "alert-danger";
        }
   
    }else{
        $msg = "Por favor completar todos los campos.";
        $msgClass = "alert-danger";
    }
 
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contactanos</title>
</head>
<body>
    <?php if($msg != ""):?>
            <div class="alert <?php echo $msgClass;?>"> <p><?php echo $msg;?></p></div>
        <?php endif;?>

    <div class="form-container">

        <div class="form-title">
          CONTACTANOS
        </div>
        <div class="form-subtitle">
          Contactanos y te respondemos a la brevedad...
        </div>
        <form action="contact.php" method="POST">
          <div class="form-row">
            <input type="text" id="name" name="name" placeholder="Nombre" value="<?php if(isset($_POST["name"])){echo $name;}?>">
            <input type="text" id="lastname" name="lastname" placeholder="Apellido" value="<?php if(isset($_POST["lastname"])){echo $lastname;}?>">
          </div>
          <div class="form-row">
            <input type="email" id="email" name="email" placeholder="E-Mail" value="<?php if(isset($_POST["email"])){echo $email;}?>">
            <input type="text" id="phone" name="phone" placeholder="Teléfono" value="<?php if(isset($_POST["phone"])){echo $phone;}?>">
          </div>
            <textarea id="message" name="message" cols="30" rows="10" placeholder="Mensaje"><?php if(isset($_POST["message"])){echo $contact;}?></textarea>
 
            <input type="submit" name="submit"  value="ENVIAR MENSAJE">

        </form>
      </div>
</body>
</html>