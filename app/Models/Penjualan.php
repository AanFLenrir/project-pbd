<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'idpenjualan';
    public $timestamps = false;

    /**
     * Panggil stored procedure untuk create penjualan
     */
    public static function createSP($subtotal, $ppn, $total, $iduser, $idmargin_penjualan)
    {
        $result = DB::select("CALL sp_create_penjualan(?, ?, ?, ?, ?)", [
            $subtotal,
            $ppn,
            $total,
            $iduser,
            $idmargin_penjualan
        ]);

        return $result[0]->idpenjualan_baru ?? null;
    }

    /**
     * Ambil semua data penjualan
     */
    public static function getAll()
    {
        return DB::select("
            SELECT 
                pj.idpenjualan,
                pj.created_at,
                pj.subtotal_nilai,
                pj.ppn,
                pj.total_nilai,
                u.username AS nama_user,
                m.persen AS persen_margin
            FROM penjualan pj
            JOIN user u ON pj.iduser = u.iduser
            JOIN margin_penjualan m ON pj.idmargin_penjualan = m.idmargin_penjualan
            ORDER BY pj.idpenjualan DESC
        ");
    }
}
