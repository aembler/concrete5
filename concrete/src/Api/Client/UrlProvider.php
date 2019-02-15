<?php
namespace Concrete\Core\Api\Client;

class UrlProvider implements ProviderInterface
{

    protected $url;
    protected $config;

    public function __construct($url, $config = [])
    {
        $this->url = $url;
        $this->config = $config;
    }

    public function getBaseUrl()
    {
        return $this->url;
    }

    public function getConfig()
    {
        return $this->config;
    }

}