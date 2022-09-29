<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Values\Address;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function index(): View
    {
        $clients = Client::getPaginated();
        return view('clients.index', compact('clients'));
    }

    public function store(ClientStoreRequest $request): RedirectResponse
    {
        $client = Client::createClientWithAddress($request->validated());

        return redirect()
            ->route('clients.index')
            ->with([
                'status' => __('New client ":client" successfully added!', ['client' => $client->name]),
                'type' => 'success'
            ]);
    }

    public function show(Client $client): View
    {
        $address = new Address($client->address);
        return view('clients.show', compact('client', 'address'));
    }

    public function edit(Client $client): View
    {
        $address = new Address($client->address);
        return view('clients.edit', compact('client', 'address'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(ClientUpdateRequest $request, Client $client): RedirectResponse
    {
        $this->authorize('owner', $client);

        $client->updateClientWithAddress($client, $request->validated());

        return redirect()
            ->route('clients.index')
            ->with([
                'status' => __('Client ":client" successfully updated!', ['client' => $client->name]),
                'type' => 'success'
            ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Client $client): RedirectResponse
    {
        $this->authorize('owner', $client);

        $client->deleteWithAddress();

        return redirect()->route('clients.index')->with([
            'status' => __('Client ":client" deleted!', ['client' => $client->name]),
            'type' => 'info'
        ]);
    }
}
