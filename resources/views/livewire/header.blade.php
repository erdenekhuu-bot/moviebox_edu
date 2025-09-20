<section class="flex justify-between items-center w-full border border-[#1A1919] bg-fixed">
    <flux:navbar wrapper-class="justify-between">
        <flux:navbar.item href="#">
            <img src="{{ asset('banner.png') }}" alt="" />
        </flux:navbar.item>
        <div class="flex gap-6">
            <flux:navbar.item href="#">Dashboard</flux:navbar.item>
            <flux:navbar.item href="#">Pricing</flux:navbar.item>
            <flux:navbar.item href="#">Movies</flux:navbar.item>
            <flux:navbar.item href="#">Series</flux:navbar.item>
            <flux:navbar.item href="#">Collection</flux:navbar.item>
            <flux:navbar.item href="#">FAQ</flux:navbar.item>
        </div>
    </flux:navbar>
     <div class="flex gap-4">
        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard</a>
        @else
                <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register</a>
            @endif
            @endauth
            </nav>
        @endif
    </div>

</section>




