<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class denda extends Model
{
    use HasFactory;
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    public $timestamps = false;
    public $keyType = 'string';

    protected $fillable = [
        'id_denda',
        'id_pinjem',
        'jenis_denda',
        'besar_denda',
    ];
    
    protected static function boot() 
    {
        parent::boot();
        static::creating(function ($denda) {
           $lastdenda = Denda::orderBy('id_denda', 'desc')->first();
           $lastdenda = $lastdenda ? intval(substr($lastdenda->id_denda, 2)) : 0;
           $denda->id_denda = 'D' . str_pad($lastdenda + 1, 4, '0', STR_PAD_LEFT);
        });  
    }
    
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_pinjem', 'id_pinjem');
    }
    
}
