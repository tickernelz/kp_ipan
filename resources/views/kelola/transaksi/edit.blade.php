@extends('adminlte::page')

@section('title', 'Edit Transaksi')

@section('content_header')
    <h1>Edit Transaksi</h1>
@stop

@section('plugins.Select2', true)
@section('plugins.TempusDominus', true)

@section('content')
    <div class="col-md-6" style="float:none;margin:auto;">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Form Edit</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a href="{{ redirect()->getUrlGenerator()->route('index.transaksi') }}">
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
                    <x-adminlte-select2 name="anggota" label="Anggota*" data-placeholder="Pilih Anggota...">
                        <option></option>
                        @foreach($anggota as $list)
                            <option @if ($data->anggota_id == $list->id)
                                    selected="selected"
                                    @endif value="{{$list->id }}">{{ $list->nama }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-input value="{{ $data->isbn }}" name="isbn" id="isbn" type="number" label="ISBN*"
                                      placeholder="Masukkan ISBN..."/>
                    <x-adminlte-input value="{{ $data->buku }}" name="buku" id="buku" label="Buku*"
                                      placeholder="Masukkan Buku..."/>
                    <x-adminlte-input-date value="{{ $tanggal_pinjam }}" name="tanggal_pinjam" :config="$conf_tgl"
                                           placeholder="Masukkan Tanggal Pinjam..."
                                           label="Tanggal Pinjam*">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-input-date value="{{ $tanggal_kembali }}" name="tanggal_kembali" :config="$conf_tgl"
                                           placeholder="Masukkan Tanggal Kembali..."
                                           label="Tanggal Kembali*">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="status" label="Status*" data-placeholder="Pilih Status...">
                        <option></option>
                        <option @if ($data->status == 'Pinjam')
                                selected="selected"
                                @endif value="Pinjam">Pinjam
                        </option>
                        <option @if ($data->status == 'Kembali')
                                selected="selected"
                                @endif value="Kembali">Kembali
                        </option>
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
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        const route_buku = "{{ url('auto-buku') }}";
        const route_isbn = "{{ url('auto-isbn') }}";

        $('#buku').typeahead({
            source: function (query, process) {
                return $.get(route_buku, {
                    buku: buku,
                    classNames: {
                        input: 'Typeahead-input',
                        hint: 'Typeahead-hint',
                        selectable: 'Typeahead-selectable'
                    }
                }, function (d) {
                    console.log(d)
                    return process(d);
                });
            }
        });

        $('#isbn').typeahead({
            source: function (query, process) {
                return $.get(route_isbn, {
                    isbn: isbn,
                    classNames: {
                        input: 'Typeahead-input',
                        hint: 'Typeahead-hint',
                        selectable: 'Typeahead-selectable'
                    }
                }, function (d) {
                    console.log(d)
                    return process(d);
                });
            }
        });
    </script>
@endpush
