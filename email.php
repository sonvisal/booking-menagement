<?php defined('BASEPATH') OR exit('No direct script access allowed.');

$config['protocol'] = 'smtp';
$config['useragent'] = 'phpmailer';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_user'] = 'vc2015_service@passerellesnumeriques.org';
$config['smtp_pass'] = 'vc-Service12';
$config['_smtp_auth'] = TRUE;
$config['smtp_port'] = '465';
$config['smtp_timeout'] = '20';
$config['smtp_crypto'] = 'ssl';                       // '' or 'tls' or 'ssl'
$config['charset'] = 'UTF-8';
$config['validate'] = true;
$config['mailtype'] = 'HTML';
$config['wordwrap'] = FALSE;
$config['wrapchars'] = 70;
$config['validate'] = FALSE;
$config['priority'] = 1;                                // 1, 2, 3, 4, 5
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";
$config['bcc_batch_mode'] = false;
$config['bcc_batch_size'] = 200;
