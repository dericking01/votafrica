<?php

namespace App\Livewire;

use App\Models\Application;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationsTable extends Component
{
    use WithPagination;

    #[Url(as: 'search', history: true)]
    public string $search = '';

    #[Url(as: 'tab', history: true)]
    public string $tab = 'active';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTab(): void
    {
        if (! in_array($this->tab, ['active', 'archived'], true)) {
            $this->tab = 'active';
        }

        $this->resetPage();
    }

    public function setTab(string $tab): void
    {
        $this->tab = in_array($tab, ['active', 'archived'], true) ? $tab : 'active';
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function restoreApplication(int $applicationId): void
    {
        $application = Application::withTrashed()->find($applicationId);

        if (! $application || ! $application->trashed()) {
            return;
        }

        $application->restore();
    }

    public function render()
    {
        $baseQuery = $this->tab === 'archived'
            ? Application::onlyTrashed()
            : Application::query();

        $applications = $baseQuery
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('organization_name', 'like', "%{$this->search}%")
                        ->orWhere('business_location', 'like', "%{$this->search}%")
                        ->orWhere('business_activity', 'like', "%{$this->search}%")
                        ->orWhere('phone_number', 'like', "%{$this->search}%")
                        ->orWhere('category', 'like', "%{$this->search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.applications-table', [
            'applications' => $applications,
        ]);
    }
}
