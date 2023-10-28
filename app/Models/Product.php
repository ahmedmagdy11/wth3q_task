<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'slug',
        'is_active',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getImageAttribute($value)
    {
        // if url return it
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        return asset('storage/' . $value);
    }

    public function getPriceAttribute($value)
    {
        $user = auth()->user();
        if (!$user) {
            return $value;
        }
        $discount_percentage = UserType::discount($user->type) / 100;
        return $value - ($value * $discount_percentage);
    }
}
