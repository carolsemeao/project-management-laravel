<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $modalId,
        public string $title,
        public string $formID,
        public string $action,
        public string $method,
        public ?string $methodType,
        public string $cancelButtonText = 'Cancel',
        public string $confirmButtonText = 'Confirm'
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.custom-modal');
    }
}
