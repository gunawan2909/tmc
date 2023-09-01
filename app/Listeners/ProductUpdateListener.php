<?php

namespace App\Listeners;

use App\Events\ProductUpdateEvent;
use App\Models\ProductQuery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductUpdateListener implements ShouldQueue
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
    public function handle(ProductUpdateEvent $event): void
    {
        $product = $event->getProduct();
        ProductQuery::where('id', $product->id)->get()[0]->update([
            'id' => $product->id,
            'name' => $product->name,
            'category_id' => $product->category_id,
            'stock' => $product->stock,
            'price' => $product->price,
            'sku' => $product->sku,
        ]);
    }
}
