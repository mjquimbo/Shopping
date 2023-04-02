<nav>
    <div class="container p-3">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-6">
                <a href="{{ route('products.index') }}">
                    <img class="logo rounded" src="{{ asset('images/1.png') }}" alt="brand-logo">
                </a>
                <div>
                <span class="logo-text">Cheapest Cosmetic Rebranding Shop</span>
</div>
            </div>

            <div class="col-sm-12 col-md-2">
                
                <a class="shopping-cart-container" href="{{ route('carts.index') }}">
                    
                    @if (!auth()->check() or auth()->user()->role === 'user')
                        <shopping-cart></shopping-cart>
                    @endif
                </a>
               
            </div>
            
            <div class="col-sm-12 col-md-4 text-center">
            @if (auth()->check())
                            <div  style="font-size:20px; font-weight:bold"> {{ auth()->user()->name }}</div>
                        @endif
                @if (auth()->check())
                    <a class="btn btn-outline-primary" href="{{ route('signout') }}">
                        <sign-out></sign-out>
                    </a>
                @else
                    <a class="btn btn-outline-primary m-1" href="{{ route('login') }}">Log In</a>
                    <a class="btn btn-outline-success" href="{{ route('signup') }}">Sign Up</a>
                @endif
            </div>
        </div>
    </div>
</nav>
