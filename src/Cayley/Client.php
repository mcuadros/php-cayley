<?php

namespace Cayley;
use Cayley\Response;
use Cayley\Exception;
use GuzzleHttp\Client as HttpClient;
use Exception as BaseException;

class Client
{
    const BASE_URL_PATTERN = 'http://%s:%d/api/v1/';
    const URL_QUERY_GREMLIN = 'query/gremlin';
    const URL_SHAPE_GREMLIN = 'shape/gremlin';

    private $http;

    public function __construct($server = 'localhost', $port = 64210)
    {
        $this->buildHttpClient($server, $port);
    }

    private function buildHttpClient($server, $port)
    {
        $this->http = new HttpClient([
            'base_url' => $this->buildBaseURL($server, $port)
        ]);
    }

    private function buildBaseURL($server, $port)
    {
        return sprintf(self::BASE_URL_PATTERN, $server, $port);
    }

    public function queryWithGremlin($js)
    {
        $response = $this->doRequest(self::URL_QUERY_GREMLIN, $js);

        return new Response\QueryResult($response->json());
    }


    public function shapeWithGremlin()
    {
        $response = $this->doRequest(self::URL_SHAPE_GREMLIN, $js);
        var_dump($response->json());
    }

    private function doRequest($url, $body)
    {
        try {
            return $this->http->post($url, ['body' => $body]);
        } catch (BaseException $e) {
            throw $this->transformException($e);
        }
    }

    private function transformException($exception)
    {
        switch ($exception->getCode()) {
            case 400:
                return new Exception\BadRequest($exception);
                break;
            default:
                return new Exception\ClientException($exception);
                break;
        }
    }
}
