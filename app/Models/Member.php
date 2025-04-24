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
    public $keyType = 'string';

    protected $fillable = [
        'id_member',
        'id_user',
        'nama',
        'email',
        'alamat',
        'no_tlp',
    ];
    
    protected static function boot() 
    {
        parent::boot();
        static::creating(function ($member) {
            $lastmember = Member::orderBy('id_member', 'desc')->first();
            $lastmember = $lastmember ? intval(substr($lastmember->id_member, 2)) : 0;
            $member->id_member = 'M' . str_pad($lastmember + 1, 4, '0', STR_PAD_LEFT);
        });  
    }
    
    //relasi ke tabel lain
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_member', 'id_member');
    }
    
}
