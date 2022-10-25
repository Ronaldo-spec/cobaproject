<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use Elastica\Client as ElasticaClient;

class ClientController extends Controller
{
    protected $elasticsearch;

    protected $elastica;

    public function  __construct(){

        $this->elasticsearch=ClientBuilder::create()->build();

        $elasticaConfig = [
            'host' => '10.12.10.113',
            'port' => 9200,
            'index' => 'pets'
        ];

        $this->elastica = new ElasticaClient($elasticaConfig);
    }

    public function elasticsearchTest(){
        dum($this->elasticsearch);

        echo "\n\Retrieve a document:\n";
        $params = [
            'index' => 'pets',
            'type' => 'dog',
            'id' => '1'
        ];
        $response = $this->elasticsearch->get($params);
        dum($response);
    }

    
}
