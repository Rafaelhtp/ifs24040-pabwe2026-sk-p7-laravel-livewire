<?php

namespace Tests\Unit\DTO;

use App\Features\Ai\DTO\GeneratedStockItem;
use PHPUnit\Framework\TestCase;

class GeneratedStockItemTest extends TestCase
{
    public function test_dto_properties_to_array_and_from_array(): void
    {
        $dto = new GeneratedStockItem(
            name: 'Kertas A4',
            sku: 'ATK-001',
            description: 'Kertas HVS 80gsm',
            quantity: 50,
            unit: 'rim',
            price: 52000.0,
            minStock: 10,
            status: 'available'
        );

        $this->assertEquals('Kertas A4', $dto->name);
        $this->assertEquals('ATK-001', $dto->sku);
        $this->assertEquals('Kertas HVS 80gsm', $dto->description);
        $this->assertEquals(50, $dto->quantity);
        $this->assertEquals('rim', $dto->unit);
        $this->assertEquals(52000.0, $dto->price);
        $this->assertEquals(10, $dto->minStock);
        $this->assertEquals('available', $dto->status);

        $array = $dto->toArray();
        $this->assertEquals([
            'name' => 'Kertas A4',
            'sku' => 'ATK-001',
            'description' => 'Kertas HVS 80gsm',
            'quantity' => 50,
            'unit' => 'rim',
            'price' => 52000.0,
            'min_stock' => 10,
            'status' => 'available',
        ], $array);

        $reconstructed = GeneratedStockItem::fromArray($array);
        $this->assertEquals($dto->toArray(), $reconstructed->toArray());

        $minimal = GeneratedStockItem::fromArray(['name' => 'Pulpen']);
        $this->assertEquals('Pulpen', $minimal->name);
        $this->assertNull($minimal->sku);
        $this->assertNull($minimal->price);
        $this->assertEquals(0, $minimal->quantity);
        $this->assertEquals('pcs', $minimal->unit);
        $this->assertEquals(5, $minimal->minStock);
        $this->assertEquals('available', $minimal->status);
    }
}
