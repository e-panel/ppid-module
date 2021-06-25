@extends('core::page.plugin')
@section('inner-title', "$kategori->label - ")
@section('mUnduhan', 'opened')

@section('css')
    @include('core::layouts.partials.datatables')
@endsection

@section('js') 
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/datatables-net/datatables.min.js"></script>
    <script>
        $(function() {
            $('#datatable').DataTable({
                order: [[ 3, "desc" ]], 
                processing: true,
                serverSide: true,
                ajax : '{!! request()->fullUrl() !!}?datatable=true', 
                columns: [
                    { data: 'pilihan', name: 'pilihan', className: 'table-check' },
                    { data: 'label', name: 'label' },
                    { data: 'download', name: 'download' },
                    { data: 'created_at', name: 'created_at', className: 'table-date small' },
                    { data: 'oleh', name: 'oleh', className: 'table-photo' },
                    { data: 'aksi', name: 'aksi', className: 'tombol', orderable: false, searchable: false }
                ],
                "fnDrawCallback": function( oSettings ) {
                    @include('core::layouts.components.callback')
                }
            });
        });
        @include('core::layouts.components.hapus')
    </script>
@endsection

@section('content')

    @if(!$data->count())

        @include('core::layouts.components.kosong', [
            'icon' => 'font-icon font-icon-picture-double',
            'judul' => $kategori->label,
            'subjudul' => "Sepertinya Anda belum memiliki Unduhan untuk Kategori $kategori->label.", 
            'kembali' => route("$prefix.index"),
            'tambah' => route("$prefix.file.create", $kategori->uuid)
        ])

    @else

        {!! Form::open(['method' => 'delete', 'route' => ["$prefix.file.destroy", $kategori->uuid, 'hapus-all'], 'id' => 'submit-all']) !!}

            @include('core::layouts.components.top', [
                'judul' => $kategori->label,
                'subjudul' => 'List file yang tersimpan dalam kategori ini.',
                'kembali' => route("$prefix.index"), 
                'tambah' => route("$prefix.file.create", $kategori->uuid), 
                'hapus' => true
            ])

            <div class="card">
                <div class="card-block">
                    <table id="datatable" class="display table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="1"></th>
                                <th>LABEL</th>
                                <th width="15%"></th>
                                <th class="text-right">CREATED</th>
                                <th class="table-photo"></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        {!! Form::close() !!}

    @endif
@endsection