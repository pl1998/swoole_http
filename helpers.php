<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 11:35.
 */
use PHPMailer\PHPMailer\PHPMailer;

/**
 * 邮件发送
 *
 * @param $content
 * @param $email_address
 *
 * @throws \PHPMailer\PHPMailer\Exception
 */
if(!function_exists('send_email')){
    function send_email($content,$title,$email_address)
    {
        $config = require __DIR__.'/config/email.php';

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['port'];
        $mail->setFrom($config['setfrom'], 'latent');
        $mail->addAddress($email_address, 'latent');
        $mail->addReplyTo($config['setfrom'], 'latent');
        $mail->isHTML(true);

        //设置邮件标题
        $mail->Subject = $title;
        $mail->Body    = $content;
        $mail->AltBody = $content;

        $mail->send();
    }
}

/**
 * 参数类型判断.
 * @param array $array
 * @param $effect_array
 *
 * @return bool
 */
if(!function_exists('intended_effect')){
    function intended_effect(array $array, $effect_array)
    {
        if ([] == array_diff($array, $effect_array)) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * 获取配置
 * @param string $name
 * @return array
 */
if(!function_exists('config')){

    function config(string $name)
    {
        return  get_path('/config/',$name);
    }
}

/**
 * @param string $name
 * @return mixed
 */

if(!function_exists('view')){

    function view(string $name)
    {
        return  file_get_contents(get_path('/view/',$name,'html'));
    }
}

/**
 * @param string $name
 * @return string
 */

if(!function_exists('get')){
    function get_path($path,string $name,$fix='php')
    {
        if($fix == 'html'){
            return __DIR__.$path.$name.'.'.$fix;
        }
        $config_name = explode('.',$name);
        $data = [];
        foreach ($config_name as $key=> $value){
            if($key == 0){
               $data = require __DIR__.$path.$value.'.'.$fix;
            }else{
                if($key+1 == count($config_name)){
                    return $data[$value];
                }else{
                    $data=$data[$value];
                }
            }
        }
        return $data;
    }
}

if(!function_exists('success')){
    function success(array $data=[],string $message='success',int $code=200)
    {
        return json_encode([
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        ],JSON_UNESCAPED_UNICODE);
    }
}
