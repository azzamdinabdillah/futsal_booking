<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        @php
            $configs = \App\Models\SystemConfig::getAllAsArray();
        @endphp
        <style>
            :root {
                --color-primary: {{ $configs['color_primary'] ?? '#0F172A' }};
                --color-secondary: {{ $configs['color_secondary'] ?? '#64748B' }};
                --color-success: {{ $configs['color_success'] ?? '#22C55E' }};
                --color-danger: {{ $configs['color_danger'] ?? '#EF4444' }};
                --color-warning: {{ $configs['color_warning'] ?? '#F59E0B' }};
                --color-info: {{ $configs['color_info'] ?? '#3B82F6' }};
                --color-light: {{ $configs['color_light'] ?? '#F8FAFC' }};
                --color-dark: {{ $configs['color_dark'] ?? '#020617' }};
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.ts'])
        @inertiaHead
    </head>
    <body class="antialiased">
        @inertia
    </body>
    </html>
