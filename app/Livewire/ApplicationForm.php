<?php

namespace App\Livewire;

use App\Models\Application;
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

    #[Validate('required|string|in:10M-100M,100M-1B,1B and above')]
    public string $capital_range = '';

    #[Validate('required|string|in:Government,Private,Public,Small Entrepreneurs')]
    public string $category = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $data = $this->validate();

        Application::create($data);

        $this->reset([
            'organization_name',
            'business_location',
            'business_activity',
            'phone_number',
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
