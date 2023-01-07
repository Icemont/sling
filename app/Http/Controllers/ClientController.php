<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ClientController extends Controller
{
    public function __construct(private readonly ClientRepository $clientRepository)
    {
    }

    public function index(): View
    {
        return view('clients.index', [
            'clients' => $this->clientRepository->getPaginated(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(ClientStoreRequest $request): RedirectResponse
    {
        $client = $this->clientRepository->createWithAddress($request);

        return redirect()
            ->route('clients.index')
            ->with([
                'status' => __('New client ":client" successfully added!', ['client' => $client->name]),
                'type' => 'success'
            ]);
    }

    public function show(Client $client): View
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * @throws Throwable
     * @throws AuthorizationException
     */
    public function update(ClientStoreRequest $request, Client $client): RedirectResponse
    {
        $this->authorize('owner', $client);

        $this->clientRepository->updateWithAddress($client, $request);

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

        $this->clientRepository->deleteWithAddress($client);

        return redirect()->route('clients.index')->with([
            'status' => __('Client ":client" deleted!', ['client' => $client->name]),
            'type' => 'info'
        ]);
    }
}
