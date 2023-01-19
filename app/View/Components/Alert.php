<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $type;
    public string $message;

    public function __construct(string $message, string $type = 'info')
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function render(): Factory|View
    {
        return view('components.alert');
    }
}
