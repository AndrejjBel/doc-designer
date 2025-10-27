<?php

namespace App\Content;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSmtpNew
{
    public static function send($site_name, $subject, $body, $attach=false)
    {
        $result = [];
        $site_settings = json_decode(site_settings('site_settings'));
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Host = $site_settings->smtp_host;
        $mail->Port = $site_settings->smtp_port;
        $mail->Username = $site_settings->smtp_username;
        $mail->Password = $site_settings->smtp_password;
        $mail->setFrom($site_settings->smtp_username, $site_name);
        $mail->addAddress($site_settings->contact_email);
        $mail->Subject = $subject;
        $mail->msgHTML($body);
        // Приложение
        if ($attach) {
            $mail->addAttachment($attach); // __DIR__ . '/image.jpg'
        }
        if ($mail->send()) {
            $result['type'] = 'success';
            return $result;
        } else {
            $result['type'] = 'error';
            $result['info'] = $mail->ErrorInfo;
            return $result;
        }
    }
}
