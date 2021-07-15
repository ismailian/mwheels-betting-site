<?php

// namespaces //

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{

    // private protected mailer //
    private $mailer = null;

    // private function for loading smtp credentials //
    private static function load()
    {

        ## load new instance ##
        Mailer::$mailer = new PHPMailer();
        ## load new instance ##

        ## Server settings
        Mailer::$mailer->SMTPDebug  = SMTP::DEBUG_OFF;                        # Enable verbose debug output
        Mailer::$mailer->isSMTP();                                            # Send using SMTP
        Mailer::$mailer->Host       = 'smtp.gmail.com';                       # Set the SMTP server to send through
        Mailer::$mailer->SMTPAuth   = true;                                   # Enable SMTP authentication
        Mailer::$mailer->Username   = 'username';                             # SMTP username
        Mailer::$mailer->Password   = 'password';                             # SMTP password
        Mailer::$mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            # Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        Mailer::$mailer->Port       = 587;
        ## Server settings ##
    }

    // send an email //
    public static function send($from = "root@localhost", $to, $subject, $message)
    {

        ## load server settings ##
        Mailer::load();

        try {
            ## Recipient:
            Mailer::$mailer->setFrom($from, "MTL Wheels");
            Mailer::$mailer->addAddress($to);     // Add a recipient
            Mailer::$mailer->addReplyTo($from);

            // Content:
            Mailer::$mailer->isHTML(false);
            Mailer::$mailer->Subject = $subject;
            Mailer::$mailer->Body    = ($message);

            ## send
            if (!Mailer::$mailer->send()) {

                ## return ##
                return false;
                ## return ##

            }

            ## return ##
            return true;
            ## return ##

        } catch (Exception $e) {

            ## return error ##
            return Mailer::$mailer->ErrorInfo;
            ## return error ##

        }
    }
}
