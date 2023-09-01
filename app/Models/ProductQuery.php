<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductQuery extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'category_id',
        'stock',
        'price',
        'sku',
    ];
    public function category()
    {
        return $this->belongsTo(CategoryQuery::class, 'category_id', 'id');
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['sku'] ?? false, function ($query, $sku) {
            if (is_array($sku)) {
                foreach ($sku as $item) {
                    $query->orwhere('sku',  $item);
                }
            } else {
                $query->where('sku',  $sku);
            }
        })
            ->when($filters['name'] ?? false, function ($query, $name) {
                if (is_array($name)) {
                    foreach ($name as $item) {
                        $query->where('name', 'LIKE', '%' .  $item . '%');
                    }
                } else {
                    $query->where('name', 'LIKE', '%' . $name . '%');
                }
            })->when(
                $filters['price_start'] ?? false,
                function ($query, $price_start) {
                    $query->where('price',  '>=',  $price_start);
                }
            )->when(
                $filters['price_end'] ?? false,
                function ($query, $price_end) {

                    $query->where('price',  '<=',  $price_end);
                }
            )->when(
                $filters['stock_start'] ?? false,
                function ($query, $stock_start) {
                    $query->where('stock',  '>=',  $stock_start);
                }
            )->when(
                $filters['stock_end'] ?? false,
                function ($query, $stock_end) {
                    $query->where('stock',  '<=',  $stock_end);
                }
            )->when(
                $filters['category_id'] ?? false,
                function ($query, $category_id) {
                    $query->where('category_id',  $category_id);
                }
            )->when(
                $filters['category_name'] ?? false,
                function ($query, $category_name) {
                    $query->whereHas('category', function ($query) use ($category_name) {
                        $query->where('name',  $category_name);
                    });
                }
            );
    }
}
