<?php

namespace Database\Seeders;

use App\Models\Biker;
use Illuminate\Database\Seeder;

class BikerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Biker::truncate();

        $rafael = Biker::create([
            'name' => 'Rafael',
            'last_name' => 'Velez',
            'type_documents_id' => '1',
            'document' => '1234567',
            'birth' => '1998-02-15',
            'genders_id' => '1',
            'phone' => '1234567',
            'email' => 'email@email.com',
            'jobs_id' => '2',
            'neighborhoods_id' => 'El Portal',
            'levels_id' => 'Estrato 1',
            'register' => '2020-12-20',
            'parkings_id' => '1',
            'active' => '1',
            'code' => 'CP00001',
            'auth' => '2',
            'url_img' => 'https://res.cloudinary.com/jhontt95/image/upload/c_fit,h_150,w_150/igkywvrdzo93sxp3vkq8.png',
            'id_img' => 'igkywvrdzo93sxp3vkq8'
        ]);
        $henry = Biker::create([
            'name' => 'Henry',
            'last_name' => 'Reyes',
            'type_documents_id' => '1',
            'document' => '123456',
            'birth' => '1998-02-15',
            'genders_id' => '1',
            'phone' => '12345678',
            'email' => 'henry@email.com',
            'jobs_id' => '2',
            'neighborhoods_id' => 'La Victoria',
            'levels_id' => 'Estrato 1',
            'register' => '2020-12-20',
            'parkings_id' => '1',
            'active' => '1',
            'code' => 'CP00002',
            'auth' => '1',
            'url_img' => 'https://res.cloudinary.com/jhontt95/image/upload/c_fit,h_150,w_150/igkywvrdzo93sxp3vkq8.png',
            'id_img' => 'igkywvrdzo93sxp3vkq8'
        ]);
        $camilo = Biker::create([
            'name' => 'Camilo',
            'last_name' => 'Mejia',
            'type_documents_id' => '1',
            'document' => '12345678',
            'birth' => '1998-02-15',
            'genders_id' => '1',
            'phone' => '123456789',
            'email' => 'camilo@email.com',
            'jobs_id' => '2',
            'neighborhoods_id' => 'San José',
            'levels_id' => 'Estrato 1',
            'register' => '2020-12-20',
            'parkings_id' => '1',
            'code' => 'CP00003',
            'active' => '1',
            'auth' => '1',
            'url_img' => 'https://res.cloudinary.com/jhontt95/image/upload/c_fit,h_150,w_150/igkywvrdzo93sxp3vkq8.png',
            'id_img' => 'igkywvrdzo93sxp3vkq8'
        ]);





        $stiven = Biker::create([
            'name' => 'Stiven',
            'last_name' => 'Bermeo',
            'type_documents_id' => '1',
            'document' => '1024600458',
            'birth' => '1998-02-15',
            'genders_id' => '1',
            'phone' => '3219192092',
            'email' => 'stiven@email.com',
            'jobs_id' => '2',
            'neighborhoods_id' => 'Meissen',
            'levels_id' => 'Estrato 1',
            'register' => '2020-12-20',
            'parkings_id' => '1',
            'code' => 'CP00004',
            'active' => '1',
            'auth' => '1',
            'url_img' => 'https://res.cloudinary.com/jhontt95/image/upload/c_fit,h_150,w_150/igkywvrdzo93sxp3vkq8.png',
            'id_img' => 'igkywvrdzo93sxp3vkq8'
        ]);

        $carlos = Biker::create([
            'name' => 'Carlos',
            'last_name' => 'Santana',
            'type_documents_id' => '1',
            'document' => '9876543',
            'birth' => '1998-02-15',
            'genders_id' => '1',
            'phone' => '987654321',
            'email' => 'carlos@email.com',
            'jobs_id' => '2',
            'neighborhoods_id' => 'San Agustín',
            'levels_id' => 'Estrato 1',
            'register' => '2020-12-20',
            'parkings_id' => '1',
            'code' => 'CP00005',
            'active' => '1',
            'auth' => '1',
            'url_img' => 'https://res.cloudinary.com/jhontt95/image/upload/c_fit,h_150,w_150/igkywvrdzo93sxp3vkq8.png',
            'id_img' => 'igkywvrdzo93sxp3vkq8'
        ]);

        $jose = Biker::create([
            'name' => 'Jose',
            'last_name' => 'Fino',
            'type_documents_id' => '1',
            'document' => '98765432',
            'birth' => '1998-02-15',
            'genders_id' => '1',
            'phone' => '98765432',
            'email' => 'jose@email.com',
            'jobs_id' => '2',
            'neighborhoods_id' => 'La Pola',
            'levels_id' => 'Estrato 1',
            'register' => '2020-12-20',
            'parkings_id' => '1',
            'code' => 'CP00006',
            'active' => '1',
            'auth' => '1',
            'url_img' => 'https://res.cloudinary.com/jhontt95/image/upload/c_fit,h_150,w_150/igkywvrdzo93sxp3vkq8.png',
            'id_img' => 'igkywvrdzo93sxp3vkq8'
        ]);



        $abandono = Biker::create([
            'name' => 'Abandono',
            'last_name' => 'Cicla',
            'type_documents_id' => '1',
            'document' => '987654333',
            'birth' => '1998-02-15',
            'genders_id' => '1',
            'phone' => '987654333',
            'email' => 'abandono@email.com',
            'jobs_id' => '2',
            'neighborhoods_id' => 'Barrio Prueba',
            'levels_id' => 'Estrato 1',
            'register' => '2020-12-20',
            'code' => 'CP00007',
            'parkings_id' => '1',
            'active' => '1',
            'auth' => '1',
            'url_img' => 'https://res.cloudinary.com/jhontt95/image/upload/c_fit,h_150,w_150/igkywvrdzo93sxp3vkq8.png',
            'id_img' => 'igkywvrdzo93sxp3vkq8'
        ]);
    }
}
