<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
Create helper by mca, take from bpo helper
Create on friday 7 april 2017, 10.30
*/

if (!function_exists('send_email')) {
    function send_email($destination=null, $data = array(), $template = 'email/test', $subject = 'Default Subject')
    {
        $email = '';

        if ($destination != null || $destination != '') {
            $email = $destination;
        } else {
            if (ENVIRONMENT == 'development') {
                // $email = 'dev@indoproc.com';
                $email = 'caesar@indoproc.com';
            } elseif (ENVIRONMENT == 'production') {
                $email = 'dev@indoproc.com';
            } elseif (ENVIRONMENT == 'release') {
                $email = 'sourcinggroup@indoproc.com';
            }
        }

        $smtp_user = 'indoprocbpo@gmail.com';
        $config = array(
            'protocol'        => 'smtp',
            'smtp_host'    => 'ssl://smtp.googlemail.com',
            'smtp_port'    => 465,
            'smtp_user'    => $smtp_user, // change it to yours
            'smtp_pass'    => '123123qwerty', // change it to yours
            'mailtype'        => 'html',
            'smtp_timeout'    => '4',
            'charset'        => 'iso-8859-1',
            //'wordwrap' => TRUE
        );

        $CI =& get_instance();
        // print_r($template);die;
        $message = $CI->load->view($template, $data, true);

        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('indoprocbpo@gmail.com'); // change it to yours

        if (!is_array($email)) {
            $CI->email->to($smtp_user);// change it to yours
            $CI->email->bcc($email);// change it to yours
        } else {
            $CI->email->to($email);// change it to yours
        }

        $CI->email->subject($subject);
        $CI->email->message($message);
        if ($CI->email->send()) {
            //echo 'Email sent.';
            echo 'Email Sent';
        } else {
            show_error($CI->email->print_debugger());
        }
    }
}
