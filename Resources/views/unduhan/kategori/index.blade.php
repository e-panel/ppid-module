@extends('core::page.plugin')
@section('inner-title', "$title - ")
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
                    { data: 'total', name: 'total' },
                    { data: 'created_at', name: 'created_at', className: 'table-date small' },
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
            'icon' => 'font-icon font-icon-folder',
            'judul' => $title,
            'subjudul' => 'Sepertinya Anda belum memiliki Tautan.',
            'tambah' => route("$prefix.create"), 
        ])

    @else

        {!! Form::open(['method' => 'delete', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}
            
            @include('core::layouts.components.top', [
                'judul' => $title,
                'subjudul' => 'List Tautan yang tersimpan dalam database.',
                'tambah' => route("$prefix.create"), 
                'hapus' => true
            ])

            <div class="card">
                <div class="card-block table-responsive">
                    <table id="datatable" class="display table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="table-check"></th>
                                <th>LABEL</th>
                                <th>TOTAL</th>
                                <th class="text-right">CREATED</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        {!! Form::close() !!}

    @endif
@endsection