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

    public function __construct($message, $type = 'info')
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function render(): Factory|View
    {
        return view('components.alert');
    }
}
