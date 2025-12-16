<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class Penerimaan extends Model
{
    protected $table = 'penerimaan';
    protected $primaryKey = 'idpenerimaan';
    public $timestamps = false;

    protected $fillable = [
        'idpengadaan',
        'iduser', 
        'status'
    ];

    /**
     * Buat penerimaan baru menggunakan Eloquent
     */
    public static function createSP($idpengadaan, $iduser, $status)
    {
        try {
            // Validasi data referensi terlebih dahulu
            $userExists = DB::table('user')->where('iduser', $iduser)->exists();
            $pengadaanExists = DB::table('pengadaan')->where('idpengadaan', $idpengadaan)->exists();
            
            if (!$userExists) {
                throw new \Exception("User dengan ID {$iduser} tidak ditemukan");
            }
            
            if (!$pengadaanExists) {
                throw new \Exception("Pengadaan dengan ID {$idpengadaan} tidak ditemukan");
            }

            // Gunakan Eloquent create - PERBAIKI SYNTAX INI
            $penerimaan = self::create([
                'idpengadaan' => $idpengadaan,
                'iduser' => $iduser,
                'status' => $status
            ]);

            return $penerimaan->idpenerimaan;

        } catch (QueryException $e) {
            // Tangani error foreign key constraint
            if ($e->getCode() == 23000) {
                throw new \Exception("Data referensi tidak valid. Pastikan user dan pengadaan ada di database.");
            }
            throw $e;
        }
    }

    /**
     * Ambil semua data penerimaan
     */
    public static function getAll()
    {
        return DB::select("
            SELECT 
                pr.idpenerimaan,
                pr.created_at,
                pr.status,
                u.username AS nama_user,
                p.idpengadaan,
                p.total_nilai AS nilai_pengadaan
            FROM penerimaan pr
            JOIN user u ON pr.iduser = u.iduser
            JOIN pengadaan p ON pr.idpengadaan = p.idpengadaan
            ORDER BY pr.idpenerimaan DESC
        ");
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    /**
     * Relasi ke model Pengadaan
     */
    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'idpengadaan', 'idpengadaan');
    }
}