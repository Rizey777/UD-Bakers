<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topping;

class ToppingSeeder extends Seeder
{
    public function run()
    {
        Topping::insert([
     ['name' => 'Mesis', 'price' => 2000, 'category' => 'kue kering'],
    ['name' => 'Keju',      'price' => 3000, 'category' => 'kue kering'],
    ['name' => 'Goriorio',  'price' => 2000, 'category' => 'kue kering'],
    ['name' => 'Matcha',    'price' => 2000, 'category' => 'kue basah'],
     ['name' => 'Strawbery',    'price' => 2000, 'category' => 'kue kering'],
       ['name' => 'Coklat',    'price' => 2000, 'category' => 'kue kering'],
        ['name' => 'Strawbery',    'price' => 2000, 'category' => 'kue kering'],
          ['name' => 'Matcha',    'price' => 2000, 'category' => 'kue kering'],
            ['name' => 'Coklat',    'price' => 2000, 'category' => 'kue kering'],
        ]);
    }
}
