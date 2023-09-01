<?php

namespace App\Listeners;

use App\Events\CategoryStoreEvent;
use App\Models\CategoryQuery;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CategoryStoreListener implements ShouldQueue
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
    public function handle(CategoryStoreEvent $event): void
    {
        $category = $event->getCategory();
        CategoryQuery::create([
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }
}
