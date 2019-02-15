<?php
namespace Concrete\Core\Api\Client;

use Concrete\Core\Application\Application;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Api\Client\ProviderInterface;

final class ClientFactory
{

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Application
     */
    protected $app;

    protected $additionalMethodGroups = [];

    public function __construct(Application $app, Repository $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    public function registerMethodGroup($group, $pkgHandle)
    {
        $this->additionalMethodGroups[$group] = $pkgHandle;
    }

    public function create(ProviderInterface $provider, $config = [])
    {
        $uri = trim($provider->getBaseUrl(), '/') . '/index.php';
        $config = array_merge($config, $provider->getConfig());
        $api = $this->app->make(Client::class, ['baseUrl' => $uri, 'config' => $config]);
        return $api;
    }

    public function getDescriptionConfig($name)
    {
        if (array_key_exists($name, $this->additionalMethodGroups)) {
            $key = sprintf('%s::%s/%s', $this->additionalMethodGroups[$name], 'api', $name);
        } else {
            $key = sprintf('api::%s', $name);
        }
        $description = $this->config->get($key);
        $baseUrl = $this->config->get('app.api.base_url') . '/' . $name . '/';
        $description['baseUrl'] = $baseUrl;
        return $description;
    }





}