<div>
    <div x-data="{ show: @entangle('submitted').live }"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         x-init="$watch('show', value => { if (value) { clearTimeout(window.votafricaSuccessTimer); window.votafricaSuccessTimer = setTimeout(() => { show = false; }, 4000); } })"
         class="alert alert-success"
         style="display:none;">
        ✓ Your application has been submitted successfully. Thank you!
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Please fix the following issues:</strong>
            <ul style="margin: 8px 0 0 20px; padding: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit="submit" novalidate>
        <div class="grid grid-cols-2" style="gap:24px;">
            <div>
                <label class="label" for="organization_name">Organization name</label>
                <input id="organization_name" wire:model.blur="organization_name" class="input" type="text" placeholder="ACME Trading Ltd" required />
                @error('organization_name') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="phone_number">Phone number</label>
                <input id="phone_number" wire:model.blur="phone_number" class="input" type="text" placeholder="+254 700 000 000" required />
                @error('phone_number') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="business_location">Business location</label>
                <input id="business_location" wire:model.blur="business_location" class="input" type="text" placeholder="Nairobi, Kenya" required />
                @error('business_location') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="business_activity">Business activity</label>
                <input id="business_activity" wire:model.blur="business_activity" class="input" type="text" placeholder="Retail, Import/Export" required />
                @error('business_activity') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="capital_range">Capital range</label>
                <select id="capital_range" wire:model.blur="capital_range" class="select" required>
                    <option value="">Choose range</option>
                    <option value="10M-100M">10M - 100M</option>
                    <option value="100M-1B">100M - 1B</option>
                    <option value="1B and above">1B and above</option>
                </select>
                @error('capital_range') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="category">Category</label>
                <select id="category" wire:model.blur="category" class="select" required>
                    <option value="">Choose category</option>
                    <option value="Government">Government</option>
                    <option value="Private">Private</option>
                    <option value="Public">Public</option>
                    <option value="Small Entrepreneurs">Small Entrepreneurs</option>
                </select>
                @error('category') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-between" style="margin-top: 32px; gap: 16px; flex-wrap: wrap; align-items: center;">
            <p class="text-sm" style="margin: 0;">All fields required • No approval needed</p>
            <button type="submit" class="button" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Submit application</span>
                <span wire:loading wire:target="submit">Submitting...</span>
            </button>
        </div>
    </form>
</div>
