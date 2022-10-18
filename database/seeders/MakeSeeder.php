<?php

namespace Database\Seeders;

use App\Domains\Car\Make;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MakeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Make)->delete();
        $makes = config('imports.makes');
        Make::insert($makes);
    }

}
