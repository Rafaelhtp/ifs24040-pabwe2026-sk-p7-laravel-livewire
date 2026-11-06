<?php

namespace App\Features\Stock\Enums;

enum StockStatus: string
{
    case Available = 'available';
    case LowStock = 'low_stock';
    case OutOfStock = 'out_of_stock';

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Tersedia',
            self::LowStock => 'Stok Menipis',
            self::OutOfStock => 'Stok Habis',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Available => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            self::LowStock => 'bg-amber-100 text-amber-800 border-amber-300',
            self::OutOfStock => 'bg-red-100 text-red-800 border-red-300',
        };
    }

    /**
     * Determine the status based on quantity and minimum stock.
     */
    public static function fromQuantity(int $quantity, int $minStock): self
    {
        if ($quantity <= 0) {
            return self::OutOfStock;
        }

        if ($quantity <= $minStock) {
            return self::LowStock;
        }

        return self::Available;
    }
}
