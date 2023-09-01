<?php

namespace App\Models;

use App\Models\CategoryCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCommand extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];
    protected $connection = 'mysql_command';
    public function category()
    {
        return $this->belongsTo(CategoryCommand::class, 'category_id', 'id');
    }
}
