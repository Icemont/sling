<x-app-layout>
    <x-slot name="header">
        <div class="d-flex">
            <h2 class="page-title">
                {{ __('Reports') }}
            </h2>
        </div>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h4 class="alert-title">{{ __('The report was not created because there are errors in the form') }}:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Sales report generation') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.create') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 offset-lg-2">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('From Date') }}</label>
                                    <input type="text" class="form-control" id="from_date" name="from_date"
                                           value="{{ old('from_date') ?? now()->startOfMonth()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label required">{{ __('To Date') }}</label>
                                    <input type="text" class="form-control" id="to_date" name="to_date"
                                           value="{{ old('to_date') ?? now()->endOfMonth()->format('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 offset-lg-2">
                                <div class="mb-3">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" id="download" name="download"
                                               value="1"{{ old('download') ? ' checked' : '' }}>
                                        <span class="form-check-label">{{ __('Download as PDF') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-footer text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="icon icon-tabler icon-tabler-report" width="24" height="24"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697"></path>
                                            <path d="M18 14v4h4"></path>
                                            <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2"></path>
                                            <rect x="8" y="3" width="6" height="4" rx="2"></rect>
                                            <circle cx="18" cy="18" r="4"></circle>
                                            <path d="M8 11h4"></path>
                                            <path d="M8 15h3"></path>
                                        </svg>
                                        {{ __('Create Report') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var previousButton = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>`;
            var nextButton = `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>`;

            window.Litepicker &&
            (new Litepicker({
                element: document.getElementById('from_date'),
                buttonText: {
                    previousMonth: previousButton,
                    nextMonth: nextButton,
                },
            })) &&
            (new Litepicker({
                element: document.getElementById('to_date'),
                buttonText: {
                    previousMonth: previousButton,
                    nextMonth: nextButton,
                },
            }));
        });
    </script>
</x-app-layout>
