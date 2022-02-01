<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Values\Address;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::getPaginated();
        return view('clients.index', compact('clients'));
    }

    public function store(ClientStoreRequest $request)
    {
        $client = Client::createClientWithAddress($request->validated());

        return redirect()
            ->route('clients.index')
            ->with([
                'status' => __('New client ":client" successfully added!', ['client' => $client->name]),
                'type' => 'success'
            ]);
    }

    public function show(Client $client)
    {
        $address = new Address($client->address);
        return view('clients.show', compact('client', 'address'));
    }

    public function edit(Client $client)
    {
        $address = new Address($client->address);
        return view('clients.edit', compact('client', 'address'));
    }

    public function update(ClientUpdateRequest $request, Client $client)
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

    public function destroy(Client $client)
    {
        $this->authorize('owner', $client);

        $client->deleteWithAddress();

        return redirect()->route('clients.index')->with([
            'status' => __('Client ":client" deleted!', ['client' => $client->name]),
            'type' => 'info'
        ]);
    }
}
