<?php

namespace Pixelvide\UrlShortener;

use Aws\Credentials\CredentialProvider;
use Aws\Signature\SignatureV4;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Pixelvide\UrlShortener\Abstracts\ShortUrl;
use Psr\Http\Message\RequestInterface;

class AwsShortUrl extends ShortUrl
{
    /**
     * @var mixed
     */
    protected $awsEndPoint;

    /**
     * AwsShortUrl constructor.
     *
     * @param  string  $url
     * @param  int  $maxHashLength
     * @param  null  $awsEndPoint
     */
    public function __construct(string $url, int $maxHashLength = 10, $awsEndPoint = null)
    {
        parent::__construct($url, $maxHashLength);
        $this->awsEndPoint = env('SHORTENER_API_URL', $awsEndPoint);
    }

    /**
     * @return string
     * @throws GuzzleException
     * @throws \Exception
     */
    function shorten(): string
    {
        $signedRequest = $this->getSignedRequest();
        $client        = new Client([
            'verify' => env('APP_ENV', 'local') !== 'testing'
        ]);
        $response      = $client->send($signedRequest);
        $contents      = json_decode(trim($response->getBody()
            ->getContents()));
        if ($response->getStatusCode() == 422 && $contents->message == 'URL link already exists') {
            return $this->shorten();
        }
        if (isset($contents->error)) {
            throw new \Exception($contents->message);
        }
        return $contents->shortUrl;
    }

    /**
     * @return array
     */
    private function payload(): array
    {
        return [
            'id'  => $this->hash(),
            'url' => $this->url,
        ];
    }

    /**
     * @return RequestInterface
     */
    private function getSignedRequest(): RequestInterface
    {
        $credentials = CredentialProvider::defaultProvider();
        $credentials = $credentials()->wait();
        $request     = new Request('POST', $this->awsEndPoint, [], json_encode($this->payload()));
        $s4          = new SignatureV4("execute-api", env('AWS_REGION', 'us-east-1'));
        return $s4->signRequest($request, $credentials);
    }
}