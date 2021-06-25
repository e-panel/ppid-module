@extends('core::page.plugin')
@section('inner-title', "$title - ")
@section('mSOP', 'opened')

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
                    { data: 'judul', name: 'judul' },
                    { data: 'bidang', name: 'bidang' },
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
            'icon' => 'font-icon font-icon-doc',
            'judul' => $title,
            'subjudul' => 'Sepertinya Anda belum memiliki ' . $title,
            'tambah' => route("$prefix.create"), 
        ])

    @else

        {!! Form::open(['method' => 'delete', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}
            
            @include('core::layouts.components.top', [
                'judul' => $title,
                'subjudul' => 'List '. $title .' yang tersimpan dalam database.',
                'tambah' => route("$prefix.create"), 
                'hapus' => true
            ])

            <div class="card">
                <div class="card-block table-responsive">
                    <table id="datatable" class="display table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="table-check"></th>
                                <th>JUDUL</th>
                                <th>BIDANG</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        {!! Form::close() !!}

    @endif
@endsection