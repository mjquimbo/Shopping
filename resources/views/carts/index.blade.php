<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/carts/index.css') }}">
    @endpush
    <main>
        @if (auth()->check())
            <div class="ps-2">{{ auth()->user()->name }}</div>
        @else
            <div class="ps-2 fw-bold">GUEST</div>
        @endif
        <cart-content></cart-content>
        <div class="check-out-button">
            <form action="{{ route('payments.checkout') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <button class="btn btn-success me-4" type="submit">CHECKOUT</button>
            </form>
        </div>
    </main>
</x-app>
