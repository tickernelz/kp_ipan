@extends('adminlte::page')

@section('title', 'Edit Anggota')

@section('content_header')
    <h1>Edit Anggota ({{ $data->nama }})</h1>
@stop

@section('plugins.Select2', true)

@section('content')
    <div class="col-md-6" style="float:none;margin:auto;">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Form Edit</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ redirect()->getUrlGenerator()->route('index.user.anggota') }}">
                            <button type="button" class="btn btn-primary">Kembali</button>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url()->current()}}/post" method="post">
                <div class="card-body">
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
                    <x-adminlte-input value="{{ $data->nik }}" name="nik" label="NIK*" type="number" placeholder="Masukkan NIK..."/>
                    <x-adminlte-input value="{{ $data->user->username }}" name="username" label="Username"
                                      placeholder="Masukkan Username..."/>
                    <x-adminlte-input value="{{ $data->nama }}" name="nama" label="Nama"
                                      placeholder="Masukkan Nama..."/>
                    <x-adminlte-input value="{{ $data->email }}" type="email" name="email" label="Email"
                                      placeholder="Masukkan Email..."/>
                    <x-adminlte-input value="{{ $data->hp }}" type="number" name="hp" label="No. HP" placeholder="Masukkan No HP..."/>
                    <x-adminlte-input type="password" value="{{ $data->user->password }}" name="password" label="Password"
                                      placeholder="Masukkan Password..."/>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('css')
@endpush

@push('js')
@endpush
