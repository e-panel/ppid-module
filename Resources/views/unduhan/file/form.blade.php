<div class="box-typical-body padding-panel">

	<fieldset class="form-group">
		<label for="id_kategori" class="form-label">Kategori</label>
		{!! Form::select('id_kategori', Modules\PPID\Entities\Unduhan\Kategori::pluck('label', 'id'), $kategori->id, ['class' => 'select2 select2-no-search-arrow', 'disabled']) !!}
	</fieldset>

	<fieldset class="form-group {{ $errors->first('judul', 'form-group-error') }}">
		<label for="judul" class="form-label">Judul <span class="color-red">*</span></label>
		<div class="form-control-wrapper">
			{!! Form::text('judul', null, ['class' => 'form-control', 'autofocus']) !!}
			{!! $errors->first('judul', '<span class="text-muted"><small>:message</small></span>') !!}
		</div>
	</fieldset>

	@if(!isset($edit))
		<fieldset class="form-group {{ $errors->first('file', 'form-group-error') }}">
			<label for="file" class="form-label">Pilih File <span class="color-red">*</span></label>
			{!! Form::file('file', ['class' => 'form-control']) !!}
			{!! $errors->first('file', '<span class="text-muted"><small>:message</small></span>') !!}
		</fieldset>
		<div class="alert alert-success">
            <small>
            	Hanya menerima file dengan format <b>pdf, doc, docx, xls, xlsx, ppt, pptx, zip</b> dan <b>rar</b>.
            </small>
        </div>
    @else 
    	<iframe src="{{ asset($edit->file) }}" frameborder="0" style="width: 100%;height: 300px;"></iframe>
	@endif
</div>