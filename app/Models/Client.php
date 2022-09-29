<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasOwner;
use App\Scopes\UserScope;
use App\Traits\HasAddress;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class Client extends Model implements HasOwner
{
    use HasFactory, HasAddress;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'company',
        'phone',
        'invoice_prefix',
        'invoice_index',
        'note',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope(auth()->id()));
    }

    public static function getPaginated(int $per_page = 25): LengthAwarePaginator
    {
        return self::orderByDesc('id')->paginate(config('app.per_page.clients', $per_page));
    }

    /**
     * @throws Throwable
     */
    public static function createClientWithAddress(array $attributes): Client
    {
        return DB::transaction(function () use ($attributes) {
            $client = Client::createClient($attributes);
            $client->upsertAddress($attributes);

            return $client;
        });
    }

    /**
     * @throws Throwable
     */
    public function updateClientWithAddress(Client $client, array $attributes): Client
    {
        return DB::transaction(function () use ($attributes, $client) {
            $client->updateClient($attributes);
            $client->upsertAddress($attributes);

            return $client;
        });
    }

    public function deleteWithAddress(): ?bool
    {
        $this->address()->delete();
        return $this->delete();
    }

    public static function createClient(array $attributes): self
    {
        return self::create([
            'user_id' => auth()->id(),
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'company' => $attributes['company'],
            'phone' => $attributes['phone'],
            'invoice_prefix' => $attributes['invoice_prefix'],
            'invoice_index' => $attributes['invoice_index'],
            'note' => $attributes['note'],
        ]);
    }

    public function updateClient(array $attributes): bool
    {
        return $this->update([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'company' => $attributes['company'],
            'phone' => $attributes['phone'],
            'invoice_prefix' => $attributes['invoice_prefix'],
            'invoice_index' => $attributes['invoice_index'],
            'note' => $attributes['note'],
        ]);
    }

    public function getOwnerId(): ?int
    {
        return $this->user_id;
    }
}
