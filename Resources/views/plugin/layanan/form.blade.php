<div class="box-typical-body padding-panel">
    <div class="row">
        <div class="col-sm-6">
            <h6 class="with-border"><b>Informasi Layanan</b></h6>

            <fieldset class="form-group {{ $errors->has('nama')?'form-group-error':'' }}">
                <label for="nama" class="form-label">
                    Nama Layanan <span class="text-danger">*</span>
                </label>
                {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                {!! $errors->first('nama', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>

            <div class="row">
                <div class="col-md-6">
                    <fieldset class="form-group {{ $errors->has('pd')?'form-group-error':'' }}">
                        <label for="pd" class="form-label">
                            Satuan Kerja <span class="text-danger">*</span>
                        </label>
                        {!! Form::text('pd', null, ['class' => 'form-control', 'placeholder' => 'Ex. ' . env('EP_INSTANSI')]) !!}
                        {!! $errors->first('pd', '<span class="text-muted"><small>:message</small></span>') !!}
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset class="form-group {{ $errors->has('bidang')?'form-group-error':'' }}">
                        <label for="tahun" class="form-label">
                            Bidang Teknis <span class="text-danger">*</span>
                        </label>
                        {!! Form::select('bidang', Modules\Pegawai\Entities\Satker::pluck('label', 'id'), null, ['class' => 'form-control select2']) !!}
                        {!! $errors->first('bidang', '<span class="text-muted"><small>:message</small></span>') !!}
                    </fieldset>
                </div>
            </div>

            <fieldset class="form-group {{ $errors->has('alamat')?'form-group-error':'' }}">
                <label for="alamat" class="form-label">
                    Alamat OPD <span class="text-danger">*</span>
                </label>
                {!! Form::textarea('alamat', null, ['class' => 'form-control', 'rows' => 3]) !!}
                {!! $errors->first('alamat', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>
        </div>
        <div class="col-sm-4">
            <h6 class="with-border"><b>Narahubung</b></h6>

            <fieldset class="form-group {{ $errors->has('narahubung_nama')?'form-group-error':'' }}">
                <label for="narahubung_nama" class="form-label">
                    Nama <span class="text-danger">*</span>
                </label>
                {!! Form::text('narahubung_nama', null, ['class' => 'form-control']) !!}
                {!! $errors->first('narahubung_nama', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>
            <fieldset class="form-group {{ $errors->has('narahubung_jabatan')?'form-group-error':'' }}">
                <label for="narahubung_jabatan" class="form-label">
                    Jabatan <span class="text-danger">*</span>
                </label>
                {!! Form::text('narahubung_jabatan', null, ['class' => 'form-control']) !!}
                {!! $errors->first('narahubung_jabatan', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>
            <fieldset class="form-group {{ $errors->has('narahubung_telepon')?'form-group-error':'' }}">
                <label for="narahubung_telepon" class="form-label">
                    Telepon <span class="text-danger">*</span>
                </label>
                {!! Form::text('narahubung_telepon', null, ['class' => 'form-control']) !!}
                {!! $errors->first('narahubung_telepon', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>
        </div>
    </div>

    <br/>
    <div class="row">
        <div class="col-sm-10">
            <h6><b>Keterangan Tambahan</b></h6>
            <div class="form-group">
                {!! Form::textarea('keterangan', null, ['class' => 'form-control tinymce']) !!}
            </div>
        </div>
    </div>
</div>