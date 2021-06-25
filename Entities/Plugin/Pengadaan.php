<?php

namespace Modules\PPID\Entities\Plugin;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plugin_pengadaan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'no_paket', 
        'tahun', 
        'nama_kegiatan', 
        'nama_paket', 
        'pagu', 
        'jenis_belanja', 
        'jenis_pengadaan', 
        'volume', 
        'lokasi', 
        'deskripsi', 
        'sumber_dana',  
        'sumber_dana_mak', 
        'penyedia', 
        'penyedia_awal', 
        'penyedia_akhir', 
        'pelaksanaan_awal', 
        'pelaksanaan_akhir', 
        'id_operator'
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = uuid();
        });
    }

    /**
     * Scope a query for UUID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query, $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUuid($query, $uuid) 
    {
        return $query->whereUuid($uuid);
    }

    /**
     * Scope a query for TAHUN.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query, $tahun
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTahun($query, $tahun) 
    {
        return $query->whereTahun($tahun);
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operator() 
    {
        return $this->belongsTo('Modules\Pengguna\Entities\Operator', 'id_operator');
    }
}