@extends('adminlte::page')

@section('title', 'List Admin')

@section('content_header')
    <h1>List Admin</h1>
@stop

@section('plugins.Datatables', true)

@php
    $heads = [
        '#',
        'NIP',
        'Nama',
        'Username',
        'No. HP',
        'Peran',
        'Aksi',
    ];

$config = [
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, null, null, ['orderable' => false, 'className' => 'text-center']],
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
                        <td>{!! $li->nip !!}</td>
                        <td>{!! $li->nama !!}</td>
                        <td>{!! $li->user->username !!}</td>
                        <td>{!! $li->hp !!}</td>
                        <td>{!! $li->user->roles->first()->name !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a type="button" class="btn btn-secondary"
                                   href="{{ Request::url() }}/edit/{{$li->id}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a type="button" class="btn btn-secondary"
                                   href="{{ Request::url() }}/hapus/{{$li->user->id}}"
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

