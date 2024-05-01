<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $brands = ['INTEL', 'AMD', 'MSI', 'ASUS', 'CORSAIR', 'GIGABYTE'];
        $count = 1;
        foreach($brands as $brand){
            $providerData = [
                'id' => $count,
                'provider_name' => $brand,
                'provider_email' => fake()->unique()->safeEmail(),
                'provider_location' => fake()->countryCode(),
            ];
            if(fake()->boolean()) $providerData['provider_phone'] = fake()->phoneNumber();
            $count++;
            Provider::create($providerData);
        }
    }
}
