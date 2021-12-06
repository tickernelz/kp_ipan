@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('title_prefix', 'Daftar Anggota')

<body class="img js-fullheight"
      style="background-image: url(https://unsplash.com/photos/k2Kcwkandwg/download?ixid=MnwxMjA3fDB8MXxhbGx8fHx8fHx8fHwxNjM2NDc5ODg2&force=true&w=2400);">
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Daftar Anggota Perpustakaan</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <h3 class="mb-4 text-center">Daftar</h3>
                    <form action="{{ route('auth.daftar.post') }}" method="post">
                        @csrf
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <input type="text" name="nik"
                                   class="form-control {{ $errors->has('nik') ? 'is-invalid' : '' }}"
                                   placeholder="NIK*" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="nama"
                                   class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                                   placeholder="Nama*" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="username"
                                   class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                   placeholder="Username*" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email"
                                   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="number" name="hp"
                                   class="form-control {{ $errors->has('hp') ? 'is-invalid' : '' }}"
                                   placeholder="No. HP">
                        </div>
                        <div class="form-group">
                            <input id="password-field" name="password" type="password"
                                   class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   placeholder="Password"
                                   required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Daftar</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50 text-md-right">
                                <a href="{{ route('auth.index') }}" style="color: #fff">Sudah Daftar Anggota?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

@section('adminlte_css')
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('dist/login/css/style.css') }}">
@endsection

@section('adminlte_js')
    <script src="{{ asset('dist/login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/login/js/popper.js') }}"></script>
    <script src="{{ asset('dist/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/login/js/main.js') }}"></script>
@endsection
