<?php

namespace App\Livewire;

use App\Models\Application;
use Illuminate\Database\Eloquent\Builder;
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

    #[Url(as: 'payment', history: true)]
    public string $paymentFilter = 'all';

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
        if (! in_array($this->categoryFilter, ['all', 'Government', 'Private', 'Public', 'Small Entrepreneurs', 'NGO'], true)) {
            $this->categoryFilter = 'all';
        }

        $this->resetPage();
    }

    public function updatedCapitalFilter(): void
    {
        if (! in_array($this->capitalFilter, ['all', '100k - 1M', '1M -10M', '10M-100M', '100M-1B', '1B and above', 'Prefer not to say'], true)) {
            $this->capitalFilter = 'all';
        }

        $this->resetPage();
    }

    public function updatedPaymentFilter(): void
    {
        if (! in_array($this->paymentFilter, ['all', 'PAID', 'UNPAID'], true)) {
            $this->paymentFilter = 'all';
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
        $this->paymentFilter = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function hasActiveFilters(): bool
    {
        return $this->statusFilter !== 'all'
            || $this->categoryFilter !== 'all'
            || $this->capitalFilter !== 'all'
            || $this->paymentFilter !== 'all'
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

    public function exportFilteredApplications()
    {
        $rows = $this->filteredQuery()
            ->orderByDesc('created_at')
            ->get([
                'organization_name',
                'business_location',
                'business_activity',
                'phone_number',
                'email',
                'capital_range',
                'category',
                'payment_status',
                'deleted_at',
                'created_at',
            ]);

        $fileName = 'applications-export-'.now()->format('Ymd_His').'.xls';

        return response()->streamDownload(function () use ($rows) {
            $output = fopen('php://output', 'wb');

            // Add UTF-8 BOM so Excel reads special characters correctly.
            fwrite($output, "\xEF\xBB\xBF");

            fputcsv($output, [
                'Organization',
                'Location',
                'Activity',
                'Phone',
                'Email',
                'Capital Range',
                'Category',
                'Payment Status',
                'Record Status',
                'Submitted At',
            ]);

            foreach ($rows as $row) {
                fputcsv($output, [
                    (string) $row->organization_name,
                    (string) $row->business_location,
                    (string) $row->business_activity,
                    (string) $row->phone_number,
                    (string) ($row->email ?? ''),
                    (string) $row->capital_range,
                    (string) $row->category,
                    (string) ($row->payment_status ?: 'UNPAID'),
                    $row->deleted_at ? 'Archived' : 'Active',
                    optional($row->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($output);
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    protected function filteredQuery(): Builder
    {
        return Application::withTrashed()
            ->when($this->isArchivedView(), fn (Builder $query) => $query->onlyTrashed())
            ->when(! $this->isArchivedView(), function (Builder $query) {
                if ($this->statusFilter === 'active' || $this->statusFilter === 'all') {
                    $query->whereNull('deleted_at');
                }
            })
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('organization_name', 'like', "%{$this->search}%")
                        ->orWhere('business_location', 'like', "%{$this->search}%")
                        ->orWhere('business_activity', 'like', "%{$this->search}%")
                        ->orWhere('phone_number', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('category', 'like', "%{$this->search}%")
                        ->orWhere('payment_status', 'like', "%{$this->search}%");
                });
            })
            ->when($this->categoryFilter !== 'all', fn (Builder $query) => $query->where('category', $this->categoryFilter))
            ->when($this->capitalFilter !== 'all', fn (Builder $query) => $query->where('capital_range', $this->capitalFilter))
            ->when($this->paymentFilter !== 'all', fn (Builder $query) => $query->where('payment_status', $this->paymentFilter))
            ->when($this->dateFrom !== '', fn (Builder $query) => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo !== '', fn (Builder $query) => $query->whereDate('created_at', '<=', $this->dateTo));
    }

    public function render()
    {
        $applications = $this->filteredQuery()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.applications-table', [
            'applications' => $applications,
        ]);
    }
}
