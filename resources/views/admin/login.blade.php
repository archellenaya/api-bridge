<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APIBridge Admin Login</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #f1f5f9;
            --panel: #ffffff;
            --panel-border: #e2e8f0;
            --text: #0f172a;
            --muted: #475569;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
            --danger-text: #b91c1c;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }
        .min-h-screen { min-height: 100vh; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .w-full { width: 100%; }
        .max-w-md { max-width: 28rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .bg-white { background: var(--panel); }
        .p-8 { padding: 2rem; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.1); }
        .ring-1 { box-shadow: inset 0 0 0 1px var(--panel-border); }
        .ring-slate-200 { box-shadow: inset 0 0 0 1px #e2e8f0; }
        .mb-6 { margin-bottom: 1.5rem; }
        .text-sm { font-size: 0.875rem; }
        .font-semibold { font-weight: 600; }
        .uppercase { text-transform: uppercase; }
        .tracking-\[0\.2em\] { letter-spacing: 0.2em; }
        .text-indigo-600 { color: #4f46e5; }
        .mt-2 { margin-top: 0.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .font-bold { font-weight: 700; }
        .mb-4 { margin-bottom: 1rem; }
        .border { border: 1px solid var(--panel-border); }
        .border-red-200 { border-color: var(--danger-border); }
        .bg-red-50 { background: var(--danger-bg); }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .text-red-700 { color: var(--danger-text); }
        .space-y-4 > * + * { margin-top: 1rem; }
        .block { display: block; }
        .mb-1 { margin-bottom: 0.25rem; }
        .font-medium { font-weight: 500; }
        .text-slate-700 { color: #334155; }
        .w-full input, .w-full button { width: 100%; }
        input {
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            padding: 0.7rem 0.75rem;
            font-size: 1rem;
            outline: none;
        }
        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        button {
            border: none;
            border-radius: 0.5rem;
            background: var(--primary);
            color: white;
            font-weight: 500;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        button:hover { background: var(--primary-hover); }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
            <div class="mb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-600">APIBridge</p>
                <h1 class="mt-2 text-3xl font-bold">Platform admin</h1>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('platform.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none" />
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none" />
                </div>

                <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 font-medium text-white transition hover:bg-indigo-500">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</body>
</html>
