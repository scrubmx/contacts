<nav id="navbar" class="bg-blue-500">
    <div class="flex items-center justify-between h-16 px-6">
        <a href="/" class="outline-none">
            <img src="/images/logo-white.png" class="h-8" alt="{{ config('app.name') }}">
        </a>
        <div>
            @auth
                <form action="/logout" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="text-md font-light text-white font-semibold">Logout</button>
                </form>
            @else
                <a href="/login" class="text-md font-light text-white font-semibold">Login</a>
            @endauth
        </div>
    </div>
</nav>
