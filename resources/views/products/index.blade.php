<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
    @endpush
    <main>
        <div class="row row-cols-2 d-inline-flex p-4">
            @foreach ($productList as $product)
                <div class="col-sm-3 text-center p-2">
                    <div class="card">
                        <a class="product-wrapper m-2" href="{{ route('products.show', $product) }}">
                            <img class="image" src="{{ asset($product->image) }}" alt="product-image">
                            <div class="product-detail-container">
                                <div>Brand: {{ $product->brand }}</div>
                                <div>Model: {{ $product->model }}</div>
                                <div>Price: ₱{{ $product->price }}</div>
                            </div>
                        </a>

                        <div style="padding-top:40px">
                            <add-product :product="{{ $product }}"></add-product>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="pagination-container">
            {{ $productList->links() }}
        </div>
    </main>
</x-app>
