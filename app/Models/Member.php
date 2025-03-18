<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';
    protected $primaryKey = 'id_member';
    public $timestamps = false;

    protected $fillable = [
        'id_member',
        'nama',
        'email',
        'alamat',
        'no_tlp',
    ];
    
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_member', 'id_member');
    }
}
