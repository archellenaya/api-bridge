<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Management</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f1f5f9;
            color: #0f172a;
            font-family: Arial, Helvetica, sans-serif;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 32px 20px; }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 20px;
        }
        .nav-title { font-weight: 700; font-size: 1.1rem; }
        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            background: white;
            font-weight: 600;
        }
        .button.primary {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.05);
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .alert {
            padding: 12px 14px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 8px;
            margin-bottom: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        th {
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .status.trial { background: #fef3c7; color: #92400e; }
        .status.active { background: #dcfce7; color: #166534; }
        .status.paused { background: #e0f2fe; color: #075985; }
        .status.suspended { background: #fee2e2; color: #991b1b; }
        .muted { color: #64748b; }
        .actions { display: flex; gap: 8px; }
        .link {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="nav-title">APIBridge Admin</div>
        <div class="actions">
            <a href="{{ route('platform.dashboard') }}" class="button">Dashboard</a>
            <a href="{{ route('platform.logout') }}" class="button">Sign out</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="header-row">
                <div>
                    <div class="muted">Platform</div>
                    <h1 style="margin: 6px 0 0; font-size: 2rem;">Tenant management</h1>
                </div>
                <a href="{{ route('platform.tenants.create') }}" class="button primary">Create tenant</a>
            </div>

            @if (session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Owner</th>
                        <th>Database</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->name }}</td>
                            <td>{{ $tenant->slug }}</td>
                            <td><span class="status {{ $tenant->status }}">{{ $tenant->status }}</span></td>
                            <td>{{ $tenant->owner_email }}</td>
                            <td>{{ $tenant->database_name ?? 'n/a' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('platform.tenants.edit', $tenant) }}" class="link">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="muted" style="padding-top: 18px;">No tenants yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
