<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    @endpush
    <main>
        <div class="login-container">
            <h3 style="font-family:'Lobster';font-weight:bold;font-size:34px;padding-top:20px ;padding-bottom:15px">Login</h3>
            <form method="POST" action="{{ route('verify.login') }}">
                @csrf
                <div>
                    <input class="form-control m-1" type="text" placeholder="Username" id="username" name="username">
                    @if ($errors->has('username'))
                        <div class="text-danger">{{ $errors->first('username') }}</div>
                    @endif
                </div>
                <div>
                    <input class="form-control m-1" type="password" placeholder="Password" name="password">
                    @if ($errors->has('password'))
                        <div class="text-danger">{{ $errors->first('password') }}</div>
                    @endif
                    @if (Session::get('password'))
                        <span class="text-danger">{{ Session::get('password') }}</span>
                    @endif
                </div>

                <div>
                    <button class="btn btn-primary m-2" type="submit">Log In</button>
                </div>
            </form>
            {{-- <div class="adminBtn">
                <small id="note">Are you an admin?</small> <br>
                <a href="{{url('admin')}}" class="btn btn-primary" >Admin</a>
            </div> --}}
        </div>
       
    </main>
</x-app>
