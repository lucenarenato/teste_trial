<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable
 = [
        'product_id',
        'title',
        'type',
        'order',
        'parent_id',
    ];

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class, 'type_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(ProductType::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductType::class, 'parent_id');
    }
}
