<?php

namespace App\Listeners;

use App\Events\CategoryUpdateEvent;
use App\Models\CategoryQuery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CategoryUpdateListener implements ShouldQueue
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
    public function handle(CategoryUpdateEvent $event): void
    {
        $category = $event->getCategory();
        CategoryQuery::where('id', $category->id)->get()[0]->update([
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }
}
