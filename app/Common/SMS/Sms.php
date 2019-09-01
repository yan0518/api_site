<?php
namespace App\Common\SMS;

use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use App\Exceptions\DoctorAppException;

class Sms{

    protected $config;

    protected $easySms;

    function __construct(){
        $this->config = [
            'timeout' => 5.0,
            'default' => [
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
                'gateways' => [
                    'aliyun',
                ],
            ],
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => config('aliyun.sms_access_key_id'),
                    'access_key_secret' => config('aliyun.sms_access_key_secret'),
                    'sign_name' => config('aliyun.sms_signname'),
                ]
            ],
        ];
        $this->easySms = new EasySms($this->config);
    }

    public function sendVerifyCode( $cell, $code)
    {
        try{
            $rst = $this->easySms->send($cell,[
                'content'  => $code,
                'template' => config('aliyun.sms_template_verifycode'),
                'data' => [
                    'code' => $code
                ],
            ]);
            if($rst['aliyun']['status'] == 'success'){
                return true;
            }
        }
        catch(NoGatewayAvailableException $e){
            throw new DoctorAppException(-2100004);
        }
        throw new DoctorAppException(-2100004); 
    }
}