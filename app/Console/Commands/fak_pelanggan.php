<?php

namespace App\Console\Commands;

use GMP;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Tinderbox\ClickhouseBuilder\Query\JoinClause;
use Tinderbox\ClickhouseBuilder\Query\BaseBuilder;

class fak_pelanggan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:fak_pelanggan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ETL Dari fakta_pelanggan';

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
        $ext_id = DB::connection('mysql')
            ->table('rental')
            ->select('country.country', 'city.city', 'country.country_id', 'city.city_id', DB::raw('YEAR(rental_date) as tahun'), DB::raw('count(customer_id) as jml_pelanggan'),)
            ->join('inventory', 'rental.inventory_id', '=', 'inventory.inventory_id')
            ->join('store', 'inventory.store_id', '=', 'store.store_id')
            ->join('address', 'store.address_id', '=', 'address.address_id')
            ->join('city', 'address.city_id', '=', 'city.city_id')
            ->join('country', 'city.country_id', '=', 'country.country_id')
            ->groupBy('tahun', 'country.country', 'city.city', 'country.country_id', 'city.city_id')
            ->get()
            ->toArray();

        // dd($ext_id);
        foreach ($ext_id as $value) {
            $arr_coi[] = $value->country_id;
            $arr_co[] = $value->country;
            $arr_cii[] = $value->city_id;
            $arr_ci[] = $value->city;
            $arr_t[] = $value->tahun;
            $arr_j[] = $value->jml_pelanggan;
        }
        // foreach ($ext_id as $key => $value) {
        //     $arrData = array(
        //         'tahun'     => $arr_t[$key],
        //         'negara'          => $arr_co[$key],
        //         'kota'          => $arr_ci[$key],
        //         'id_negara'         => $arr_coi[$key],
        //         'id_kota'     => $arr_cii[$key],
        //         'jml_pelanggan'     => $arr_j[$key],

        //     );
        //     DB::connection('clickhouse')->table('db2.rekap_pelanggan')->insert($arrData);
        // }


        $rekap = DB::connection('clickhouse')
            ->select("SELECT db_dw.dim_tahun.id_tahun as id_tahun, db_dw.dim_lokasi.id_lokasi as id_lokasi , 
        db2.rekap_pelanggan.jml_pelanggan as jml
        from db2.rekap_pelanggan
        join db_dw.dim_tahun  on db2.rekap_pelanggan.tahun = db_dw.dim_tahun.tahun
        join db_dw.dim_lokasi  on db2.rekap_pelanggan.id_kota = db_dw.dim_lokasi.id_kota 
            AND db2.rekap_pelanggan.id_negara = db_dw.dim_lokasi.id_negara 
            ORDER BY id_tahun, id_lokasi ASC ");

        // dd($rekap); 

        foreach ($rekap as $value) {
            $arr_tahun[] = $value['id_tahun'];
            $arr_lokasi[] = $value['id_lokasi'];
            $arr_jumlah[] = $value['jml'];
        }

        $cek = DB::connection('clickhouse')
            ->select("SELECT id_tahun, id_lokasi , 
        jml_pelanggan as jml
        from db_dw.fakta_pelanggan ORDER BY id_tahun, id_lokasi ASC");

        foreach ($cek as $value) {
            $arr_ct[] = $value['id_tahun'];
            $arr_cl[] = $value['id_lokasi'];
            $arr_j[] = $value['jml'];
        }

        // dd($cek);

        if ($cek == null) {
            foreach ($rekap as $key => $value) {
                $arrData = array(
                    'id_tahun'     => $arr_tahun[$key],
                    'id_lokasi'         => $arr_lokasi[$key],
                    'jml_pelanggan'     => $arr_jumlah[$key],
                );
                DB::connection('clickhouse')->table('db_dw.fakta_pelanggan')->insert($arrData);
            }
            echo 'Isi Tabel Fakta Pelanggan';

        } else if ($cek == $rekap) {
            echo 'Data sudah ada';

        } else if ($cek !== $rekap ){

            DB::connection('clickhouse')->table('db_dw.fakta_pelanggan')->where('id_lokasi', $arr_cl)->delete();

            foreach ($rekap as $key => $value) {
                $arrData = array(
                    'id_tahun'     => $arr_tahun[$key],
                    'id_lokasi'         => $arr_lokasi[$key],
                    'jml_pelanggan'     => $arr_jumlah[$key],
                );
                DB::connection('clickhouse')->table('db_dw.fakta_pelanggan')->insert($arrData);
            }
            echo 'Data Berubah';
        }

    }
}
