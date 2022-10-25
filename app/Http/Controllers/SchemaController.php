<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SchemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $client; 

    public function __construct() {
        $this->client = new Client([
            'base_uri' => 'http://10.12.10.113:8585/api/v1/'
        ]);
    }
    public function index()
    {
        $response = $this->client->request('GET', 'databaseSchemas');
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        return view('schema.index', compact('data'));
    }

    // public function index()
    // {
    //     $response = $this->client->request('GET', 'tables/4fa9a52c-71dc-46f0-a7b9-a65668b9a1d0');
    //     $data = json_decode($response->getBody()->getContents(), true);
    //     $response2 = $this->client->request('GET', 'tables/d4befe96-4220-4720-9c3a-488578f63b8c');
    //     $data2 = json_decode($response2->getBody()->getContents(), true);

    //     $data3 = $data2+$data;
    //     dd($data3);
    //     // return view('schema.index', compact('data'));
    // }

    // public function index()
    // {
    //     $response = $this->client->request('GET', 'search/query', [
    //         'query' => [
    //             'q' => 'tags:db.pembayaran'
    //         ]
    //     ]);
    //     $data = json_decode($response->getBody()->getContents(), true);
    //     dd($data);
    //     // return view('schema.index', compact('data'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $users = user::find($id); 
        // return view('profil.detail', compact('users'));
        $response = $this->client->request('GET', 'schema/name/'.$id);
        $data = json_decode($response->getBody()->getContents(),true);
        // $data1 = json_decode($response->getBody()->getContents(),true)['column'];
        // return view('schema.detail',compact(data1));
        return view('schema.detail',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
