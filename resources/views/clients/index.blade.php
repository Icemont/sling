<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <ol class="page-title breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item active" aria-current="page">{{ __('Clients') }}</li>
            </ol>
            <div class="ms-auto">
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    {{ __('Add client') }}
                </a>
            </div>
        </div>
    </x-slot>
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($clients))
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('E-mail') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th class="w-1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{ $client->id }}</td>
                                        <td>
                                            <a href="{{ route('clients.show', ['client' => $client->id]) }}">{{ $client->name }}</a>
                                        </td>
                                        <td class="text-green">{{ $client->email }}</td>
                                        <td class="text-secondary">{{ $client->phone ?: '—' }}</td>
                                        <td class="text-secondary text-nowrap w-1">{{ $client->created_at->format('d.m.Y H:i') }}</td>
                                        <td class="text-end text-nowrap">
                                            <a href="{{ route('clients.edit', ['client' => $client->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                <x-icon-edit class="text-red" />
                                            </a>
                                            <a class="ms-2" href="{{ route('clients.show', ['client' => $client->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Show') }}">
                                                <x-icon-show />
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer d-flex align-items-center">
                                <p class="m-0 text-muted">{{ __('Showing :first to :last of :total entries', [
                                        'first' => $clients->firstItem(),
                                        'last' => $clients->lastItem(),
                                        'total' => $clients->total(),
                                    ]) }}</p>
                                @if($clients->hasPages())
                                    <p class="pagination m-0 ms-auto">{{ $clients->links() }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="empty">
                            <div class="empty-img">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-primary" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                </svg>
                            </div>
                            <p class="empty-title">{{ __('Clients are managed from here') }}</p>
                            <p class="empty-subtitle text-secondary">
                                {{ __('There are no clients in the database yet') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
