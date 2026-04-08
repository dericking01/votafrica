<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VotAfrica - Submit Your Business Application</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @livewireStyles
    <style>
        body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; margin: 0; min-height: 100vh; background: linear-gradient(135deg, #1e1e1e 0%, #2d2d2d 100%); color: #111827; }
        .container { max-width: 960px; margin: 0 auto; padding: 24px; }
        .header { text-align: center; margin-bottom: 40px; color: white; }
        .logo { font-size: 2rem; margin-bottom: 16px; }
        .logo img { max-height: 50px; }
        .card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 24px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); padding: 48px; }
        .grid { display: grid; gap: 20px; }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        @media (max-width: 640px) { .grid-cols-2 { grid-template-columns: 1fr; } .card { padding: 24px; } }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .button { border: 0; border-radius: 12px; padding: 12px 20px; background: #ef4444; color: white; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .button:hover { background: #dc2626; }
        .button.secondary { background: #111827; }
        .button.secondary:hover { background: #000; }
        .input, .select, .textarea { width: 100%; border: 1px solid #d1d5db; border-radius: 12px; padding: 12px 14px; font-size: 1rem; box-sizing: border-box; font-family: inherit; }
        .input:focus, .select:focus, .textarea:focus { outline: none; border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239, 68, 68, .16); }
        .label { display: block; margin-bottom: 8px; font-weight: 600; }
        .text-sm { font-size: 0.9rem; color: #6b7280; }
        .alert { padding: 16px; border-radius: 16px; margin-bottom: 20px; }
        .alert-success { background: #ecfdf5; border: 1px solid #d1fae5; color: #065f46; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        a { color: #ef4444; text-decoration: none; }
        .nav-links { display: flex; gap: 12px; margin-top: 20px; }
        .nav-links a { padding: 8px 16px; border-radius: 8px; background: rgba(255,255,255,0.1); color: white; font-size: 0.9rem; transition: background 0.2s; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('images/votafricalogo-removebg.png') }}" alt="VotAfrica" />
            </div>
            <h1 style="font-size: 2.5rem; margin: 16px 0 8px; font-weight: 700;">Biashara Forum</h1>
            <p style="margin: 0; font-size: 1.1rem; opacity: 0.9;">Quick & easy registration. No signup required.</p>
            <div class="nav-links">
                <a href="{{ route('login') }}" wire:navigate>Admin Login</a>
            </div>
        </div>

        <div class="card">
            <livewire:application-form />
        </div>
    </div>
    @livewireScripts
</body>
</html>
