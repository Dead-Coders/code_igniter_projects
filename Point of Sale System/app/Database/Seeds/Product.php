<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Product as Product_Model;
class Product extends Seeder
{
    public function run()
    {
        $model = new Product_Model;
        $model->save([
            'code'=>"1001",
            'name'=>'Product 101',
            'description'=>'Sample Product #101',
            'price'=>55.5
        ]);
        $model->save([
            'code'=>"1002",
            'name'=>'Product 102',
            'description'=>'Sample Product #102',
            'price'=>150
        ]);
        $model->save([
            'code'=>"1003",
            'name'=>'Product 103',
            'description'=>'Sample Product #103',
            'price'=>76.23
        ]);
        $model->save([
            'code'=>"1004",
            'name'=>'Product 104',
            'description'=>'Sample Product #104',
            'price'=>23.5
        ]);
        $model->save([
            'code'=>"1005",
            'name'=>'Product 105',
            'description'=>'Sample Product #105',
            'price'=>60.5
        ]);
        $model->save([
            'code'=>"1006",
            'name'=>'Product 106',
            'description'=>'Sample Product #106',
            'price'=>205.25
        ]);
        $model->save([
            'code'=>"1007",
            'name'=>'Product 107',
            'description'=>'Sample Product #107',
            'price'=>45
        ]);
        $model->save([
            'code'=>"1008",
            'name'=>'Product 108',
            'description'=>'Sample Product #108',
            'price'=>75.23
        ]);
        $model->save([
            'code'=>"1009",
            'name'=>'Product 109',
            'description'=>'Sample Product #109',
            'price'=>106.55
        ]);
        $model->save([
            'code'=>"1010",
            'name'=>'Product 110',
            'description'=>'Sample Product #110',
            'price'=>375.5
        ]);
        $model->save([
            'code'=>"1011",
            'name'=>'Product 111',
            'description'=>'Sample Product #111',
            'price'=>87.45
        ]);
        $model->save([
            'code'=>"1012",
            'name'=>'Product 112',
            'description'=>'Sample Product #112',
            'price'=>104.99
        ]);
        $model->save([
            'code'=>"1013",
            'name'=>'Product 113',
            'description'=>'Sample Product #113',
            'price'=>55.33
        ]);
        $model->save([
            'code'=>"1014",
            'name'=>'Product 114',
            'description'=>'Sample Product #114',
            'price'=>88.99
        ]);
        $model->save([
            'code'=>"1015",
            'name'=>'Product 115',
            'description'=>'Sample Product #115',
            'price'=>67.25
        ]);
        $model->save([
            'code'=>"1016",
            'name'=>'Product 116',
            'description'=>'Sample Product #116',
            'price'=>195.85
        ]);
        $model->save([
            'code'=>"1017",
            'name'=>'Product 117',
            'description'=>'Sample Product #117',
            'price'=>499.99
        ]);
    }
}
