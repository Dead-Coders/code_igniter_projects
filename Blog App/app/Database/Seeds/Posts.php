<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Posts as post_model;

class Posts extends Seeder
{
    public function run()
    {
        $model = new post_model;
        $faker = \Faker\Factory::create();
        for($i = 0; $i < 20; $i++){
            $model->save([
                'category_id'=>ceil(mt_rand(1,5)),
                'user_id'=>1,
                'title' => $faker->words(4, true),
                'short_description' => $faker->sentence,
                'content' => $faker->paragraphs(3, true),
                'tags' => implode(",", $faker->words(4, false)),
                'banner' => $faker->imageUrl(640, 480),
                'status' => 1,
            ]);
        }
    }
}
