<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

trait HandleUserAlerts
{
    public function dispatchAlert(string|null $event = 'custom-alert', string $type, string $message)
    {
        $this->dispatch($event, type: $type, message: $message);
    }

    public function successAlert(string $message = 'Action was successful...')
    {
        $this->dispatchAlert(event: 'custom-alert', type: 'success', message: $message);
    }

    public function failAlert(string $message = 'Action failed...')
    {
        $this->dispatchAlert(event: 'custom-alert', type: 'error', message: $message);
    }
}
