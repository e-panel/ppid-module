@extends('core::page.plugin')
@section('inner-title', __('core::general.create.title', ['attribute' => $title]) . " - ")
@section('mLayanan', 'opened')

@section('css')
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/separate/vendor/select2.min.css">
@endsection

@section('js')
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/select2/select2.full.min.js"></script>
    @include('core::layouts.components.tinymce')
@endsection

@section('content')
    <section class="box-typical">

        {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}

            @include('core::layouts.components.top', [
                'judul' => __('core::general.create.title', ['attribute' => $title]),
                'subjudul' => __('core::general.subtitle.create'),
                'kembali' => route("$prefix.index")
            ])

            <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>
            
        {!! Form::close() !!}

    </section>
@endsection