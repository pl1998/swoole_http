<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 11:35
 */


/**
 * 全局辅助函数 支持composer 自动加载
 */


use PHPMailer\PHPMailer\PHPMailer;


/**
 * 邮件发送
 * @param $content
 * @param $email_address
 * @throws \PHPMailer\PHPMailer\Exception
 */
function send_email($content,$email_address)
{

    $config = [
        'username' => 'pltruenine@163.com',
        'password' => 'qwertyasdf1',
        'host' => 'smtp.163.com',
        'smtp_secure' => 'ssl',
        'port' => 465,
        'setfrom' => 'pltruenine@163.com',
        'address' => $email_address,
    ];

    $mail = new PHPMailer();
    $mail->CharSet = "UTF-8";
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = $config['host'];
    $mail->SMTPAuth  =true;
    $mail->Username = $config['username'];
    $mail->Password = $config['password'];
    $mail->SMTPSecure  =$config['smtp_secure'];
    $mail->Port   = $config['port'];
    $mail->setFrom($config['setfrom'],'latent');
    $mail->addAddress($config['address'],'latent');
    $mail->addReplyTo($config['setfrom'], 'latent');
    $mail->isHTML(false);

    //设置邮件标题
    $mail->Subject = 'bi接口错误';
    $mail->Body =$content;
    $mail->AltBody =$content;

    $mail->send();
}

/**
 * 参数类型判断
 * @param array $array
 * @param $effect_array
 * @return bool
 */
function intended_effect(array $array, $effect_array)
{
    if ([] == array_diff($array, $effect_array)) {
        return true;
    } else {
        return false;
    }
}
