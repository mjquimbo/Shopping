<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/products/show.css') }}">
    @endpush
    <main>
        <div class="container p-3">
            <div class="row align-items-center">
                <div class="col card text-center">
                    <div>BRAND: {{ $product->brand }} </div>
                    <div>MODEL: {{ $product->model }}</div>
                    <div>PRICE: ${{ $product->price }} </div>
                    <img class="image" src="{{ asset($product->image) }}" alt="product-image">
                    <div>
                        DESCRIPTION:
                        <p> {{ $product->description }} </p>
                    </div>
                </div>

            </div>
            <div class="button-container">
     
                <add-product :product="{{ $product }}"></add-product>
                <div>
                    <a class="btn btn-secondary m-2"href="{{ URL::previous() }}">Back</a>
                </div>
            </div>
        </div>
    </main>
</x-app>
