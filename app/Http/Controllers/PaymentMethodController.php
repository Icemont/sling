<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentMethodController extends Controller
{
    public function index(): View
    {
        $payment_methods = PaymentMethod::getPaginated();
        return view('payments.methods.index', compact('payment_methods'));
    }

    public function create(): View
    {
        return view('payments.methods.create');
    }

    public function store(PaymentMethodRequest $request): RedirectResponse
    {
        $payment_method = auth()->user()->createPaymentMethod($request->validated());

        return redirect()
            ->route('payment-methods.index')
            ->with([
                'status' => __('New payment method ":method" successfully added!', ['method' => $payment_method->name]),
                'type' => 'success'
            ]);
    }

    public function show(PaymentMethod $payment_method): View
    {
        return view('payments.methods.show', compact('payment_method'));
    }

    public function edit(PaymentMethod $payment_method): View
    {
        return view('payments.methods.edit', compact('payment_method'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(PaymentMethodRequest $request, PaymentMethod $payment_method): RedirectResponse
    {
        $this->authorize('owner', $payment_method);

        $payment_method->updatePaymentMethod($request->validated());

        return redirect()
            ->route('payment-methods.index')
            ->with([
                'status' => __('Payment method ":method" successfully updated!', ['method' => $payment_method->name]),
                'type' => 'success'
            ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(PaymentMethod $payment_method): RedirectResponse
    {
        $this->authorize('owner', $payment_method);

        if ($payment_method->invoices()->count() > 0) {
            return redirect()->back()->with([
                'status' => __('Payment method ":method" is used by invoices and cannot be deleted!', ['method' => $payment_method->name]),
                'type' => 'danger'
            ]);
        }

        $payment_method->delete();

        return redirect()->route('payment-methods.index')->with([
            'status' => __('Payment method ":method" deleted!', ['method' => $payment_method->name]),
            'type' => 'info'
        ]);
    }
}
