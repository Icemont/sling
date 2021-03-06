<?php

namespace App\Models;

use App\Contracts\HasOwner;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model implements HasOwner
{
    use HasFactory;

    protected $casts = [
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'attributes',
        'is_active',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope(auth()->id()));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public static function getPaginated(int $per_page = 25)
    {
        return self::orderByDesc('id')->paginate(config('app.per_page.payment_methods', $per_page));
    }

    public function getOwnerId(): ?int
    {
        return $this->user_id;
    }

    public function updatePaymentMethod(array $attributes)
    {
        return $this->update([
            'name' => $attributes['name'],
            'attributes' => isset($attributes['method_attributes']) ?
                array_combine($attributes['method_attributes']['keys'], $attributes['method_attributes']['values']) : [],
            'is_active' => $attributes['is_active'] ?? false,
        ]);
    }
}
