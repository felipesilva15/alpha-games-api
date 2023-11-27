<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'USUARIO';
    protected $primaryKey = 'USUARIO_ID';
    public $timestamps = false;

    protected $fillable = [
        'USUARIO_NOME',
        'USUARIO_EMAIL',
        'USUARIO_SENHA',
        'USUARIO_CPF'
    ];

    protected $hidden = [
        'USUARIO_SENHA'
    ];

    public static function rules(): Array {
        return [
            'USUARIO_NOME' => 'required|string',
            'USUARIO_EMAIL' => 'required|string|email|unique:USUARIO,USUARIO_EMAIL',
            'USUARIO_SENHA' => 'required|string|min:3',
            'USUARIO_CPF' => 'required|string|unique:USUARIO,USUARIO_CPF|min:11'
        ];
    }

    public static function rulesUpdate(): Array {
        $rules = User::rules();

        $rules['USUARIO_EMAIL'] = str_replace('|unique:USUARIO,USUARIO_EMAIL', '', $rules['USUARIO_EMAIL']);
        $rules['USUARIO_CPF'] = str_replace('|unique:USUARIO,USUARIO_CPF', '', $rules['USUARIO_CPF']);

        return $rules;
    }

    public function orders() {
        return $this->hasMany('App\Models\Order', 'USUARIO_ID', 'USUARIO_ID');
    }

    public function cartItems() {
        return $this->hasMany('App\Models\CartItem', 'USUARIO_ID', 'USUARIO_ID');
    }

    public function Adresses() {
        return $this->hasMany('App\Models\Address', 'USUARIO_ID', 'USUARIO_ID');
    }

    // Método para retornar um único objeto do endereço ativo do usuário
    public function activeAddress() {
        return $this->adresses()->where('ENDERECO_APAGADO', 0)->first();
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function getAuthPassword() {
        return $this->USUARIO_SENHA;
    }
}
