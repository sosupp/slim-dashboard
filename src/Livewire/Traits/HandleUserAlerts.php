<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

trait HandleUserAlerts
{
    public function dispatchAlert(string|null $event = 'custom-alert', string $type, string $message, bool $autoClose = true)
    {
        $this->dispatch(
            $event, type: $type, message: $message, close: $autoClose
        );
    }

    public function successAlert(string $message = 'Action was successful...', bool $autoClose = true)
    {
        $this->dispatchAlert(
            event: 'custom-alert', type: 'success',
            message: $message, autoClose: $autoClose
        );
    }

    public function failAlert(string $message = 'Action failed...', bool $autoClose = true)
    {
        $this->dispatchAlert(
            event: 'custom-alert', type: 'error',
            message: $message, autoClose: $autoClose
        );
    }
}
