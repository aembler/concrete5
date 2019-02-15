<?php
namespace Concrete\Core\Api\Client;

use Concrete\Core\Logging\Channels;
use Concrete\Core\Logging\LoggerAwareInterface;
use Concrete\Core\Logging\LoggerAwareTrait;
use Frankkessler\Guzzle\Oauth2\GrantType\ClientCredentials;
use Frankkessler\Guzzle\Oauth2\GrantType\RefreshToken;
use Frankkessler\Guzzle\Oauth2\Oauth2Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

class Client implements LoggerAwareInterface
{

    use LoggerAwareTrait;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ClientFactory
     */
    protected $factory;

    public function getLoggerChannel()
    {
        return Channels::CHANNEL_API;
    }

    public function __construct(ClientFactory $factory, $baseUrl, $config)
    {
        $this->factory = $factory;
        $this->baseUrl = $baseUrl;
        $this->config = $config;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    private function createLoggingMiddleware(string $messageFormat)
    {
        return Middleware::log($this->logger, new MessageFormatter($messageFormat));
    }

    private function appendLoggingHandler(HandlerStack $stack, array $messageFormats)
    {
        collect($messageFormats)->each(function ($messageFormat) use ($stack) {
            $stack->push(
                $this->createLoggingMiddleware($messageFormat)
            );
        });

        return $stack;
    }

    protected function getServiceClient($name)
    {
        return new ServiceClient(
            $this->getHTTPClient(),
            $this->getDescription($name)
        );
    }

    protected function getDescription($name)
    {
        $config = $this->factory->getDescriptionConfig($name);
        $config['baseUrl'] = $this->getBaseUrl() . $config['baseUrl'];
        return new Description($config);
    }

    public function setHttpPClient($client)
    {
        $this->client = $client;
    }

    public function getHttpClient()
    {
        if (!isset($this->client)) {
            $this->client = new Oauth2Client([
                'base_uri' => $this->baseUrl,
                'auth' => 'oauth2',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ]);

            $config = [
                'client_id' => $this->config['credentials']['client_id'],
                'client_secret' => $this->config['credentials']['client_secret'],
                'token_url' => $this->baseUrl . '/oauth/2.0/token',
                'scope' => $this->config['scope'],
            ];

            $token = new ClientCredentials($config);
            $this->client->setGrantType($token);

            $refreshToken = new RefreshToken($config);
            $this->client->setRefreshTokenGrantType($refreshToken);

            $this->appendLoggingHandler($this->client->getConfig('handler'), [
                '{method} {uri} HTTP/{version} {req_body}',
                'RESPONSE: {code} - {res_body}',
            ]);

        }

        return $this->client;
    }

    public function system()
    {
        return $this->getServiceClient('system');
    }

    public function site()
    {
        return $this->getServiceClient('site');
    }

    public function __call($name, $arguments)
    {
        // Handles dynamic parsing of the service client, allowing packages
        // to add to this via config.
        return $this->getServiceClient($name);
    }


}