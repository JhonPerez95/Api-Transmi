<?php

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visit::truncate();
        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '1',
            'bikers_id'  => '1',
            'bicies_id'  => '1',
            'duration'  => 60,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-20',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '2',
            'number'  => '1',
            'bikers_id'  => '1',
            'bicies_id'  => '2',
            'duration'  => 86400,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:02:00',
            //'new'  => 'Epa',
            'visit_statuses_id'  => '1',
        ]);


        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '1',
            'bikers_id'  => '2',
            'bicies_id'  => '3',
            'duration'  => 60,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-20',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '1',
            'bikers_id'  => '2',
            'bicies_id'  => '4',
            'duration'  => 86400,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:02:00',
            //'new'  => 'Epa',
            'visit_statuses_id'  => '1',
        ]);


        $data = Visit::create([
            'parkings_id'  => '2',
            'number'  => '2',
            'bikers_id'  => '3',
            'bicies_id'  => '5',
            'duration'  => 60,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-20',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '2',
            'number'  => '3',
            'bikers_id'  => '6',
            'bicies_id'  => '4',
            'duration'  => 86400,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:02:00',
            //'new'  => 'Epa',
            'visit_statuses_id'  => '1',
        ]);


        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '2',
            'bikers_id'  => '4',
            'bicies_id'  => '7',
            'duration'  => 60,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-20',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '3',
            'bikers_id'  => '4',
            'bicies_id'  => '8',
            'duration'  => 86400,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:02:00',
            //'new'  => 'Epa',
            'visit_statuses_id'  => '1',
        ]);


        $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '2',
            'bikers_id'  => '5',
            'bicies_id'  => '9',
            'duration'  => 60,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-20',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '3',
            'bikers_id'  => '5',
            'bicies_id'  => '10',
            'duration'  => 86400,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:02:00',
            //'new'  => 'Epa',
            'visit_statuses_id'  => '1',
        ]);

        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '2',
            'bikers_id'  => '6',
            'bicies_id'  => '11',
            'duration'  => 60,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-20',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '3',
            'bikers_id'  => '6',
            'bicies_id'  => '12',
            'duration'  => 86400,
            'date_input'  => '2020-12-20',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:02:00',
            //'new'  => 'Epa',
            'visit_statuses_id'  => '1',
        ]);



        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '1',
            'bikers_id'  => '1',
            'bicies_id'  => '1',
            'duration'  => 60,
            'date_input'  => '2020-12-21',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '1',
            'bikers_id'  => '2',
            'bicies_id'  => '3',
            'duration'  => 60,
            'date_input'  => '2020-12-21',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '2',
            'number'  => '1',
            'bikers_id'  => '3',
            'bicies_id'  => '5',
            'duration'  => 60,
            'date_input'  => '2020-12-21',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '2',
            'bikers_id'  => '4',
            'bicies_id'  => '7',
            'duration'  => 60,
            'date_input'  => '2020-12-21',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '1',
            'bikers_id'  => '5',
            'bicies_id'  => '9',
            'duration'  => 60,
            'date_input'  => '2020-12-21',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '2',
            'bikers_id'  => '6',
            'bicies_id'  => '11',
            'duration'  => 60,
            'date_input'  => '2020-12-21',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-21',
            'time_output'  => '02:03:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);



        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '1',
            'bikers_id'  => '1',
            'bicies_id'  => '1',
            'duration'  => 600,
            'date_input'  => '2020-12-22',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-22',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '1',
            'bikers_id'  => '2',
            'bicies_id'  => '3',
            'duration'  => 600,
            'date_input'  => '2020-12-22',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-22',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '2',
            'number'  => '1',
            'bikers_id'  => '3',
            'bicies_id'  => '5',
            'duration'  => 600,
            'date_input'  => '2020-12-22',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-22',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '2',
            'bikers_id'  => '4',
            'bicies_id'  => '7',
            'duration'  => 600,
            'date_input'  => '2020-12-22',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-22',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '1',
            'bikers_id'  => '5',
            'bicies_id'  => '9',
            'duration'  => 600,
            'date_input'  => '2020-12-22',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-22',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '2',
            'bikers_id'  => '6',
            'bicies_id'  => '11',
            'duration'  => 600,
            'date_input'  => '2020-12-22',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-22',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);







         $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '1',
            'bikers_id'  => '1',
            'bicies_id'  => '1',
            'duration'  => 600,
            'date_input'  => '2020-12-23',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-23',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '3',
            'number'  => '1',
            'bikers_id'  => '2',
            'bicies_id'  => '3',
            'duration'  => 600,
            'date_input'  => '2020-12-23',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-23',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '2',
            'number'  => '1',
            'bikers_id'  => '3',
            'bicies_id'  => '5',
            'duration'  => 600,
            'date_input'  => '2020-12-23',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-23',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);





        $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '1',
            'bikers_id'  => '5',
            'bicies_id'  => '9',
            'duration'  => 600,
            'date_input'  => '2020-12-24',
            'time_input'  => '01:02:00',
            'date_output'  => '2020-12-24',
            'time_output'  => '01:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '1',
            'bikers_id'  => '6',
            'bicies_id'  => '11',
            'duration'  => 600,
            'date_input'  => '2020-12-24',
            'time_input'  => '01:02:00',
            'date_output'  => '2020-12-24',
            'time_output'  => '01:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
         $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '2',
            'bikers_id'  => '5',
            'bicies_id'  => '9',
            'duration'  => 600,
            'date_input'  => '2020-12-24',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-24',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '2',
            'bikers_id'  => '6',
            'bicies_id'  => '11',
            'duration'  => 600,
            'date_input'  => '2020-12-24',
            'time_input'  => '02:02:00',
            'date_output'  => '2020-12-24',
            'time_output'  => '02:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
         $data = Visit::create([
            'parkings_id'  => '4',
            'number'  => '3',
            'bikers_id'  => '5',
            'bicies_id'  => '9',
            'duration'  => 600,
            'date_input'  => '2020-12-24',
            'time_input'  => '03:02:00',
            'date_output'  => '2020-12-24',
            'time_output'  => '03:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);
        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '3',
            'bikers_id'  => '6',
            'bicies_id'  => '11',
            'duration'  => 86400 + 600,
            'date_input'  => '2020-12-24',
            'time_input'  => '03:02:00',
            'date_output'  => '2020-12-25',
            'time_output'  => '03:12:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);


        $data = Visit::create([
            'parkings_id'  => '1',
            'number'  => '3',
            'bikers_id'  => '7',
            'bicies_id'  => '13',
            'duration'  => 0,
            'date_input'  => '2020-02-24',
            'time_input'  => '03:02:00',
            'date_output'  => '2020-02-24',
            'time_output'  => '03:02:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);

        $data = Visit::create([
            'parkings_id'  => '2',
            'number'  => '3',
            'bikers_id'  => '7',
            'bicies_id'  => '14',
            'duration'  => 0,
            'date_input'  => '2020-08-24',
            'time_input'  => '03:02:00',
            'date_output'  => '2020-02-24',
            'time_output'  => '03:02:00',
            //'new'  => 'Ninguna',
            'visit_statuses_id'  => '1',
        ]);

    }
}
