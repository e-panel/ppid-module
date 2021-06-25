<div class="box-typical-body padding-panel">
	<div class="row">
		<div class="col-sm-6">
			<h6 class="with-border"><b>Informasi Pengadaan</b></h6>

			<div class="row">
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="no_paket" class="form-label">ID Paket</label>
		                {!! Form::text('no_paket', null, ['class' => 'form-control', 'placeholder' => 'Ex. 15879002']) !!}
		            </fieldset>
				</div>
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="tahun" class="form-label">Tahun Anggaran</label>
		                {!! Form::select('tahun', tahun_anggaran(), isset($edit) ? $edit->tahun : date('Y'), ['class' => 'form-control select2']) !!}
		            </fieldset>
				</div>
			</div>

            <fieldset class="form-group {{ $errors->has('nama_kegiatan')?'form-group-error':'' }}">
                <label for="nama_kegiatan" class="form-label">
                    Nama Kegiatan <span class="text-danger">*</span>
                </label>
                {!! Form::textarea('nama_kegiatan', null, ['class' => 'form-control', 'placeholder' => 'Ex. Belanja makanan dan minuman', 'rows' => 2]) !!}
                {!! $errors->first('nama_kegiatan', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>

            <fieldset class="form-group {{ $errors->has('nama_paket')?'form-group-error':'' }}">
                <label for="nama_paket" class="form-label">
                    Nama Paket <span class="text-danger">*</span>
                </label>
                {!! Form::textarea('nama_paket', null, ['class' => 'form-control', 'placeholder' => 'Ex. Belanja makanan dan minuman', 'rows' => 2]) !!}
                {!! $errors->first('nama_paket', '<span class="text-muted"><small>:message</small></span>') !!}
            </fieldset>

            <div class="row">
				<div class="col-md-4">
					<fieldset class="form-group">
		                <label for="jenis_pengadaan" class="form-label">Jenis Pengadaan</label>
		                {!! Form::select('jenis_pengadaan', jenis_pengadaan(), null, ['class' => 'form-control select2']) !!}
		            </fieldset>
				</div>
				<div class="col-md-4">
					<fieldset class="form-group {{ $errors->has('volume')?'form-group-error':'' }}">
		                <label for="volume" class="form-label">Volume</label>
		                {!! Form::text('volume', null, ['class' => 'form-control', 'placeholder' => 'Ex. 1 Paket']) !!}
                    	{!! $errors->first('volume', '<span class="text-muted"><small>:message</small></span>') !!}
		            </fieldset>
				</div>
				<div class="col-md-4">
					<fieldset class="form-group">
		                <label for="lokasi" class="form-label">Lokasi</label>
		                {!! Form::text('lokasi', null, ['class' => 'form-control', 'placeholder' => 'Ex. Samarinda']) !!}
		            </fieldset>
				</div>
			</div>

			<fieldset class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                {!! Form::textarea('deskripsi', null, ['class' => 'form-control', 'rows' => 4]) !!}
            </fieldset>
		</div>
		<div class="col-sm-6">
			<h6 class="with-border"><b>Sumber Dana</b></h6>

			<div class="row">
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="sumber_dana" class="form-label">Sumber Dana</label>
		                {!! Form::text('sumber_dana', null, ['class' => 'form-control', 'placeholder' => 'Ex. APBN']) !!}
		            </fieldset>
				</div>
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="pagu" class="form-label">Pagu (Rupiah)</label>
		                {!! Form::text('pagu', null, ['class' => 'form-control money']) !!}
		            </fieldset>
				</div>
			</div>
			<fieldset class="form-group">
                <label for="sumber_dana_mak" class="form-label">MAK</label>
                {!! Form::text('sumber_dana_mak', null, ['class' => 'form-control']) !!}
            </fieldset>


			<br/>
			<h6 class="with-border"><b>Ketentuan Pekerjaan</b></h6>
			<fieldset class="form-group">
                <label for="penyedia" class="form-label">Pemilihan Penyedia</label>
                {!! Form::text('penyedia', null, ['class' => 'form-control', 'placeholder' => 'Ex. Pemilihan Langsung']) !!}
            </fieldset>
            <div class="row">
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="penyedia_awal" class="form-label">Waktu Penyedia (Mulai)</label>
		                {!! Form::text('penyedia_awal', null, ['class' => 'form-control month']) !!}
		            </fieldset>
				</div>
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="penyedia_akhir" class="form-label">Waktu Penyedia (Berakhir)</label>
		                {!! Form::text('penyedia_akhir', null, ['class' => 'form-control month']) !!}
		            </fieldset>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="pelaksanaan_awal" class="form-label">Waktu Pengerjaan (Mulai)</label>
		                {!! Form::text('pelaksanaan_awal', null, ['class' => 'form-control month']) !!}
		            </fieldset>
				</div>
				<div class="col-md-6">
					<fieldset class="form-group">
		                <label for="pelaksanaan_akhir" class="form-label">Waktu Pengerjaan (Berakhir)</label>
		                {!! Form::text('pelaksanaan_akhir', null, ['class' => 'form-control month']) !!}
		            </fieldset>
				</div>
			</div>
		</div>
	</div>
</div>
