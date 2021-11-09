@extends('adminlte::page')

@section('title', 'List Transaksi')

@section('content_header')
    <h1>List Transaksi</h1>
@stop

@section('plugins.Datatables', true)

@php
    $heads = [
        '#',
        'Nama Peminjam (NIK)',
        'ISBN',
        'Judul Buku',
        'Tanggal Pinjam',
        'Tanggal Kembali',
        'Status',
        'Terlambat',
        'Aksi',
    ];

$config = [
    'order' => [[0, 'asc']],
    'columns' => [null, null, null, null, null, null, null, ['orderable' => false], ['orderable' => false, 'className' => 'text-center']],
];
@endphp

@php
    function terlambat($tanggal)
    {
        if (\Carbon\Carbon::now() > $tanggal)
            {
                $tanggal = new \Carbon\Carbon($tanggal);
                $now = \Carbon\Carbon::now();
                $difference = $tanggal->diffInDays($now);
                return ''.($difference+1).' Hari';
            } else {
                return '0 Hari';
            }
    }

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
                        <td>{!! $li->anggota->nama !!} ({!! $li->anggota->nik !!})</td>
                        <td>{!! $li->isbn !!}</td>
                        <td>{!! $li->buku !!}</td>
                        <td>{!! \Carbon\Carbon::parse($li->tanggal_pinjam)->formatLocalized('%d %B %Y') !!}</td>
                        <td>{!! \Carbon\Carbon::parse($li->tanggal_kembali)->formatLocalized('%d %B %Y') !!}</td>
                        <td>{!! $li->status !!}</td>
                        <td>{!! terlambat($li->tanggal_kembali) !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a type="button" class="btn btn-secondary"
                                   href="{{ Request::url() }}/edit/{{$li->id}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a type="button" class="btn btn-secondary"
                                   href="{{ Request::url() }}/kembali/{{$li->id}}"
                                   onclick="return confirm('Yakin Mau Dikembalikan?');">
                                    Kembalikan
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

