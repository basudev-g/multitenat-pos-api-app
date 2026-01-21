<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::withoutGlobalScopes()->create([
            'tenant_id' => 1,
            'name'      => 'Rahim',
            'phone'     => '01700000000',
        ]);

        Customer::withoutGlobalScopes()->create([
            'tenant_id' => 1,
            'name'      => 'Karim',
            'phone'     => '01800000000',
        ]);
    }
}
