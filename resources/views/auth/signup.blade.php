<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/auth/signup.css') }}">
    @endpush
    <main class="container">
        <div class="row justify-content-center" >
            <div class="col-lg-5 col-md-8 col-sm-10">
                <div  style="margin-top:20px;margin-bottom:20px">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4" style="font-family:'Lobster';font-weight:bold;font-size:34px" >Sign Up</h3>
                        <form action="{{ route('verify.signup') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                               
                                <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Enter your name" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                               
                                <input id="username" class="form-control @error('username') is-invalid @enderror" type="text" placeholder="Enter your username" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                             
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Enter your email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                               
                                <input id="contact_number" class="form-control @error('contact_number') is-invalid @enderror" type="text" placeholder="Enter your contact number" name="contact_number" value="{{ old('contact_number') }}" required>
                                @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter your address" name="address" rows="4" required>{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                
                                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Enter your password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                               
                                <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" placeholder="Confirm your password" name="password_confirmation" required>
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-success">Sign Up</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app>