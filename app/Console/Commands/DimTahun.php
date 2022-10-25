<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DimTahun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:dim_tahun';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ETL Dari dim_tahun';

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
            ->select(DB::raw('YEAR(rental_date) as tahun'))
            ->distinct()
            ->orderBy('tahun', 'asc')
            ->get();
        foreach ($extract as $value) {
            $array_tahun[] = $value->tahun;
        }

        $cek = DB::connection('clickhouse')
            ->table('db_dw.dim_tahun')
            ->select('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        foreach ($cek as $value) {
            $arr_ct[] = $value['tahun'];
        }

        // dd($cek);

        if ($cek == null) {
            $a = 1;
            foreach ($extract as $key => $value) {
                $arrData = array(
                    'id_tahun' => $a++,
                    'tahun'        => $array_tahun[$key],
                );
                DB::connection('clickhouse')->table('db_dw.dim_tahun')->insert($arrData);
            }
            echo 'Isi Tabel dim_tahun';
        } else if ($arr_ct == $array_tahun) {
            echo 'Data sudah ada';
        } else if ($arr_ct !== $array_tahun) {

            DB::connection('clickhouse')->table('db_dw.dim_tahun')->where('tahun', $arr_ct)->delete();

            $a = 1;
            foreach ($extract as $key => $value) {
                $arrData = array(
                    'id_tahun' => $a++,
                    'tahun'        => $array_tahun[$key],
                );
                DB::connection('clickhouse')->table('db_dw.dim_tahun')->insert($arrData);
            }
            echo 'Data Berubah';
        }
    }
}
