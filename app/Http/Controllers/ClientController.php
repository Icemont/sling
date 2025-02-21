<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ClientController extends Controller
{
    public function index(ClientRepository $clientRepository): View|Factory
    {
        return view('clients.index', [
            'clients' => $clientRepository->getPaginated(),
        ]);
    }

    public function show(Client $client): View|Factory
    {
        return view('clients.show', compact('client'));
    }

    public function create(): View|Factory
    {
        return view('clients.create');
    }

    /**
     * @throws Throwable
     */
    public function store(ClientStoreRequest $request, ClientRepository $clientRepository): RedirectResponse
    {
        $client = $clientRepository->createWithAddress($request->getClientData());

        return redirect()
            ->route('clients.index')
            ->with([
                'status' => __('New client ":client" successfully added!', ['client' => $client->name]),
                'type' => 'success',
            ]);
    }

    public function edit(Client $client): View|Factory
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * @throws Throwable
     * @throws AuthorizationException
     */
    public function update(
        ClientStoreRequest $request,
        ClientRepository $clientRepository,
        Client $client
    ): RedirectResponse {
        $this->authorize('owner', $client);

        $clientRepository->updateWithAddress($client, $request->getClientData());

        return redirect()
            ->route('clients.index')
            ->with([
                'status' => __('Client ":client" successfully updated!', ['client' => $client->name]),
                'type' => 'success',
            ]);
    }

    /**
     * @throws AuthorizationException|Throwable
     */
    public function destroy(ClientRepository $clientRepository, Client $client): RedirectResponse
    {
        $this->authorize('owner', $client);

        $clientRepository->deleteWithAddress($client);

        return redirect()->route('clients.index')->with([
            'status' => __('Client ":client" deleted!', ['client' => $client->name]),
            'type' => 'info',
        ]);
    }
}
