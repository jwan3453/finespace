<?php


namespace App\Tool;
use Config;

class SendTemplateSMS
{

    //主帐号,对应开官网发者主账号下的 ACCOUNT SID



    function sendTemplateSMS($to, $content,$type)
    {
        $apiKey = Config::get('sms.apikey');
        $uri = Config::get('sms.url');

        if($type == 1)
        {
            $content = config::get('sms.registerContent').$content;
        }
        else if($type ==2 )
        {
            $content = config::get('sms.resetPasswordContent').$content;
        }

        // 参数数组

        $data = array(
            'apikey' => $apiKey,
            'mobile' =>$to,
            'content' => $content
        );

        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $uri);
        //设置头文件的信息作为数据流输出
        // curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //跳过ssl检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //执行命令
        $data = curl_exec($curl);


        //关闭URL请求
        curl_close($curl);

        return json_decode($data);

    }
}
?>



