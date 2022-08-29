<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PanierProduit extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'panier_id',
        'produit_id',
        'quantite_produit',
        'prix_total',
        'created_at',
        'updated_at'
    ];
}
