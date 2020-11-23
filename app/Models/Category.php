<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TypiCMS\NestableTrait; 
class Category extends Model
{   
    //for nested categories
    use NestableTrait;

    use HasFactory;
    //table
    protected $table = 'categories';
    //fillable parts
    protected $fillable = [
        'name', 'slug', 'description', 'parent_id', 'featured', 'menu', 'image'
    ];
    //casts
    protected $casts = [
        'parent_id' =>  'integer',
        'featured'  =>  'boolean',
        'menu'      =>  'boolean'
    ];
    //set name attribute
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] =Str::slug($value);
    }
    //for parent categories
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    //for children categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }
}
