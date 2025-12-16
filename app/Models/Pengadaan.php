<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pengadaan extends Model
{
    protected $table = 'pengadaan';
    protected $primaryKey = 'idpengadaan';
    public $timestamps = false;

    protected $fillable = [
        'user_iduser',
        'vendor_idvendor', 
        'subtotal_nilai',
        'ppn',
        'total_nilai',
        'status',
        'timestamp'
    ];

    /**
     * Panggil stored procedure untuk membuat pengadaan baru
     */
    public static function createSP($user_id, $vendor_id, $subtotal, $ppn, $total, $status)
    {
        try {
            Log::info('Executing SP: sp_create_pengadaan', [
                'user_id' => $user_id,
                'vendor_id' => $vendor_id,
                'subtotal' => $subtotal,
                'ppn' => $ppn,
                'total' => $total,
                'status' => $status
            ]);

            $result = DB::select("CALL sp_create_pengadaan(?, ?, ?, ?, ?, ?)", [
                $user_id,
                $vendor_id,
                $subtotal,
                $ppn,
                $total,
                $status
            ]);

            Log::info('SP Result:', ['result' => $result]);

            // Cek berbagai kemungkinan nama field yang dikembalikan
            if (isset($result[0])) {
                $firstResult = (array)$result[0];
                Log::info('SP First Result Array:', $firstResult);
                
                // Coba berbagai nama field yang mungkin
                $id = $firstResult['idpengadaan_baru'] ?? 
                      $firstResult['new_id'] ?? 
                      $firstResult['last_insert_id'] ?? 
                      $firstResult['id'] ?? null;
                      
                Log::info('Extracted ID:', ['id' => $id]);
                return $id;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Error calling sp_create_pengadaan: ' . $e->getMessage());
            
            // Fallback ke method manual jika SP error
            return self::createManual($user_id, $vendor_id, $subtotal, $ppn, $total, $status);
        }
    }

    /**
     * Method alternatif tanpa stored procedure
     */
    public static function createManual($user_id, $vendor_id, $subtotal, $ppn, $total, $status)
    {
        try {
            Log::info('Using manual create method');
            
            $id = DB::table('pengadaan')->insertGetId([
                'user_iduser' => $user_id,
                'vendor_idvendor' => $vendor_id,
                'subtotal_nilai' => $subtotal,
                'ppn' => $ppn,
                'total_nilai' => $total,
                'status' => $status,
                'timestamp' => now()
            ]);
            
            Log::info('Manual create success, ID:', ['id' => $id]);
            return $id;
            
        } catch (\Exception $e) {
            Log::error('Error in createManual: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Ambil semua data pengadaan dari tabel
     */
    public static function getAll()
    {
        try {
            return DB::select("
                SELECT 
                    p.idpengadaan,
                    p.timestamp,
                    p.status,
                    p.subtotal_nilai,
                    p.ppn,
                    p.total_nilai,
                    v.nama_vendor,
                    u.username AS nama_user
                FROM pengadaan p
                JOIN vendor v ON p.vendor_idvendor = v.idvendor
                JOIN user u ON p.user_iduser = u.iduser
                ORDER BY p.timestamp DESC, p.idpengadaan DESC
            ");
        } catch (\Exception $e) {
            Log::error('Error getting pengadaan data: ' . $e->getMessage());
            return [];
        }
    }
}