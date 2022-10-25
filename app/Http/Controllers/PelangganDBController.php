<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganDBController extends Controller
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
        $pro = Program::get()->all();
        $pel = Pelanggan::get()->all();
        return view('pelanggan.index', compact('pel','data','pro'));
        $response = $this->client->request('GET', 'tables',[
            'query' => [
                'limit' => '100'
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        return view('pelanggan.index', compact('pel','data','pro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = $this->client->request('GET', 'tables', [
            'query' => [
                'limit' => '10000'
                ]
            ]);
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        return view('pelanggan.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('nama');
        $data1 = $request->input('tipe');

        foreach ($data as $d) {
            Pelanggan::firstOrCreate(['nama'=>$d,'tipeservice'=>$data1]);
    }
    return redirect()->route('pelanggan.index')
        ->with('success', 'Pelanggan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->client->request('GET', 'tables/name/'.$id);
        $data = json_decode($response->getBody()->getContents(),true);
        return view('pelanggan.detail',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Pelanggan::find($id)->delete();
        return redirect()->route('pelanggan.index')
            ->with('success', 'Data Pelanggan Berhasil Dihapus');
    }
}
