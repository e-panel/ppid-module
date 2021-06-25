<div class="box-typical-body padding-panel">
	<div class="row">
		<div class="col-sm-5">
            <fieldset class="form-group {{ $errors->has('judul')?'form-group-error':'' }}">
                <label for="judul" class="form-label">
                    Judul SOP <span class="text-danger">*</span>
                </label>
                {!! Form::text('judul', null, ['class' => 'form-control']) !!}
                {!! $errors->first('judul', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>
            <fieldset class="form-group {{ $errors->has('id_bidang')?'form-group-error':'' }}">
                <label for="id_bidang" class="form-label">
                    Pilih Bidang <span class="text-danger">*</span>
                </label>
                {!! Form::select('id_bidang', Modules\Pegawai\Entities\Satker::pluck('label', 'id'), null, ['class' => 'form-control select2']) !!}
                {!! $errors->first('id_bidang', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>
		</div>
		<div class="col-sm-6">
			
			<fieldset class="form-group {{ $errors->first('file', 'form-group-error') }}">
				<label for="file" class="form-label">
					Pilih File (Gambar)
					<span class="color-red">*</span>
				</label>
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
						@if(!isset($edit))
							<img data-src="holder.js/1024x768/auto" alt="...">
						@else
							<img src="{{ viewImg($edit->file) }}" alt="{{ $edit->judul }}">
						@endif
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
					<div>
						<span class="btn btn-default btn-file">
							<span class="fileinput-new">Pilih</span>
							<span class="fileinput-exists">Change</span>
							{!! Form::file('file', ['class' => 'form-control', 'accept' => 'image/*']) !!}
						</span>
						<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
					</div>
					{!! $errors->first('file', '<span class="text-muted"><small>:message</small></span>') !!}
					<span class="text-muted"><small>*Ukuran resolusi Bebas. Namun usahakan size file yang diupload berukuran kecil dibawah 500kb agar tidak memberatkan proses loading dari pengunjung.</small></span>
				</div>
			</fieldset>

		</div>
	</div>
</div>
