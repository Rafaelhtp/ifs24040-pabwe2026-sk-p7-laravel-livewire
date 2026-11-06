<?php

namespace Database\Seeders;

use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        $member = User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member User',
                'username' => 'member',
                'password' => Hash::make('member'),
                'role' => 'member',
            ]
        );

        $items = [
            ['name' => 'Kertas A4 80gsm', 'sku' => 'ATK-001', 'description' => 'Kertas HVS ukuran A4.', 'quantity' => 120, 'unit' => 'rim', 'price' => 52000, 'min_stock' => 20],
            ['name' => 'Pulpen Hitam', 'sku' => 'ATK-002', 'description' => 'Pulpen tinta hitam 0.5mm.', 'quantity' => 4, 'unit' => 'pcs', 'price' => 3500, 'min_stock' => 10],
            ['name' => 'Spidol Whiteboard', 'sku' => 'ATK-003', 'description' => 'Spidol whiteboard warna biru.', 'quantity' => 0, 'unit' => 'pcs', 'price' => 9000, 'min_stock' => 5],
            ['name' => 'Beras Premium', 'sku' => 'BRG-001', 'description' => 'Beras premium kemasan 5kg.', 'quantity' => 60, 'unit' => 'kg', 'price' => 14500, 'min_stock' => 15],
        ];

        foreach ($items as $item) {
            Stock::firstOrCreate(
                ['user_id' => $member->id, 'sku' => $item['sku']],
                $item + ['status' => StockStatus::fromQuantity($item['quantity'], $item['min_stock'])->value]
            );
        }
    }
}
