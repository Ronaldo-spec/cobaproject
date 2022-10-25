<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DimLokasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:dim_lokasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ETL Dari dim_lokasi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $tes = DB::connection('mysql')->select('select * from rental WHERE rental_id = 5');
        $extract = DB::connection('mysql')->select('SELECT a.country_id, a.country, b.city_id, b.city 
        FROM country a ,city b 
        WHERE b.country_id = a.country_id ORDER BY a.country_id, a.country, b.city_id, b.city ASC');

        foreach ($extract as $value) {
            $arr_id_neg[] = $value->country_id;
            $arr_neg[] = $value->country;
            $arr_id_co[] = $value->city_id;
            $arr_co[] = $value->city;
        }
        
        $cek = DB::connection('clickhouse')
        ->select("SELECT id_negara, negara, id_kota, kota
        from db_dw.dim_lokasi ORDER BY id_negara, negara, id_kota, kota ASC");
        foreach ($cek as $value) {
            $arr_ct[] = $value['id_kota'];
        }
        
        // dd($extract);
        if ($cek == null) {
            $a = 1;
            foreach ($extract as $key => $value) {
                $arrData = array(
                    'id_lokasi' => $a++,
                    'id_negara' => $arr_id_neg[$key],
                    'negara'        => $arr_neg[$key],
                    'id_kota' => $arr_id_co[$key],
                    'kota'        => $arr_co[$key],

                );
                DB::connection('clickhouse')->table('db_dw.dim_lokasi')->insert($arrData);
            }
            echo 'Isi Tabel Dim Lokasi';
        } else if ($arr_ct ==  $arr_id_co) {
            echo 'Data sudah ada';
        } else if ($arr_ct !== $arr_id_co) {

            DB::connection('clickhouse')->table('db_dw.dim_lokasi')->where('id_kota', $arr_ct)->delete();

            $a = 1;
            foreach ($extract as $key => $value) {
                $arrData = array(
                    'id_lokasi' => $a++,
                    'id_negara' => $arr_id_neg[$key],
                    'negara'        => $arr_neg[$key],
                    'id_kota' => $arr_id_co[$key],
                    'kota'        => $arr_co[$key],

                );
                DB::connection('clickhouse')->table('db_dw.dim_lokasi')->insert($arrData);
            }

            echo 'Data Berubah';
        }
    }
}
