<?php

namespace App\Features\Ai\DTO;

class GeneratedStockItem
{
    public function __construct(
        public string $name,
        public ?string $sku = null,
        public ?string $description = null,
        public int $quantity = 0,
        public string $unit = 'pcs',
        public ?float $price = null,
        public int $minStock = 5,
        public string $status = 'available',
    ) {}

    /**
     * Convert the DTO to an associative array for persistence.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price,
            'min_stock' => $this->minStock,
            'status' => $this->status,
        ];
    }

    /**
     * Build the DTO from an associative array (snake_case keys, as produced by toArray()).
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) $data['name'],
            sku: $data['sku'] ?? null,
            description: $data['description'] ?? null,
            quantity: (int) ($data['quantity'] ?? 0),
            unit: (string) ($data['unit'] ?? 'pcs'),
            price: isset($data['price']) ? (float) $data['price'] : null,
            minStock: (int) ($data['min_stock'] ?? 5),
            status: (string) ($data['status'] ?? 'available'),
        );
    }
}
