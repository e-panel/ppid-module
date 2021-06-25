@extends('core::page.plugin')
@section('inner-title', "Edit $title - ")
@section('mUnduhan', 'opened')

@section('content')
    <section class="box-typical">

        {!! Form::model($edit, ['route' => ["$prefix.update", $edit->uuid], 'autocomplete' => 'off', 'method' => 'put']) !!}

            @include('core::layouts.components.top', [
                'judul' => "Edit $title - ",
                'subjudul' => 'Silahkan lakukan perubahan pada data berikut sesuai dengan kebutuhan.',
                'kembali' => route("$prefix.index")
            ])

            @include("$view.form")

            @include('core::layouts.components.submit')
            
        {!! Form::close() !!}

    </section>
@stop