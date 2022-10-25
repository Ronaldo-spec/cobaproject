<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        // $pro = DB::select('select * from program');
        $pro = Program::get()->all();
        // $pro = DB::connection('mysql3')->select('select * from program');

        $search = $request->search;
        if ($request->has('search')) {
            $pro = Program::where('nama', 'like', '%' . $search . '%')->orWhere('deskripsi', 'like', '%' . $search . '%')->get();
        } else if ($request->has('search')) {
            // $pro;
            // echo "Pencarian tidak tersedia"; 
        }
        return view('program.index', compact('pro'));
    }


    public function create()
    {
        return view('program.create');
    }


    public function store(Request $request)
    {
        // melakukan validasi data 
        $validate = $request->validate([
            // 'id_program' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'image' => 'image|file|max:2048'
        ]);

        if ($request->file('image')) {
            $validate['image'] = $request->file('image')->store('ERD');
        }

        //fungsi eloquent untuk menambah data 
        Program::create($validate);

        //jika data berhasil ditambahkan, akan kembali ke halaman utama 
        return redirect()->route('program.index')
            ->with('success', 'Program Berhasil Ditambahkan');
    }

    public function show($id)
    {
        $client = new Client();
        $response = $client->request('GET', 'http://10.12.10.113:8585/api/v1/tables', [
            'query' => [
                'limit' => '100'
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true)['data'];

        // DB::table('payment')->insert($data);

        // if ($id == 'paymentdw') {
        //     $pro = Program::get()->all();
        //     $pay = Payment::get()->all();
        //     return view('paymentdw.index', compact('pay','data','pro'));
        // } else if ($id == 'payment') {
        //     $pro = Program::get()->all();
        //     $pay = Payment::get()->all();
        //     $coba = Program::select('id_program','nama')->get();
        //     $cobaja = Program::find(1);
        //     // $sampleType = Payment::get()->all($id);
        //     // $pay = DB::connection('mysql3')->select('select * from payment');
        //     return view('payment.index', compact('pay','data','pro','coba','cobaja'));
        // } else if ($id == 'paymentairflow'){
        //     $client = new Client();
        //     $response = $client->request('GET', 'http://10.12.10.113:8585/api/v1/lineage/table/name/Clikhouse.default.db_dw.fakta_pelanggan');
        //     $data = json_decode($response->getBody()->getContents(), true);
        //     return view('paymentAirflow.index', compact('data'));
        // }
        // $pay = Payment::get()->all();
        // $pro = Program::select('nama')->where('nama', $id)->get();
        // $coba = Program::select('id_program','nama')->get();
        // $cobaja = Program::find(1);
        // foreach ($pro as $p) {
        //     $nama = $p->nama;
        // }
        // return view('database.index', compact('nama','data','pay','coba','cobaja','pro'));
        $pro = Program::find($id);
        return view('program.detail', compact('pro'));

    }


    public function edit($id)
    {
        //menampilkan detail data dengan menemukan berdasarkan  id untuk diedit 
        $pro = Program::find($id);
        return view('program.edit', compact('pro'));
    }


    public function update(Request $request, $id)
    {
        $program = Program::find($id);
        //melakukan validasi data 
        $validate = $request->validate([
            // 'id_program' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'image' => 'image|file|max:2048',
        ]);
        // Storage::delete($program->image);
        // return dd($program->image);
        //menghapus foto lama
        // if ($program->image && file_exists(storage_path('app/public/' . $program->image))) {
        //     Storage::delete('public/' . $program->image);
        // }
        //menyimpan foto baru
        if ($request->file('image')) {
            Storage::delete($program->image);
            $validate['image'] = $request->file('image')->store('ERD');
        }

        //fungsi eloquent untuk mengupdate data inputan kita 
        // Program::find($id)->update($request->all());

        $program->update($validate);
        //jika data berhasil diupdate, akan kembali ke halaman utama 
        return redirect()->route('program.index')
            ->with('success', 'program Berhasil Diupdate');
    }

    public function destroy($id)
    {
        //fungsi eloquent untuk menghapus data 
        Program::find($id)->delete();
        return redirect()->route('program.index')
            ->with('success', 'Program Berhasil Dihapus');
    }
}
