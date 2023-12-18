<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Order",
 *      @OA\Property(property="PEDIDO_ID", type="integer", example=1),
 *      @OA\Property(property="USUARIO_ID", type="integer", example=1),
 *      @OA\Property(property="STATUS_ID", type="integer", example=2),
 *      @OA\Property(property="PEDIDO_DATA", type="string", format="date-time", example="2023-11-27T03:00:00.000000Z"),
 *      @OA\Property(property="ENDERECO_ID", type="integer", example=1)
 * )
 */
class Order extends Model
{
    use HasFactory;

    protected $table = 'PEDIDO';
    protected $primaryKey = 'PEDIDO_ID';
    protected $fillable = ['USUARIO_ID', 'STATUS_ID', 'PEDIDO_DATA', 'ENDERECO_ID'];
    public $timestamps = false;
    protected $casts = [
        'PEDIDO_DATA' => 'date'
    ];

    public static function rules(): Array {
        return [
            'PEDIDO_DATA' => 'date|nullable',
            'STATUS_ID' => 'int',
            'ENDERECO_ID' => 'required|int'
        ];
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'USUARIO_ID', 'USUARIO_ID');
    }

    public function status() {
        return $this->belongsTo('App\Models\OrderStatus', 'STATUS_ID', 'STATUS_ID');
    }

    public function items() {
        return $this->hasMany('App\Models\OrderItem', 'PEDIDO_ID', 'PEDIDO_ID');
    }

    public function address() {
        return $this->belongsTo('App\Models\Address', 'ENDERECO_ID', 'ENDERECO_ID');
    }
}
