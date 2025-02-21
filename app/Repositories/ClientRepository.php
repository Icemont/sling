<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\AddressDTO;
use App\DTO\ClientDTO;
use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClientRepository
{
    public function getPaginated(?int $perPage = null): LengthAwarePaginator
    {
        return Client::orderByDesc('id')
            ->paginate($perPage ?? config('app.per_page.clients'));
    }

    public function getAllForSelector(): Collection
    {
        return Client::all(['id', 'name']);
    }

    public function create(ClientDTO $data): Client
    {
        return Auth::user()->clients()->create([
            'name' => $data->name,
            'email' => $data->email,
            'company' => $data->company,
            'invoice_prefix' => $data->invoice_prefix,
            'invoice_index' => $data->invoice_index,
            'phone' => $data->phone,
            'note' => $data->note,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function createWithAddress(ClientDTO $data): Client
    {
        return DB::transaction(function () use ($data) {
            $client = $this->create($data);
            $this->upsertAddress($client, $data->address);

            return $client;
        });
    }

    public function update(Client $client, ClientDTO $data): bool
    {
        return $client->update([
            'name' => $data->name,
            'email' => $data->email,
            'company' => $data->company,
            'invoice_prefix' => $data->invoice_prefix,
            'invoice_index' => $data->invoice_index,
            'phone' => $data->phone,
            'note' => $data->note,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function updateWithAddress(Client $client, ClientDTO $data): Client
    {
        return DB::transaction(function () use ($client, $data) {
            $this->update($client, $data);
            $this->upsertAddress($client, $data->address);

            return $client;
        });
    }

    public function upsertAddress(Client $client, AddressDTO $data): Client
    {
        $client->upsertAddress([
            'country' => $data->country,
            'state' => $data->state,
            'city' => $data->city,
            'zip' => $data->zip,
            'street1' => $data->street1,
            'street2' => $data->street2,
        ]);

        return $client;
    }

    /**
     * @throws Throwable
     */
    public function deleteWithAddress(Client $client): ?bool
    {
        return DB::transaction(function () use ($client) {
            $client->address()->delete();

            return $client->delete();
        });
    }
}
