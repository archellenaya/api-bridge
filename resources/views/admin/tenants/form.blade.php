<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode === 'edit' ? 'Edit Tenant' : 'Create Tenant' }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f1f5f9;
            color: #0f172a;
            font-family: Arial, Helvetica, sans-serif;
        }
        .container { max-width: 760px; margin: 0 auto; padding: 32px 20px; }
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.05);
        }
        h1 { margin-top: 0; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .field { display: flex; flex-direction: column; gap: 8px; }
        .field.full { grid-column: 1 / -1; }
        label { font-weight: 600; color: #334155; }
        input, select {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 1rem;
        }
        .actions {
            display: flex;
            gap: 12px;
            margin-top: 18px;
        }
        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            background: white;
            font-weight: 600;
            cursor: pointer;
        }
        .button.primary {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }
        .error {
            color: #b91c1c;
            font-size: 0.85rem;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>{{ $mode === 'edit' ? 'Edit tenant' : 'Create tenant' }}</h1>

            <form method="POST" action="{{ $mode === 'edit' ? route('platform.tenants.update', $tenant) : route('platform.tenants.store') }}">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="grid">
                    <div class="field full">
                        <label for="name">Name</label>
                        <input id="name" name="name" value="{{ old('name', $tenant?->name ?? '') }}" required>
                        @error('name')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field">
                        <label for="slug">Slug</label>
                        <input id="slug" name="slug" value="{{ old('slug', $tenant?->slug ?? '') }}" required>
                        @error('slug')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            @foreach (['trial', 'active', 'paused', 'suspended'] as $status)
                                <option value="{{ $status }}" {{ old('status', $tenant?->status ?? 'trial') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field full">
                        <label for="owner_email">Owner email</label>
                        <input id="owner_email" name="owner_email" type="email" value="{{ old('owner_email', $tenant?->owner_email ?? '') }}" required>
                        @error('owner_email')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field full">
                        <label for="database_name">Database name</label>
                        <input id="database_name" name="database_name" value="{{ old('database_name', $tenant?->database_name ?? '') }}">
                        @error('database_name')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="button primary">{{ $mode === 'edit' ? 'Update tenant' : 'Create tenant' }}</button>
                    <a href="{{ route('platform.tenants') }}" class="button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
