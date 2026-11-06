<?php

namespace Tests\Unit\Models;

use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StockModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $stock->user);
        $this->assertEquals($user->id, $stock->user->id);
    }

    public function test_stock_casts(): void
    {
        $stock = Stock::factory()->create([
            'quantity' => '15',
            'min_stock' => '5',
            'price' => 25000.5,
            'status' => 'available',
        ]);

        $this->assertIsInt($stock->quantity);
        $this->assertIsInt($stock->min_stock);
        $this->assertEquals('25000.50', $stock->price);
        $this->assertInstanceOf(StockStatus::class, $stock->status);
        $this->assertSame(StockStatus::Available, $stock->status);
    }

    public function test_stock_factory_states(): void
    {
        $available = Stock::factory()->available()->create();
        $this->assertSame(StockStatus::Available, $available->status);

        $lowStock = Stock::factory()->lowStock()->create();
        $this->assertSame(StockStatus::LowStock, $lowStock->status);

        $outOfStock = Stock::factory()->outOfStock()->create();
        $this->assertSame(StockStatus::OutOfStock, $outOfStock->status);
    }

    public function test_cover_image_url_returns_correct_url_or_null(): void
    {
        $stockWithoutCover = Stock::factory()->create(['cover_image_path' => null]);
        $this->assertNull($stockWithoutCover->coverImageUrl());

        Storage::fake('public');
        Storage::disk('public')->put('stock-covers/sample.png', 'content');

        $stockWithCover = Stock::factory()->create(['cover_image_path' => 'stock-covers/sample.png']);
        $this->assertNotNull($stockWithCover->coverImageUrl());
        $this->assertStringContainsString('stock-covers/sample.png', $stockWithCover->coverImageUrl());
    }
}
