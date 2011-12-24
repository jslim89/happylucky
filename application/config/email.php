<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The mail sending protocol.
 *
 * Options:
 * - mail
 * - sendmail
 * - smtp
 */
$config['protocol'] = 'smtp';

/**
 * SMTP server address. 
 */
$config['smtp_host'] = 'mx.000webhost.com';

/**
 * SMTP username. 
 */
$config['smtp_user'] = 'happylucky@jslim.co.cc';

/**
 * SMTP password. 
 */
$config['smtp_pass'] = 'jslim89'

/**
 * SMTP port 
 */
$config['smtp_port'] = 25;

/**
 * SMTP timeout (in second) 
 */
$config['smtp_timeout'] = 30;

/**
 * Enable word-wrap 
 *
 * Options (boolean):
 * - TRUE
 * - FALSE
 */
$config['wordwrap'] = TRUE;

/**
 * Character count to wrap at. 
 */
$config['wrapchars'] = 76;

/**
 * Type of mail. If you send HTML email you must send it as a complete web 
 * page. Make sure you don't have any relative links or relative image paths 
 * otherwise they will not work.
 *
 * Options:
 * - text
 * - html
 */
$config['mailtype'] = 'html';

/**
 * Character set (utf-8, iso-8859-1, etc.).
 */
$config['charset'] = 'utf-8';

/**
 * Whether to validate the email address.
 *
 * Options (boolean):
 * - TRUE
 * - FALSE
 */
$config['validate'] = FALSE;

/**
 * Email Priority. 1 = highest. 5 = lowest. 3 = normal. 
 *
 * Options:
 * 1 - highest
 * 2 - high
 * 3 - normal
 * 4 - low
 * 5 - lowest
 */
$config['priority'] = 3;

/**
 * Newline character. (Use "\r\n" to comply with RFC 822).
 *
 * Options:
 * - "\r\n"
 * - "\n"
 * - "\r"
 */
$config['crif'] = '\n';

/**
 * Newline character. (Use "\r\n" to comply with RFC 822).
 *
 * Options:
 * - "\r\n"
 * - "\n"
 * - "\r"
 */
$config['newline'] = '\n';

/**
 * Enable BCC Batch Mode. 
 *
 * Options (boolean):
 * - TRUE
 * - FALSE
 */
$config['bcc_batch_mode'] = FALSE;

/**
 * Number of emails in each BCC batch. 
 */
$config['bcc_batch_size'] = 200;
