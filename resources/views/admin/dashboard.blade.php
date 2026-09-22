<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APIBridge Admin</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f1f5f9;
            --panel: #ffffff;
            --panel-border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #4f46e5;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --warning-bg: #fef3c7;
            --warning-text: #92400e;
            --muted-bg: #f8fafc;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }
        .min-h-screen { min-height: 100vh; }
        .border-b { border-bottom: 1px solid var(--panel-border); }
        .bg-white { background: var(--panel); }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .max-w-6xl { max-width: 72rem; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .text-xs { font-size: 0.75rem; }
        .font-semibold { font-weight: 600; }
        .uppercase { text-transform: uppercase; }
        .tracking-\[0\.2em\] { letter-spacing: 0.2em; }
        .text-indigo-600 { color: var(--primary); }
        .text-lg { font-size: 1.125rem; }
        .font-bold { font-weight: 700; }
        .rounded-lg { border-radius: 0.5rem; }
        .border { border: 1px solid var(--panel-border); }
        .border-slate-300 { border-color: #cbd5e1; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .text-sm { font-size: 0.875rem; }
        .font-medium { font-weight: 500; }
        .hover\:bg-slate-50:hover { background: #f8fafc; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .grid { display: grid; }
        .gap-4 { gap: 1rem; }
        .md\:grid-cols-3 { @media (min-width: 768px) { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        .rounded-xl { border-radius: 0.75rem; }
        .p-5 { padding: 1.25rem; }
        .shadow { box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08); }
        .ring-1 { box-shadow: inset 0 0 0 1px var(--panel-border); }
        .ring-slate-200 { box-shadow: inset 0 0 0 1px #e2e8f0; }
        .text-slate-500 { color: var(--muted); }
        .mt-3 { margin-top: 0.75rem; }
        .text-3xl { font-size: 1.875rem; }
        .text-emerald-600 { color: #059669; }
        .text-amber-600 { color: #d97706; }
        .mt-8 { margin-top: 2rem; }
        .p-6 { padding: 1.5rem; }
        .overflow-x-auto { overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; }
        th, td { text-align: left; padding: 0.75rem 1rem 0.75rem 0; }
        .text-left { text-align: left; }
        .divide-y > * + * { border-top: 1px solid #e2e8f0; }
        .divide-slate-200 > * + * { border-top-color: #e2e8f0; }
        .divide-slate-100 > * + * { border-top-color: #f1f5f9; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .pr-4 { padding-right: 1rem; }
        .text-slate-600 { color: #475569; }
        .text-xs { font-size: 0.75rem; }
        .rounded-full { border-radius: 9999px; }
        .bg-slate-100 { background: #f1f5f9; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .bg-emerald-100 { background: var(--success-bg); }
        .text-emerald-700 { color: var(--success-text); }
        .bg-amber-100 { background: var(--warning-bg); }
        .text-amber-700 { color: var(--warning-text); }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .text-center { text-align: center; }
        .text-slate-500 { color: var(--muted); }
        .sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; }
        button {
            background: transparent;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            color: var(--text);
            cursor: pointer;
            font: inherit;
        }
        button:hover { background: #f8fafc; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen">
        <nav class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">APIBridge</p>
                    <h1 class="text-lg font-bold">Platform overview</h1>
                </div>
                <form method="POST" action="{{ route('platform.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium hover:bg-slate-50">
                        Sign out
                    </button>
                </form>
            </div>
        </nav>

        <main class="mx-auto max-w-6xl px-6 py-8">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl bg-white p-5 shadow ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Total tenants</p>
                    <h2 class="mt-3 text-3xl font-bold">{{ $tenant_count }}</h2>
                </div>
                <div class="rounded-xl bg-white p-5 shadow ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Active</p>
                    <h2 class="mt-3 text-3xl font-bold text-emerald-600">{{ $active_tenants }}</h2>
                </div>
                <div class="rounded-xl bg-white p-5 shadow ring-1 ring-slate-200">
                    <p class="text-sm text-slate-500">Trials</p>
                    <h2 class="mt-3 text-3xl font-bold text-amber-600">{{ $trial_tenants }}</h2>
                </div>
            </div>

            <div class="mt-8 rounded-xl bg-white p-6 shadow ring-1 ring-slate-200">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold">Recent tenants</h3>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $domain }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-left">
                        <thead>
                            <tr>
                                <th class="py-2 pr-4 text-sm font-semibold text-slate-600">Name</th>
                                <th class="py-2 pr-4 text-sm font-semibold text-slate-600">Status</th>
                                <th class="py-2 pr-4 text-sm font-semibold text-slate-600">Owner</th>
                                <th class="py-2 pr-4 text-sm font-semibold text-slate-600">Database</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tenants as $tenant)
                                <tr>
                                    <td class="py-3 pr-4 font-medium">{{ $tenant->name }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $tenant->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $tenant->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4">{{ $tenant->owner_email }}</td>
                                    <td class="py-3 pr-4">{{ $tenant->database_name ?? 'n/a' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-500">No tenants created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
