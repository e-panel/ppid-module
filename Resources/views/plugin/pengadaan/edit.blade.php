@extends('core::page.plugin')
@section('inner-title', __('core::general.edit.title', ['attribute' => $title]) . " - ")
@section('mPengadaan', 'opened')

@section('css')
    <link rel="stylesheet" href="https://cdn.enterwind.com/template/epanel/css/separate/vendor/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
@endsection

@section('js')
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/select2/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdn.enterwind.com/template/epanel/js/lib/moment/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.money').mask('000.000.000.000.000', {reverse: true});
            $('.month').datepicker({
                startView: "months", 
                minViewMode: "months", 
                format: 'mm-yyyy'
            });
        });
    </script>
@endsection

@section('content')
	<section class="box-typical">

        {!! Form::model($edit, ['route' => ["$prefix.update", $edit->uuid], 'autocomplete' => 'off', 'files' => true, 'method' => 'put']) !!}

            @include('core::layouts.components.top', [
                'judul' => __('core::general.edit.title', ['attribute' => $title]),
                'subjudul' => __('core::general.subtitle.edit'),
                'kembali' => route("$prefix.index")
            ])

            <div class="card">
                @include("$view.form")
                @include('core::layouts.components.submit')
            </div>
            
        {!! Form::close() !!}

    </section>
@endsection