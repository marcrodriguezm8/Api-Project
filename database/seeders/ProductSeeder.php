<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $products = [
            'Tarjeta gráfica' => ['RTX 3070', 'RTX 3080', 'RTX 3090', 'RTX 4060 Ti', 'RTX 3060', 'RTX 4070', 'RTX 4060'],
            'Procesador' => ['Core i5-12400F', 'Core i7-14700KF', 'Core i9-10900X', 'Ryzen 7 7800X3D', 'Ryzen 5 5500', 'Ryzen 5 7600X', 'Ryzen 9 7900X3D'],
            'Placa base' => ['PRO Z790-A MAX WIFI', 'B760 GAMING PLUS WIFI', 'TUF GAMING B650-PLUS', 'B760M DS3H DDR4'],
            'Memoria RAM' => ['Vengeance LPX DDR4 8GB', 'Vengeance RGB DDR5 16GB'],
        ];
        $code = 1;




        foreach($products as $key => $value){
            foreach($value as $element){

                $date = new \DateTime();
                $date = $date->format('YdmHis');

                $productCode = $date.$code;

                $code++;

                $productData = [
                    'product_name' => $element,
                    'product_code' => $productCode,
                    'product_category' => $key,

                ];
                Product::create($productData);
            }
        }
    }
}
