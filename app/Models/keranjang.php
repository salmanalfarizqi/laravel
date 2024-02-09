<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_meja',
        'id_barang',
        'qty',
        'totals'
    ];

    public function item():BelongsTo
    {
        return $this -> belongsTo(barang::class, 'id_barang', 'id');
    }
}
