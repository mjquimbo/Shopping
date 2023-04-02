<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    @endpush
    <main>

        <h2 id="tableLabel">User accounts</h2>
        <div class="table-responsive">
        <table style="width:90%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="td-password">{{ $user->password }}</td>
                        <td>{{ $user->contact_number }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>

                        <td>
                            <order-history :user="{{ $user }}"></order-history>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <h2 id="tableLabel">Products</h2>
        <div class="table-responsive" style="padding-bottom:20px">
        <table style="width:90%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Description</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Upload an Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->brand }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->model }}</td>
                        <td>${{ $product->price }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->updated_at }}</td>
                        <td>
                            <upload-image :product="{{ $product }}"></upload-image>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    </main>

</x-app>
