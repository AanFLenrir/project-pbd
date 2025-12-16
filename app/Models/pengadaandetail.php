<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengadaanDetail extends Model
{
    protected $table = 'pengadaan_detail';
    protected $primaryKey = 'idpengadaan_detail';
    public $timestamps = false;

    protected $fillable = [
        'pengadaan_idpengadaan',
        'barang_idbarang',
        'qty',
        'harga_satuan',
        'subtotal'
    ];

    /**
     * Relationship dengan Pengadaan
     */
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'pengadaan_idpengadaan', 'idpengadaan');
    }

    /**
     * Relationship dengan Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_idbarang', 'idbarang');
    }
}