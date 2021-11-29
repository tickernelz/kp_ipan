@extends('adminlte::page')

@section('title', 'List Booking')

@section('content_header')
    <h1>List Booking</h1>
@stop

@section('plugins.Datatables', true)

@php
    $heads = [
        '#',
        'Nama Anggota',
        'ISBN',
        'Judul Buku',
        'Nomor Rak',
        'Kategori',
        'Status',
        'Aksi',
    ];

$config = [
    'order' => [[0, 'asc']],
    'columns' => [null, null, null, null, null, null, null, ['orderable' => false, 'className' => 'text-center']],
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
                        <td>{!! $li->anggota->nama !!}</td>
                        <td>{!! $li->buku->isbn ?? '' !!}</td>
                        <td>{!! $li->buku->judul ?? '' !!}</td>
                        <td>{!! $li->buku->kategori_buku->rak->nomor ?? '' !!}</td>
                        <td>{!! $li->buku->kategori_buku->nama ?? ''  !!}</td>
                        <td>{!! $li->status ?? '' !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a type="button" class="btn btn-success"
                                   href="{{ Request::url() }}/terima/{{$li->id}}"
                                   onclick="return confirm('Yakin Mau Diterima?');">
                                   Terima
                                </a>
                                <a type="button" class="btn btn-danger"
                                   href="{{ Request::url() }}/tolak/{{$li->id}}"
                                   onclick="return confirm('Yakin Mau Ditolak?');">
                                    Tolak
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

