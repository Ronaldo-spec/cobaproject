<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    // function index(){
    //     $response = Http::get('http://10.12.10.113:8585/api/v1/databases');
    //     $data = $response->json()['data'];
    //     return view('database',compact('data'));
    //     // dd($data);
    // }
    // function index(){
    //     $client = new Client();
    //     $res = $client->request('GET', 'http://10.12.10.113:8585/api/v1/databases', [
    //         // 'auth' => ['user', 'pass']
    //         'query' => [
    //             'user', 'pass'
    //         ]
    //     ]);
    //     echo $res->getStatusCode();
    //     // "200"
    //     echo $res->getHeader('content-type')[0];
    //     // 'application/json; charset=utf8'
    //     echo $res->getBody();
    // }
    // function db1(){
    //     $response = Http::get('http://10.12.10.113:8585/api/v1/databases/{id}');
    //     $data = $response->json()['data'];
    //     return view('/database/db1',compact('data'));
    //     // dd($data);
    // }


    function store(Request $request){

    }
}
