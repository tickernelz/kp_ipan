@extends('adminlte::page')

@section('title', 'Edit Buku')

@section('content_header')
    <h1>Edit Buku ({{ $data->judul }})</h1>
@stop

@section('plugins.Select2', true)

@section('content')
    <div class="col-md-6" style="float:none;margin:auto;">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Form Edit</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ redirect()->getUrlGenerator()->route('index.buku') }}">
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
                    <x-adminlte-input value="{{ $data->isbn }}" name="isbn" label="ISBN*" placeholder="Masukkan ISBN..."/>
                    <x-adminlte-input value="{{ $data->judul }}" name="judul" label="Judul Buku*" placeholder="Masukkan Kategori..."/>
                    <x-adminlte-input value="{{ $data->pengarang }}" name="pengarang" label="Pengarang" placeholder="Masukkan Pengarang..."/>
                    <x-adminlte-input value="{{ $data->penerbit }}" name="penerbit" label="Penerbit" placeholder="Masukkan Penerbit..."/>
                    <x-adminlte-select2 name="kategori" label="Kategori" data-placeholder="Pilih Kategori...">
                        <option></option>
                        @foreach($kategori as $list)
                            <option @if ($data->kategori_buku_id == $list->id)
                                    selected="selected"
                                    @endif value="{{$list->id }}">{{ $list->nama }}</option>
                        @endforeach
                    </x-adminlte-select2>
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
