<?php

namespace App\Livewire;

use App\Models\Application;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationsTable extends Component
{
    use WithPagination;

    public bool $showFilters = false;

    #[Url(as: 'search', history: true)]
    public string $search = '';

    #[Url(as: 'tab', history: true)]
    public string $tab = 'active';

    #[Url(as: 'status', history: true)]
    public string $statusFilter = 'all';

    #[Url(as: 'category', history: true)]
    public string $categoryFilter = 'all';

    #[Url(as: 'capital', history: true)]
    public string $capitalFilter = 'all';

    #[Url(as: 'from', history: true)]
    public string $dateFrom = '';

    #[Url(as: 'to', history: true)]
    public string $dateTo = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        if (! in_array($this->statusFilter, ['all', 'active', 'archived'], true)) {
            $this->statusFilter = 'all';
        }

        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        if (! in_array($this->categoryFilter, ['all', 'Government', 'Private', 'Public', 'Small Entrepreneurs'], true)) {
            $this->categoryFilter = 'all';
        }

        $this->resetPage();
    }

    public function updatedCapitalFilter(): void
    {
        if (! in_array($this->capitalFilter, ['all', '10M-100M', '100M-1B', '1B and above'], true)) {
            $this->capitalFilter = 'all';
        }

        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
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

    public function toggleFilters(): void
    {
        $this->showFilters = ! $this->showFilters;
    }

    public function clearFilters(): void
    {
        $this->statusFilter = 'all';
        $this->categoryFilter = 'all';
        $this->capitalFilter = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function hasActiveFilters(): bool
    {
        return $this->statusFilter !== 'all'
            || $this->categoryFilter !== 'all'
            || $this->capitalFilter !== 'all'
            || $this->dateFrom !== ''
            || $this->dateTo !== '';
    }

    public function isArchivedView(): bool
    {
        if ($this->statusFilter === 'archived') {
            return true;
        }

        if ($this->statusFilter === 'active') {
            return false;
        }

        return $this->tab === 'archived';
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
        $baseQuery = Application::withTrashed()
            ->when($this->isArchivedView(), fn ($query) => $query->onlyTrashed())
            ->when(! $this->isArchivedView(), function ($query) {
                if ($this->statusFilter === 'active' || $this->statusFilter === 'all') {
                    $query->whereNull('deleted_at');
                }
            });

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
            ->when($this->categoryFilter !== 'all', fn ($query) => $query->where('category', $this->categoryFilter))
            ->when($this->capitalFilter !== 'all', fn ($query) => $query->where('capital_range', $this->capitalFilter))
            ->when($this->dateFrom !== '', fn ($query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo !== '', fn ($query) => $query->whereDate('created_at', '<=', $this->dateTo))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.applications-table', [
            'applications' => $applications,
        ]);
    }
}
