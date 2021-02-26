<?php


namespace App\Service\YiLianYunService;


use App\Config\YlyConfig;
use App\Models\Application;
use App\Oauth\YlyOauthClient;

class ApplicationService
{
    protected $application;
    protected $clientId;
    protected $clientSecret;

    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->clientId = $application->getClientId();
        $this->clientSecret = $application->getClientSecret();
    }

    public function getConfig(): YlyConfig
    {
        return new YlyConfig($this->clientId, $this->clientSecret);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getToken()
    {
        $access_token = $this->application->getAccessToken();
        $config = $this->getConfig();
        if(empty($access_token)){
            $client = new YlyOauthClient($config);
            try {
                $token = $client->getToken();
                $access_token = $token->access_token;
                $this->application->setAccessToken($access_token);
            } catch (\Exception $e) {
                throw new \Exception('access_token获取失败:'. $e->getMessage());
            }
        }
        return $access_token;
    }

}