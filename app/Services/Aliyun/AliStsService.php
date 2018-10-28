<?php
/**
 * Created by PhpStorm.
 * User: longyuan
 * Date: 2018/10/27
 * Time: 5:48 PM
 */

namespace App\Services\Aliyun;


use App\Services\Api\CLogger;
use Sts\Request\V20150401\AssumeRoleRequest;

class AliStsService
{
    public static function getStsToken()
    {
        $iClientProfile =  \DefaultProfile::getProfile(env('STS_REGIN_ID', 'cn-hangzhou'), env('STS_ACCESS_ID', ''), env('STS_ACCESS_SECRET', ''));
        $client = new \DefaultAcsClient($iClientProfile);
        $request = new AssumeRoleRequest();
        $request->setRoleSessionName("client_name");
        $request->setRoleArn(env('STS_ROLE_ARN', ''));
        $request->setDurationSeconds(env('STS_TOKEN_EXPITE', 900));
        try{
            $response = $client->doAction($request);
            $rows = array();
            $body = $response->getBody();
            $content = json_decode($body);
            $rows['status'] = $response->getStatus();
            if ($response->getStatus() == 200)
            {
                $rows['AccessKeyId'] = $content->Credentials->AccessKeyId;
                $rows['AccessKeySecret'] = $content->Credentials->AccessKeySecret;
                $rows['Expiration'] = $content->Credentials->Expiration;
                $rows['SecurityToken'] = $content->Credentials->SecurityToken;
                return $rows;
            } else {
                return false;
            }
        }catch (\ServerException $exception){
            CLogger::getLogger('sts')->info($exception->getMessage());
            return false;
        }
    }
}