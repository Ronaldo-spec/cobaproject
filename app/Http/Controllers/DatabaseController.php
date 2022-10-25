<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Program;

class DatabaseController extends Controller
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
        $pay = Payment::get()->all();
        $response = $this->client->request('GET', 'tables',[
            'query' => [
                'limit' => '100'
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true)['data'];
        return view('payment.index', compact('pay','data','pro'));
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
        $pay = Payment::get()->all();
        // $pay = Payment::getColumnListing('nama');
        // dd($pay);
        return view('payment.create', compact('data','pay'));
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
        return view('database.create', compact('data','pay','id'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        return redirect()->route('database.show',$data2)
            ->with('success', 'payment Berhasil Ditambahkan');
    }

    public function store(Request $request)
    {
        // $data = $request->nama;
        $data = $request->input('nama');
        $data1 = $request->input('tipe');
        // dd($data,$data1);
        // dd($data,);
        foreach ($data as $d) {
                Payment::firstOrCreate(['nama'=>$d,'tipeservice'=>$data1]);
            // Payment::firstOrCreate(['nama'=>$d]);
        }

        //jika data berhasil ditambahkan, akan kembali ke halaman utama 
        return redirect()->route('payment.index')
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
        return view('database.detail',compact('data'));
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
        return view('database.index', compact('nama','data','pay','coba','cobaja','pro'));
    }

    public function getProgram(Request $request){
        $heleh = Program::all();
        $heleh = Program::with('id_program','nama')-get();
        return response()->json($heleh);
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
        return redirect()->route('database.show',$pro1)
        ->with('success', 'Program Berhasil Dihapus');
    }
}
