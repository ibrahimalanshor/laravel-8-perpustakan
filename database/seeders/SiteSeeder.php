<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\App\Models\Site::create([
    		'name' => 'Library',
    		'address' => 'Indonesia'
    	]);
    }
}
