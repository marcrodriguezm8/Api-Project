<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            'INTEL' => ['Core i5-12400F' => 'Procesador', 'Core i7-14700KF' => 'Procesador', 'Core i9-10900X' => 'Procesador'],
            'AMD' => ['Ryzen 7 7800X3D' => 'Procesador', 'Ryzen 5 5500' => 'Procesador', 'Ryzen 5 7600X' => 'Procesador'],
            'MSI' => ['PRO Z790-A MAX WIFI' => 'Placa base', 'B760 GAMING PLUS WIFI' => 'Placa base', 'RTX 3060' => 'Tarjeta gráfica', 'RTX 3070' => 'Tarjeta gráfica', 'RTX 4060 Ti' => 'Tarjeta gráfica', 'RTX 3080' => 'Tarjeta gráfica'],
            'ASUS' => ['RTX 4070' => 'Tarjeta gráfica', 'TUF GAMING B650-PLUS' => 'Placa base', 'RTX 3070' => 'Tarjeta gráfica', 'RTX 3090' => 'Tarjeta gráfica', 'RTX 4060' => 'Tarjeta gráfica'],
            'CORSAIR' => ['Vengeance LPX DDR4 8GB' => 'Memoria RAM', 'Vengeance RGB DDR5 16GB' => 'Memoria RAM'],
            'GIGABYTE' => ['B760M DS3H DDR4' => 'Placa base', 'RTX 4060' => 'Tarjeta gráfica', 'RTX 3080' => 'Tarjeta gráfica']
        ];
        $providers = ['INTEL', 'AMD', 'MSI', 'ASUS', 'CORSAIR', 'GIGABYTE'];

        foreach($data as $key => $value){
            foreach($value as $element => $type){

                $product = Product::where('product_name', $element)->first();
                $provider = Provider::where('provider_name', $key)->first();

                $price = fake()->randomFloat(2, 200, 1000);
                $stock = fake()->numberBetween(1, 1000);

                $product->providers()->attach($provider->id, ['product_price' => $price, 'product_stock' => $stock]);
            }



        }
    }
}
