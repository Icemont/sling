<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClientRepository
{
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return Client::orderByDesc('id')
            ->paginate(config('app.per_page.clients', $perPage));
    }

    public function create(ClientStoreRequest $request): Client
    {
        return Client::create($request->getClientPayload(true));
    }

    /**
     * @throws Throwable
     */
    public function createWithAddress(ClientStoreRequest $request): Client
    {
        return DB::transaction(function () use ($request) {
            $client = $this->create($request);
            $client->upsertAddress($request->getClientAddressPayload());

            return $client;
        });
    }

    public function update(Client $client, ClientStoreRequest $request): bool
    {
        return $client->update($request->getClientPayload());
    }

    /**
     * @throws Throwable
     */
    public function updateWithAddress(Client $client, ClientStoreRequest $request): Client
    {
        return DB::transaction(function () use ($request, $client) {
            $this->update($client, $request);
            $client->upsertAddress($request->getClientAddressPayload());

            return $client;
        });
    }

    public function deleteWithAddress(Client $client): ?bool
    {
        $client->address()->delete();
        return $client->delete();
    }
}