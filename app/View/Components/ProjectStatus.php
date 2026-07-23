<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectStatus extends Component
{
    public string $statusClass;
    public string $sizeClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type,
        public string $size = ''
    )
    {
        $this->statusClass = match($type) {
            'active'                 => 'status-primary',
            'on-hold'                => 'status-warning',
            'cancelled', 'completed' => 'status-error',
            default                  => '',
        };

        $this->sizeClass = match($size) {
            'xs' => 'status-xs',
            'sm' => 'status-sm',
            'md' => 'status-md',
            'lg' => 'status-lg',
            'xl' => 'status-xl',
            default => '',
        }; 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.project-status');
    }
}
