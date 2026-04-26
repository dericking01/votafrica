<?php

namespace App\Livewire;

use App\Jobs\SendApplicationSubmissionSms;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ApplicationForm extends Component
{
    #[Validate('required|string|max:255')]
    public string $organization_name = '';

    #[Validate('required|string|max:255')]
    public string $business_location = '';

    #[Validate('required|string|max:255')]
    public string $business_activity = '';

    #[Validate('required|string|max:50')]
    public string $phone_number = '';

    #[Validate('nullable|email|max:255')]
    public ?string $email = '';

    #[Validate('required|string|in:100k - 1M,1M -10M,10M-100M,100M-1B,1B and above,Prefer not to say')]
    public string $capital_range = '';

    #[Validate('required|string|in:Government,Private,Public,Small Entrepreneurs,NGO')]
    public string $category = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $data = $this->validate();

        $application = Application::create($data);
        SendApplicationSubmissionSms::dispatch((string) $data['phone_number']);

        Log::info('Application submitted and SMS job dispatched.', [
            'application_id' => $application->id,
            'phone_number' => (string) $data['phone_number'],
        ]);

        $this->reset([
            'organization_name',
            'business_location',
            'business_activity',
            'phone_number',
            'email',
            'capital_range',
            'category',
        ]);

        $this->resetValidation();
        $this->submitted = true;
    }

    public function clearSubmitted(): void
    {
        $this->submitted = false;
    }

    public function render()
    {
        return view('livewire.application-form');
    }
}
