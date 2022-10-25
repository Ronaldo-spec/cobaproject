<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Rekap_pelanggan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:rekap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $extract = DB::connection('mysql')
            ->table('rental')
            ->select('country.country', 'city.city', 'country.country_id', 'city.city_id', DB::raw('YEAR(rental_date) as tahun'), DB::raw('count(customer_id) as jml_pelanggan'),)
            ->join('inventory', 'rental.inventory_id', '=', 'inventory.inventory_id')
            ->join('store', 'inventory.store_id', '=', 'store.store_id')
            ->join('address', 'store.address_id', '=', 'address.address_id')
            ->join('city', 'address.city_id', '=', 'city.city_id')
            ->join('country', 'city.country_id', '=', 'country.country_id')
            ->groupBy('tahun', 'country.country', 'city.city', 'country.country_id', 'city.city_id')
            // ->orderBy('id_c', 'asc')
            ->get()
            ->toArray();

        // dd($ext_id);
        foreach ($extract as $value) {
            $arr_coi[] = $value->country_id;
            $arr_co[] = $value->country;
            $arr_cii[] = $value->city_id;
            $arr_ci[] = $value->city;
            $arr_t[] = $value->tahun;
            $arr_j[] = $value->jml_pelanggan;
        }

        $cek = DB::connection('clickhouse')
            ->select("SELECT id_kota
        from db_dw.dim_lokasi ORDER BY id_kota ASC");
        foreach ($cek as $value) {
            $arr_ct[] = $value['id_kota'];
        }


        DB::connection('clickhouse')->table('db2.rekap_pelanggan')->where('id_kota', $arr_ct)->delete();

        foreach ($extract as $key => $value) {
            $arrData = array(
                'tahun'     => $arr_t[$key],
                'negara'          => $arr_co[$key],
                'kota'          => $arr_ci[$key],
                'id_negara'         => $arr_coi[$key],
                'id_kota'     => $arr_cii[$key],
                'jml_pelanggan'     => $arr_j[$key],

            );
            DB::connection('clickhouse')->table('db2.rekap_pelanggan')->insert($arrData);
        }
    }
}
