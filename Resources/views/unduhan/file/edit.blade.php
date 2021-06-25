@extends('core::page.plugin')
@section('inner-title', "Edit $title - ")
@section('mUnduhan', 'opened')

@section('js')
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/select2/select2.full.min.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/separate/vendor/select2.min.css">
@endsection

@section('content')
    <section class="box-typical">
    	
        {!! Form::model($edit, ['route' => ["$prefix.file.update", $kategori->uuid, $edit->uuid], 'autocomplete' => 'off', 'files' => true, 'method' => 'put']) !!}
            
            @include('core::layouts.components.top', [
                'judul' => 'Ubah File',
                'subjudul' => "Kategori: <b>$kategori->label</b>",
                'kembali' => route("$prefix.file.index", $kategori->uuid)
            ])

            @include("$view.form")
            @include('core::layouts.components.submit')
        
        {!! Form::close() !!}

    </section>
@stop