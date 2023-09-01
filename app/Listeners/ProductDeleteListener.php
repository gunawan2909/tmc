<?php

namespace App\Listeners;

use App\Events\ProductDeleteEvent;
use App\Models\ProductQuery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductDeleteListener implements ShouldQueue
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
    public function handle(ProductDeleteEvent $event): void
    {
        $product = $event->getProduct();
        ProductQuery::where('id', $product->id)->get()[0]->delete();
    }
}
