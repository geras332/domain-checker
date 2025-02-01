<?php

namespace App\Livewire;

use App\Services\DomainCheckerService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Home extends Component
{
    public string $domains = '';
    public array $results = [];
    public bool $isLoading = false;

    protected DomainCheckerService $service;

    public function boot(DomainCheckerService $service): void
    {
        $this->service = $service;
    }

    public function checkDomains(): void
    {
        $this->isLoading = true;
        $this->results = [];

        $domainsArray = array_filter(
            array_map('trim', explode("\n", $this->domains))
        );

        $this->results = $this->service->checkDomains($domainsArray);

        $this->isLoading = false;
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.index');
    }
}
