<div class="box-typical-body padding-panel">
    <fieldset class="form-group {{ $errors->first('label', 'form-group-error') }}">
        <label for="label" class="form-label"><b>Label <span class="color-red">*</span></b></label>
        <div class="form-control-wrapper">
            {!! Form::text('label', null, ['class' => 'form-control', 'autofocus']) !!}
            {!! $errors->first('label', '<span class="text-muted"><small>:message</small></span>') !!}
        </div>
    </fieldset>
    <br/>
    <fieldset class="form-group {{ $errors->has('segmen')?'form-group-error':'' }}">
        <label for="segmen" class="form-label"><b>Segmen Menu</b></label>
        <div class="form-control-wrapper row">
            <div class="col-md-3">
                <div class="checkbox-bird">
                    @if(isset($edit))
                        {!! Form::radio('segmen', 1, $edit->segmen == 1 ? true : false, ['id' => 'list-induk']) !!}
                    @else
                        {!! Form::radio('segmen', 1, false, ['id' => 'list-induk']) !!}
                    @endif
                    <label for="list-induk">List Induk (PPID Pembantu)</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox-bird">
                    @if(isset($edit))
                        {!! Form::radio('segmen', 2, $edit->segmen == 2 ? true : false, ['id' => 'info-teknis']) !!}
                    @else
                        {!! Form::radio('segmen', 2, false, ['id' => 'info-teknis']) !!}
                    @endif
                    <label for="info-teknis">Audit Laporan Keuangan</label>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="alert alert-success" style="line-height: 15px;"><small>
        <p>Segmen Menu yang dimaksud adalah lokasi munculnya menu pada <i>dropdown</i> PPID Pembantu, berikut penjelasannya:</p>
        <ol style="margin-left: 15px">
            <li>
                <b>List Induk (PPID Pembantu)</b><br/>
                <p>Segmen ini akan memunculkan menu pada list / daftar utama <b>PPID Pembantu</b>.</p>
            </li>
            <li>
                <b>Audit Laporan Keuangan</b>
                <p>Segmen ini akan memunculkan menu pada list / daftar <b>PPID Pembantu > Audit Laporan Keuangan</b>.</p>
            </li>
        </ol>
    </small></div>
</div>