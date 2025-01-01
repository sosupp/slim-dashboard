<?php
namespace Sosupp\SlimDashboard\ValueObjects;

use Illuminate\Support\Collection;

final class CardEdit
{

    public function __construct(
        public string $title = '',
        public string $form = '',
        public string $navigate = '',
    )
    {
        $this->title = $title;
        $this->form = $form;
        $this->navigate = $navigate;
    }

    public function toArray(): array|Collection
    {
        return [
            'title' => $this->title,
            'form' => $this->form,
            'navigate' => $this->navigate,
        ];
    }

}
