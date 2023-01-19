<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Repositories\PaymentMethodRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentMethodController extends Controller
{
    public function __construct(private readonly PaymentMethodRepository $paymentMethodRepository)
    {
    }

    public function index(): View|Factory
    {
        return view('payments.methods.index', [
            'payment_methods' => $this->paymentMethodRepository->getPaginated(),
        ]);
    }

    public function create(): View|Factory
    {
        return view('payments.methods.create');
    }

    public function store(PaymentMethodRequest $request): RedirectResponse
    {
        $paymentMethod = $this->paymentMethodRepository->create($request);

        return redirect()
            ->route('payment-methods.index')
            ->with([
                'status' => __('New payment method ":method" successfully added!', [
                    'method' => $paymentMethod->name,
                ]),
                'type' => 'success'
            ]);
    }

    public function show(PaymentMethod $paymentMethod): View|Factory
    {
        return view('payments.methods.show', compact('paymentMethod'));
    }

    public function edit(PaymentMethod $paymentMethod): View|Factory
    {
        return view('payments.methods.edit', compact('paymentMethod'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(PaymentMethodRequest $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $this->authorize('owner', $paymentMethod);

        $this->paymentMethodRepository->updatePaymentMethod($paymentMethod, $request);

        return redirect()
            ->route('payment-methods.index')
            ->with([
                'status' => __('Payment method ":method" successfully updated!', [
                    'method' => $paymentMethod->name,
                ]),
                'type' => 'success'
            ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        $this->authorize('owner', $paymentMethod);

        if ($paymentMethod->invoices()->count() > 0) {
            return redirect()->back()->with([
                'status' => __('Payment method ":method" is used by invoices and cannot be deleted!', [
                    'method' => $paymentMethod->name,
                ]),
                'type' => 'danger'
            ]);
        }

        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')->with([
            'status' => __('Payment method ":method" deleted!', ['method' => $paymentMethod->name]),
            'type' => 'info'
        ]);
    }
}
