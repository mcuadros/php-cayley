<?php

namespace Cayley;

use Cayley\Response;
use Cayley\Exception;
use Cayley\Gremlin;
use GuzzleHttp\Client as HttpClient;
use Exception as BaseException;

class Client
{
    const BASE_URL_PATTERN = 'http://%s:%d/api/v1/';
    const URL_QUERY_GREMLIN = 'query/gremlin';
    const URL_SHAPE_GREMLIN = 'shape/gremlin';
    const URL_WRITE = 'write';
    const URL_DELETE = 'delete';

    private $http;

    public function __construct($server = 'localhost', $port = 64210)
    {
        $this->buildHttpClient($server, $port);
    }

    private function buildHttpClient($server, $port)
    {
        $this->http = new HttpClient([
            'base_uri' => $this->buildBaseURL($server, $port)
        ]);
    }

    private function buildBaseURL($server, $port)
    {
        return sprintf(self::BASE_URL_PATTERN, $server, $port);
    }

    public function graph()
    {
        return new Gremlin\Graph();
    }

    public function query(Gremlin\Statement $statement)
    {
        return $this->queryWithGremlin((string) $statement);
    }

    public function queryWithGremlin($js)
    {
        $response = $this->doRequest(self::URL_QUERY_GREMLIN, $js);

        return new Response\QueryResult(json_decode($response->getBody(), true));
    }

    public function write($subject, $predicate, $object, $label = null)
    {
        $data = [
            'subject' => $subject,
            'predicate' => $predicate,
            'object' => $object
        ];

        if ($label) {
            $data['label'] = $label;
        }

        return $this->writeMultiple([$data]);
    }

    public function writeMultiple(Array $quads)
    {
        $response = $this->doRequest(self::URL_WRITE, json_encode($quads));
        $result = json_decode($response->getBody(), true);

        list($count) = sscanf($result['result'], 'Successfully wrote %d triples.');

        return $count;
    }

    public function delete($subject, $predicate, $object, $label = null)
    {
        $data = [
            'subject' => $subject,
            'predicate' => $predicate,
            'object' => $object
        ];

        if ($label) {
            $data['label'] = $label;
        }

        return $this->deleteMultiple([$data]);
    }

    public function deleteMultiple(Array $quads)
    {
        $response = $this->doRequest(self::URL_DELETE, json_encode($quads));
        $result = json_decode($response->getBody(), true);

        list($count) = sscanf($result['result'], 'Successfully deleted %d triples.');

        return $count;
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
