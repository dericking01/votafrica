<?php

namespace App\Livewire;

use App\Models\Application;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ApplicationDetail extends Component
{
    public Application $application;

    public bool $isEditing = false;

    public string $business_location = '';

    public string $phone_number = '';

    public ?string $email = '';

    public string $capital_range = '';

    public string $category = '';

    public ?string $notice = null;

    public string $noticeType = 'success';

    public function mount(Application $application): void
    {
        $this->application = $application;
        $this->fillFormFromApplication();
    }

    public function edit(): void
    {
        $this->fillFormFromApplication();
        $this->isEditing = true;
    }

    public function cancelEdit(): void
    {
        $this->fillFormFromApplication();
        $this->resetValidation();
        $this->isEditing = false;
    }

    public function saveEdit(): void
    {
        $validated = $this->validate([
            'business_location' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'capital_range' => ['required', 'string', Rule::in(['100k - 1M', '1M -10M', '10M-100M', '100M-1B', '1B and above', 'Prefer not to say'])],
            'category' => ['required', 'string', Rule::in(['Government', 'Private', 'Public', 'Small Entrepreneurs', 'NGO'])],
        ]);

        $this->application->update($validated);

        $this->refreshApplication();
        $this->isEditing = false;
        $this->noticeType = 'success';
        $this->notice = 'Application details updated successfully.';
    }

    public function archive(): void
    {
        if ($this->application->trashed()) {
            return;
        }

        $this->application->delete();
        $this->refreshApplication();
        $this->noticeType = 'success';
        $this->notice = 'Application archived. It is now hidden from the main list.';
    }

    public function restore(): void
    {
        if (! $this->application->trashed()) {
            return;
        }

        $this->application->restore();
        $this->refreshApplication();
        $this->noticeType = 'success';
        $this->notice = 'Application restored and visible in the main list again.';
    }

    protected function refreshApplication(): void
    {
        $this->application = Application::withTrashed()->findOrFail($this->application->id);
        $this->fillFormFromApplication();
    }

    protected function fillFormFromApplication(): void
    {
        $this->business_location = (string) $this->application->business_location;
        $this->phone_number = (string) $this->application->phone_number;
        $this->email = $this->application->email !== null ? (string) $this->application->email : '';
        $this->capital_range = (string) $this->application->capital_range;
        $this->category = (string) $this->application->category;
    }

    public function render()
    {
        return view('livewire.application-detail');
    }
}
