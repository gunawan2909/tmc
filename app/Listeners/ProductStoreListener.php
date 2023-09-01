<?php

namespace App\Listeners;

use App\Events\ProductStoreEvent;
use App\Models\ProductQuery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductStoreListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductStoreEvent $event): void
    {
        $product = $event->getProduct();
        ProductQuery::create([
            'id' => $product->id,
            'name' => $product->name,
            'category_id' => $product->category_id,
            'stock' => $product->stock,
            'price' => $product->price,
            'sku' => $product->sku,
        ]);
    }
}
