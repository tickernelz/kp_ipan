@extends('adminlte::page')

@section('title_prefix', 'List Buku')

@section('content_header')
    <h1>List Buku</h1>
@stop

@section('plugins.Datatables', true)

@php
    $heads = [
        '#',
        'Cover',
        'ISBN',
        'Judul Buku',
        'Pengarang',
        'Penerbit',
        'Kategori',
        'Jumlah Buku',
        'Stok',
        'Aksi',
    ];

$config = [
    'order' => [[0, 'asc']],
    'columns' => [null, null, null, null, null, null, null, null, null, ['orderable' => false, 'className' => 'text-center']],
];
@endphp

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Tabel
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <x-adminlte-datatable id="table" :config="$config" :heads="$heads" hoverable bordered beautify>
                @foreach($data as $li)
                    <tr>
                        <td>{!! $loop->iteration !!}</td>
                        <td>
                            @if (isset($li->gambar))
                                <img src="/gambar/{{$li->gambar}}" width="300px" alt="cover">
                            @else
                                Tidak Ada Gambar
                            @endif
                        </td>
                        <td>{!! $li->isbn !!}</td>
                        <td>{!! $li->judul !!}</td>
                        <td>{!! $li->pengarang !!}</td>
                        <td>{!! $li->penerbit !!}</td>
                        @if ($li->kategori_buku !== null)
                            <td>{!! $li->kategori_buku->nama !!}</td>
                        @else
                            <td>Kosong</td>
                        @endif
                        <td>{!! $li->jumlah !!}</td>
                        <td>{!! $li->stok !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a type="button" class="btn btn-secondary"
                                   href="{{ Request::url() }}/edit/{{$li->id}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a type="button" class="btn btn-secondary"
                                   href="{{ Request::url() }}/hapus/{{$li->id}}"
                                   onclick="return confirm('Yakin Mau Dihapus?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
        <!-- /.card-body -->
    </div>
@stop

