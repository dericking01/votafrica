<?php

namespace App\Livewire;

use App\Models\Application;
use Livewire\Component;

class ApplicationDetail extends Component
{
    public Application $application;

    public ?string $notice = null;

    public string $noticeType = 'success';

    public function mount(Application $application): void
    {
        $this->application = $application;
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
    }

    public function render()
    {
        return view('livewire.application-detail');
    }
}
