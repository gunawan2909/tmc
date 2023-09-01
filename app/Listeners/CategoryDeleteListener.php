<?php

namespace App\Listeners;

use App\Events\CategoryDeleteEvent;
use App\Models\CategoryQuery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CategoryDeleteListener implements ShouldQueue
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
    public function handle(CategoryDeleteEvent $event): void
    {
        $category = $event->getCategory();
        CategoryQuery::where('id', $category->id)->get()[0]->delete();
    }
}
