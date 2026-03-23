<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased bg-mauve-100">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover" />

    <title>
        {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
    </title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-serif:400" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

</head>

<body>
    <header id="navbar" class="sticky top-0 z-10 bg-mauve-100">
        <nav>
            <div class="mx-auto flex h-21 max-w-7xl items-center gap-4 px-6 lg:px-10">
                <div class="flex items-center">
                    <a class="inline-flex items-stretch" href="/">
                        <span class="font-display text-[1.75rem]/none">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        {{ $slot }}
    </main>
    <footer id="footer" class="pt-16">
        <div class="bg-mauve-950/2.5 py-16 text-mauve-950">
            <div class="mx-auto w-full max-w-2xl px-6 md:max-w-3xl lg:max-w-7xl lg:px-10 flex flex-col gap-16">
                <div class="flex items-center justify-between gap-10 text-sm/7">
                    <div class="text-mauve-600">© {{ date('Y') }} {{ config('app.name', 'Laravel') }}</div>
                </div>
            </div>
        </div>
    </footer>
    @fluxScripts
</body>
</html>
