<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'PEDIDO_STATUS';
    protected $primaryKey = 'STATUS_ID';
    protected $fillable = ['STATUS_DESC'];
    public $timestamps = false;

    public static function rules(): Array {
        return [
            'STATUS_DESC' => 'string|required'
        ];
    }
}
