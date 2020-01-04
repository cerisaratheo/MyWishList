<?php


namespace mywishlist\models;


class Utilisateur extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'uid';
    public $timestamps = false;

    public function role(){
        return $this->belongsTo('mywishlist\models\Role', 'role_id');
    }
}