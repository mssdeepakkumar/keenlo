<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-email.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO email PHP class.
*/
    
    if (!class_exists('DOPBSPNotifications')){
        class DOPBSPNotifications{
            /*
             * Private variables.
             */
            private $php_mailer;
                    
            /*
             * Constructor.
             */
            function DOPBSPNotifications(){
                /*
                 * Initialize PHPMailer class.
                 */
                $this->php_mailer = new PHPMailer();
            }
            
            /*
             * Send simple email.
             * 
             * @param email_to (string): receiver email
             * @param email_from (string): sender email
             * @param email_reply (string): sender reply email
             * @param email_name (string): sender name
             * @param subject (string): email subject
             * @param message (string): email message
             */
            function send($email_to,
                          $email_from,
                          $email_reply,
                          $email_name,
                          $subject,
                          $message){
                $email_reply == '' ? $email_from:$email_reply;
                $email_name == '' ? $email_reply:$email_name;
                
                $this->php_mailer->CharSet = 'UTF-8';
                $this->php_mailer->isMail();
                $this->php_mailer->addAddress($email_to);
                $this->php_mailer->From = $email_from;
                $this->php_mailer->FromName = $email_name;
                $this->php_mailer->addReplyTo($email_reply);
                $this->php_mailer->isHTML(true);

                $this->php_mailer->Subject = $subject;
                $this->php_mailer->Body = $message;

                if (!$this->php_mailer->send()){
                    // echo 'Message could not be sent.';
                    // echo 'Mailer Error: ' . $this->php_mailer->ErrorInfo;
                    // echo $this->php_mailer->ErrorInfo;
                }
                else{
                    // echo 'Message has been sent.';
                }
            }
            
            /*
             * Send SMTP email.
             * 
             * @param email_to (string): receiver email
             * @param email_from (string): sender email
             * @param email_reply (string): sender reply email
             * @param email_name (string): sender name
             * @param subject (string): email subject
             * @param message (string): email message
             * @param host_name (string): SMTP host name
             * @param host_port (string): SMTP host port
             * @param ssl (string): SMTP use secure authentication
             * @param user (string): SMTP user authentication
             * @param password (string): SMTP password authentication
             */
            function sendSMTP($email_to,
                              $email_from,
                              $email_reply,
                              $email_name,
                              $subject,
                              $message,
                              $host_name,
                              $host_port,
                              $ssl,
                              $user,
                              $password){
                $email_reply == '' ? $email_from:$email_reply;
                $email_name == '' ? $email_reply:$email_name;
                
                $this->php_mailer->CharSet = 'UTF-8';
                $this->php_mailer->isSMTP();
                $this->php_mailer->Host = $host_name;
                $this->php_mailer->Port = $host_port;
                $this->php_mailer->SMTPAuth = true;
                $this->php_mailer->SMTPSecure = $ssl == 'true' ? ($host_port == '587' ? 'tls':'ssl'):'';
                $this->php_mailer->Username = $user;
                $this->php_mailer->Password = $password;
                
                $this->php_mailer->addAddress($email_to);
                $this->php_mailer->From = $email_from;
                $this->php_mailer->FromName = $email_name;
                $this->php_mailer->addReplyTo($email_reply);
                $this->php_mailer->isHTML(true);

                $this->php_mailer->Subject = $subject;
                $this->php_mailer->Body = $message;

                if (!$this->php_mailer->send()){
                    // echo 'Message could not be sent.';
                    // echo 'Mailer Error: ' . $this->php_mailer->ErrorInfo;
                    // echo $this->php_mailer->ErrorInfo;
                    
                    $this->send($email_to,
                                $email_from,
                                $email_reply,
                                $email_name,
                                $subject,
                                $message);
                }
                else{
                    // echo 'Message has been sent.';
                }
            }
        }
    }