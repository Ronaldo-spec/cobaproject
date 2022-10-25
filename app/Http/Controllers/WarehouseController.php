<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Program;

class WarehouseController extends Controller
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
        $response = $this->client->request('GET', 'tables');
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        
        
        return view('warehouse.index', compact('data'));

    }

    public function create()
    {
        $response = $this->client->request('GET', 'tables', [
            'query' => [
                'limit' => '10000'
                ]
            ]);
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        return view('paymentdw.create', compact('data'));
    }
    
    public function addtable($id)
    {
        $response = $this->client->request('GET', 'tables', [
            'query' => [
                'limit' => '10000'
                ]
            ]);
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        $pay = Payment::get()->all();
        $id = $id;
        // dd($id);
        // $pay = Payment::getColumnListing('nama');
        return view('warehouse.create', compact('data','pay','id'));
    }
    
    public function storetable(Request $request)
    {
        // $data = $request->nama;
        $data = $request->input('nama');
        $data1 = $request->input('tipe');
        $data2 = $request->input('layanan');
        // dd($data,$data1);
        // dd($data2);
        foreach ($data as $d) {
                Payment::firstOrCreate(['nama'=>$d,'tipeservice'=>$data1,'layanan' => $data2]);
            // Payment::firstOrCreate(['nama'=>$d]);
        }
        
        //jika data berhasil ditambahkan, akan kembali ke halaman utama 
        return redirect()->route('warehouse.show',$data2)
            ->with('success', 'payment Berhasil Ditambahkan');
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
        // dd($data,$data1);
        // dd($data,);
        foreach ($data as $d) {
                Payment::firstOrCreate(['nama'=>$d,'tipeservice'=>$data1]);
            // Payment::firstOrCreate(['nama'=>$d]);
        }

        //jika data berhasil ditambahkan, akan kembali ke halaman utama 
        return redirect()->route('paymentdw.index')
            ->with('success', 'payment Berhasil Ditambahkan');
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
        // $data1 = json_decode($response->getBody()->getContents(),true['columns']);
        return view('warehouse.detail',compact('data'));
        // return view('table.detail',compact('data1'));
    }

    public function data($id)
    {
        $client = new Client();
        $response = $client->request('GET', 'http://10.12.10.113:8585/api/v1/tables', [
            'query' => [
                'limit' => '100'
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        $pay = Payment::get()->all();
        $pro = Program::select('nama')->where('nama', $id)->get();
        $coba = Program::select('id_program','nama')->get();
        $cobaja = Program::find(1);
        foreach ($pro as $p) {
            $nama = $p->nama;
        }
        return view('warehouse.index', compact('nama','data','pay','coba','cobaja','pro'));
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
        $pro = Payment::select('layanan')->where('id', $id)->get();
        Payment::find($id)->delete();
        foreach ($pro as $p) {
            $pro1= $p->layanan;
        }
        return redirect()->route('warehouse.show',$pro1)
        ->with('success', 'Program Berhasil Dihapus');
    }
}
