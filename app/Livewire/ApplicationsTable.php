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

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $applications = Application::query()
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
