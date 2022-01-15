<?php

namespace Database\Seeders;

use App\Models\Bicy;
use Illuminate\Database\Seeder;

class BicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bicy::truncate();

        $data = Bicy::create([
            'parkings_id' => '1',
            'code' => 'GT001',
            'serial' => 'SERIALXXGT001XX',
            'bikers_id' => '1',
            'brand' => 'GW',
            'color' => 'Negro',
            'tires' => 'Lisa',
            'description' => 'Bicicleta Rafael',
            'type_bicies_id' => '1',
            'active' => '1',
        ]);

        $data = Bicy::create([
            'parkings_id' => '1',
            'code' => 'GT002',
            'serial' => 'SERIALXXGT002XX',
            'bikers_id' => '1',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Rafael',
            'type_bicies_id' => '2',
            'active' => '1',
        ]);



        $data = Bicy::create([
            'parkings_id' => '2',
            'code' => 'HS001',
            'serial' => 'SERIALXXHS001XX',
            'bikers_id' => '4',
            'brand' => 'GW',
            'color' => 'Negro',
            'tires' => 'Lisa',
            'description' => 'Bicicleta Stiven',
            'type_bicies_id' => '1',
            'active' => '1',
        ]);

        $data = Bicy::create([
            'parkings_id' => '2',
            'code' => 'HS002',
            'serial' => 'SERIALXXHS002XX',
            'bikers_id' => '4',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Stiven',
            'type_bicies_id' => '2',
            'active' => '1',
        ]);



        $data = Bicy::create([
            'parkings_id' => '3',
            'code' => 'HR001',
            'serial' => 'SERIALXXHR001XX',
            'bikers_id' => '2',
            'brand' => 'GW',
            'color' => 'Negro',
            'tires' => 'Lisa',
            'description' => 'Bicicleta Hnery',
            'type_bicies_id' => '1',
            'active' => '1',
        ]);

        $data = Bicy::create([
            'parkings_id' => '3',
            'code' => 'HR002',
            'serial' => 'SERIALXXHR002XX',
            'bikers_id' => '2',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Hnery',
            'type_bicies_id' => '2',
            'active' => '1',
        ]);



        $data = Bicy::create([
            'parkings_id' => '1',
            'code' => 'CM001',
            'serial' => 'SERIALXXCM001XX',
            'bikers_id' => '3',
            'brand' => 'GW',
            'color' => 'Negro',
            'tires' => 'Lisa',
            'description' => 'Bicicleta Camilo',
            'type_bicies_id' => '1',
            'active' => '1',
        ]);

        $data = Bicy::create([
            'parkings_id' => '1',
            'code' => 'CM002',
            'serial' => 'SERIALXXCM002XX',
            'bikers_id' => '3',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Camilo',
            'type_bicies_id' => '2',
            'active' => '1',
        ]);



        $data = Bicy::create([
            'parkings_id' => '4',
            'code' => 'CS001',
            'serial' => 'SERIALXXCS001XX',
            'bikers_id' => '5',
            'brand' => 'GW',
            'color' => 'Negro',
            'tires' => 'Lisa',
            'description' => 'Bicicleta Carlos',
            'type_bicies_id' => '1',
            'active' => '1',
        ]);

        $data = Bicy::create([
            'parkings_id' => '4',
            'code' => 'CS002',
            'serial' => 'SERIALXXCS002XX',
            'bikers_id' => '5',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Carlos',
            'type_bicies_id' => '2',
            'active' => '1',
        ]);


        $data = Bicy::create([
            'parkings_id' => '4',
            'code' => 'JF001',
            'serial' => 'SERIALXXJF001XX',
            'bikers_id' => '6',
            'brand' => 'GW',
            'color' => 'Negro',
            'tires' => 'Lisa',
            'description' => 'Bicicleta Jose',
            'type_bicies_id' => '1',
            'active' => '1',
        ]);

        $data = Bicy::create([
            'parkings_id' => '4',
            'code' => 'JF002',
            'serial' => 'SERIALXXJF002XX',
            'bikers_id' => '6',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Jose',
            'type_bicies_id' => '2',
            'active' => '1',
        ]);

        $data = Bicy::create([
            'parkings_id' => '4',
            'code' => 'AC001',
            'serial' => 'SERIALXXAC001XX',
            'bikers_id' => '7',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Abandono',
            'type_bicies_id' => '2',
            'active' => '1',
            'updated_at'=>'2019-02-09 10:31:50'
        ]);

        $data = Bicy::create([
            'parkings_id' => '4',
            'code' => 'AC002',
            'serial' => 'SERIALXXAC002XX',
            'bikers_id' => '7',
            'brand' => 'Ryno',
            'color' => 'Azul',
            'tires' => 'Tache',
            'description' => 'Bicicleta Abandono 2',
            'type_bicies_id' => '2',
            'active' => '1',
            'updated_at'=>'2019-02-09 10:31:50'
        ]);




    }
}
