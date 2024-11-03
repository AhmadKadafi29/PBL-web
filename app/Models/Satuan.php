<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class satuan extends Model
{
    use HasFactory;
    protected $table = 'satuans'; 
    protected $primaryKey ='id';
    protected $fillable = [ 'nama_satuan' ]; 
    public function detailsatuan(): HasMany 
   
      { 
        return $this->hasMany(detailsatuan::class,'id_satuan');
    }

}
