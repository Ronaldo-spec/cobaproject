<?php

namespace App\Console\Commands;

// use Tinderbox;
use Tinderbox\Clickhouse\Server;
use Tinderbox\Clickhouse\ServerProvider;
use Tinderbox\Clickhouse\Client;
use Tinderbox\ClickhouseBuilder\Query\Builder;
use Illuminate\Console\Command;
use Tinderbox\ClickhouseBuilder\Query\Limit;
use Illuminate\Support\Facades\DB;

class Users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:a';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List All';

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
        // $server = new Server('127.0.0.1', '8123', 'db_dw', 'default', '');
        // $serverProvider = (new ServerProvider())->addServer($server);

        // $client = new Client($serverProvider);
        // $builder = new Builder($client);

        // $builder->select(function ($column) {
        //     $column->as('alias') //or ->name('alias') in this case
        //     ->query()
        //     ->select('id_tahun')
        //     ->from('dim_tahun')
        //     ->get();
        // });
        // dd($builder);

        // $cli = DB::connection('clickhouse');
        // $tes = DB::connection('mysql')
        // ->select('SELECT DISTINCT YEAR(rental_date) From rental');
        //  dd($tes); 

        $extract = DB::connection('clickhouse')
            ->table('fakta_pelanggan')
            ->select('jml_pelanggan','dim_tahun.tahun')
            ->innerJoin('dim_tahun', 'all', ['id_tahun'])
            ->get();
        dd($extract);



        // $extract = DB::connection('mysql')
        //     ->table('rental')
        //     ->select(DB::raw('YEAR(rental_date) as tahun'))
        //     ->distinct()
        //     ->get();
        // foreach ($extract as $value){
        //     $array[] = $value->tahun;
        // }
        // dd($array);
        // $a=1;
        // foreach ($extract as $key => $value) {
        //     $arrData = array(
        //         'id_tahun' => $a++,
        //         'tahun'        => $array[$key],
        //     );
        //     DB::connection('clickhouse')->table('dim_tahun')->insert($arrData);
        // }

        // dd($tes2);
        // $tes = DB::connection('clickhouse')->table('dim_tahun')->limit(1)->get();
        // dd($tes);


        //insert 
        // $tes = DB::connection('clickhouse')->table('dim_tahun')->limit(1)->get();
        // $tes = DB::connection('mysql')->select('select * from rental WHERE rental_id = 5');
        // dd($tes);


        // $headers = ["ID","Name",'Surname',"Email"];
        //  $user = DB::select('select * from users WHERE id = :id',['id' => 2]);
        //  $user = DB::select('select * from users');
        //  dd($user);
        // $user = User::select('id','name','surname','email')->where('name',$this->argument('name'))->get();
        // $user = User::select('id','name','surname','email')->get();

        // $users = DB::table('users')->get();
        // $this->table($headers, $user);
    }
}
