@extends('core::page.plugin')
@section('inner-title', "Tambah $title - ")
@section('mUnduhan', 'opened')

@section('content')
    <section class="box-typical">

        {!! Form::open(['route' => "$prefix.store", 'autocomplete' => 'off']) !!}

            @include('core::layouts.components.top', [
                'judul' => "Tambah $title",
                'subjudul' => 'Silahkan lengkapi form berikut untuk menambahkan data baru.',
                'kembali' => route("$prefix.index")
            ])

            @include("$view.form")

            @include('core::layouts.components.submit')
            
        {!! Form::close() !!}

    </section>
@stop