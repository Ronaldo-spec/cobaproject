<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentDBController extends Controller
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
        return view('payment.index', compact('pay','data','pro'));
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
        // $pay = Payment::getColumnListing('nama');
        return view('layanan.create', compact('data','pay','id'));
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
        $data2 = $request->input('id');
        // dd($data,$data1);
        // dd($data,);
        foreach ($data as $d) {
                Payment::firstOrCreate(['nama'=>$d,'tipeservice'=>$data1,'layanan' => $data2]);
            // Payment::firstOrCreate(['nama'=>$d]);
        }

        //jika data berhasil ditambahkan, akan kembali ke halaman utama 
        return redirect()->route('program.show',$data2)
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
        return view('payment.detail',compact('data'));
        // return view('table.detail',compact('data1'));
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
        Payment::find($id)->delete();
        return redirect()->route('program.show',$id)
            ->with('success', 'Program Berhasil Dihapus');
    }
}
