<div x-data="{ showPaymentModal: false }" @keydown.escape.window="showPaymentModal = false">
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
        <div class="grid" style="grid-template-columns: repeat(2, minmax(0, 1fr)); gap:16px; align-items:start;">
            <div>
                <label class="label" for="organization_name">Business name</label>
                <input id="organization_name" wire:model.blur="organization_name" class="input" type="text" placeholder="ACME Trading Ltd" required style="height:42px;" />
                @error('organization_name') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="phone_number">Phone number</label>
                <input id="phone_number" wire:model.blur="phone_number" class="input" type="text" placeholder="+255__" required style="height:42px;" />
                @error('phone_number') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="email">Email (optional)</label>
                <input id="email" wire:model.blur="email" class="input" type="email" placeholder="name@example.com" style="height:42px;" />
                @error('email') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="business_location">Business location</label>
                <input id="business_location" wire:model.blur="business_location" class="input" type="text" placeholder="Dodoma, Tanzania" required style="height:42px;" />
                @error('business_location') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="business_activity">Business activity</label>
                <input id="business_activity" wire:model.blur="business_activity" class="input" type="text" placeholder="Retail, Import/Export" required style="height:42px;" />
                @error('business_activity') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="capital_range">Capital range</label>
                <select id="capital_range" wire:model.blur="capital_range" class="select" required style="min-height:44px; line-height:1.4; padding-top:8px; padding-bottom:8px;">
                    <option value="">Choose range</option>
                    <option value="100k - 1M">100k - 1M</option>
                    <option value="1M -10M">1M -10M</option>
                    <option value="10M-100M">10M - 100M</option>
                    <option value="100M-1B">100M - 1B</option>
                    <option value="1B and above">1B and above</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>
                @error('capital_range') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label" for="category">Category</label>
                <select id="category" wire:model.blur="category" class="select" required style="min-height:44px; line-height:1.4; padding-top:8px; padding-bottom:8px;">
                    <option value="">Choose category</option>
                    <option value="Government">Government</option>
                    <option value="Private">Private</option>
                    <option value="Public">Public</option>
                    <option value="Small Entrepreneurs">Small Entrepreneurs</option>
                    <option value="NGO">NGO</option>
                </select>
                @error('category') <p style="color:#991b1b; font-size:0.85rem; margin: 4px 0 0 0;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="margin-top: 20px;">
            <p class="text-sm" style="margin: 0; text-align: center;">All fields required except email</p>
            <p class="text-sm" style="margin: 8px 0 0 0; text-align: center; color:#b91c1c; font-weight:700;">For More info dial: 0765-043-474</p>

            <div style="margin-top: 10px; display: flex; justify-content: center;">
                <button
                    type="button"
                    @click="showPaymentModal = true"
                    class="button"
                    style="max-width:280px; width:100%; background:#0f766e;">
                    View payment info
                </button>
            </div>

            <div style="margin-top: 12px; display: flex; justify-content: center;">
                <button type="submit" class="button" style="width:100%;max-width:280px;" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Submit application</span>
                    <span wire:loading wire:target="submit">Submitting...</span>
                </button>
            </div>
        </div>
    </form>

    <div
        x-show="showPaymentModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.self="showPaymentModal = false"
        style="position:fixed; inset:0; background:rgba(15,23,42,0.65); z-index:60; display:none; padding:20px;">
        <div style="max-width:520px; margin:6vh auto 0 auto; background:#ffffff; border-radius:14px; padding:20px; box-shadow:0 22px 60px rgba(15,23,42,0.22);">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                <h3 style="margin:0; font-size:1.1rem; font-weight:700; color:#0f172a;">Payment Information</h3>
                <button type="button" @click="showPaymentModal = false" style="border:none; background:transparent; font-size:1.3rem; line-height:1; color:#475569; cursor:pointer;">&times;</button>
            </div>

            <div style="margin-top:14px; text-align:center;">
                <img src="{{ asset('images/crdb_logo.avif') }}" alt="CRDB Bank logo" style="height:72px; width:auto; object-fit:contain; margin:0 auto;" />
            </div>

            <p style="margin:16px 0 0 0; color:#1e293b; font-size:0.98rem; line-height:1.6;">
                CRDB BANK account #: <strong>0150875721300</strong><br>
                Acc name: <strong>Voice of Talent (VOT) Africa</strong>
            </p>

            <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                <button type="button" @click="showPaymentModal = false" class="button" style="max-width:140px;">Close</button>
            </div>
        </div>
    </div>
</div>
