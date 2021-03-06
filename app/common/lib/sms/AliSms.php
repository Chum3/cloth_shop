<?php
/**
 * Created by Edmund.
 * Motto: 现在的努力是为了小时候吹过的牛逼！
 * Date: 2020/3/22
 * Time: 18:43
 */
declare(strict_types=1);
namespace app\common\lib\sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use think\facade\Env;
use think\facade\Log;

class AliSms implements SmsBase {
    //todo 可以放在middleware中
    /**
     * 阿里云发送短信验证码的场景
     * @param string $phone
     * @param int $code
     * @return bool
     * @throws ClientException
     */
    public static function sendCode(string $phone, int $code): bool {
        if(empty($phone) || empty($code)) {
            return false;
        }

        AlibabaCloud::accessKeyClient(Env::get('SMS.AliAccessKeyID'), Env::get('SMS.AliAccessKeySecret'))
            ->regionId(config("aliyun.region_id"))
            ->asDefaultClient();

        $templateParam = [
            'code' => $code,
        ];
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host(config("aliyun.host"))
                ->options([
                    'query' => [
                        'RegionId' => config("aliyun.region_id"),
                        'PhoneNumbers' => $phone,
                        'SignName' => config("aliyun.sign_name"),
                        'TemplateCode' =>  config("aliyun.template_code"),
                        'TemplateParam' => json_encode($templateParam),
                    ],
                ])
                ->request();
            Log::info("alisms-sendCode-{$phone}result".json_encode($result->toArray()));
            // print_r($result->toArray());
        } catch (ClientException $e) {
            Log::error("alisms-sendCode-{$phone}ClientException".$e->getErrorMessage());
            return false;
            // echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            Log::error("alisms-sendCode-{$phone}ServerException".$e->getErrorMessage());

            return false;
            // echo $e->getErrorMessage() . PHP_EOL;
        }

        if (isset($result['Code']) && $result['Code'] == "OK") {
            return true;
        }

        return false;
    }

}