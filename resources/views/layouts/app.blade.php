<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Folioform') · portfolio studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/portfolio.css">
    <link rel="stylesheet" href="/css/refinements.css?v={{ filemtime(public_path('css/refinements.css')) }}">
    @stack('head')
</head>
<body class="@yield('body-class')">
    <header class="site-header">
        <a class="wordmark" href="{{ route('home') }}" aria-label="Folioform home"><span class="wordmark-mark">f.</span>folioform</a>
        <nav class="site-nav" aria-label="Main navigation">
            @auth
                <a href="{{ route('portfolios.index') }}" @if (request()->routeIs('portfolios.index')) class="is-active" aria-current="page" @endif>My portfolios</a>
                <span class="nav-user">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="post">@csrf<button class="nav-link-button" type="submit">Sign out</button></form>
            @else
                <a href="{{ route('login') }}">Log in</a>
                <a class="button button-dark button-small" href="{{ route('register') }}">Get started <span aria-hidden="true">↗</span></a>
            @endauth
        </nav>
    </header>

    @if (session('status'))
        <div class="flash-message" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="flash-message flash-error" role="alert">Please check the highlighted fields and try again.</div>
    @endif

    <main>@yield('content')</main>
    <footer class="site-footer"><a class="wordmark" href="{{ route('home') }}"><span class="wordmark-mark">f.</span>folioform</a><span>Made for the next thing you do.</span><span>© {{ date('Y') }} Folioform</span></footer>
    @stack('scripts')
    <script>
        document.querySelectorAll('.flash-message').forEach((message) => {
            window.setTimeout(() => message.remove(), 5000);
        });

        const deletionDialog = document.querySelector('#delete-portfolio-dialog');
        let pendingDeleteForm;

        if (deletionDialog) {
            document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (form.dataset.confirmed === 'true') {
                        delete form.dataset.confirmed;
                        return;
                    }

                    event.preventDefault();
                    pendingDeleteForm = form;
                    deletionDialog.showModal();
                });
            });

            deletionDialog.addEventListener('close', () => {
                if (deletionDialog.returnValue === 'confirm' && pendingDeleteForm) {
                    pendingDeleteForm.dataset.confirmed = 'true';
                    pendingDeleteForm.requestSubmit();
                }

                pendingDeleteForm = null;
            });
        }
    </script>
</body>
</html>