<?php

namespace Tests\Unit\Enums;

use App\Features\Stock\Enums\StockStatus;
use PHPUnit\Framework\TestCase;

class StockStatusTest extends TestCase
{
    public function test_stock_status_labels(): void
    {
        $this->assertEquals('Tersedia', StockStatus::Available->label());
        $this->assertEquals('Stok Menipis', StockStatus::LowStock->label());
        $this->assertEquals('Stok Habis', StockStatus::OutOfStock->label());
    }

    public function test_stock_status_badge_classes(): void
    {
        $this->assertStringContainsString('emerald', StockStatus::Available->badgeClass());
        $this->assertStringContainsString('amber', StockStatus::LowStock->badgeClass());
        $this->assertStringContainsString('red', StockStatus::OutOfStock->badgeClass());
    }

    public function test_from_quantity(): void
    {
        $this->assertSame(StockStatus::OutOfStock, StockStatus::fromQuantity(0, 5));
        $this->assertSame(StockStatus::OutOfStock, StockStatus::fromQuantity(-2, 5));
        $this->assertSame(StockStatus::LowStock, StockStatus::fromQuantity(1, 5));
        $this->assertSame(StockStatus::LowStock, StockStatus::fromQuantity(5, 5));
        $this->assertSame(StockStatus::Available, StockStatus::fromQuantity(6, 5));
        $this->assertSame(StockStatus::Available, StockStatus::fromQuantity(100, 5));
    }
}
