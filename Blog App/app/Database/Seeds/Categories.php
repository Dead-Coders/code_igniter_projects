<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Categories as cat_model;

class Categories extends Seeder
{
    public function run()
    {
        $model = new cat_model;
        $faker = \Faker\Factory::create();
        $model->save([
            'name'=>'PHP',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'Javascript',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'Python',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'CodeIgniter',
            'description' => $faker->sentence,
        ]);
        $model->save([
            'name'=>'Laravel',
            'description' => $faker->sentence,
        ]);
    }
}
