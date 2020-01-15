<?php


namespace mywishlist\models;


class Role extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'role';
    protected $primaryKey = 'role_id';
    public $timestamps = false;

    public function users(){
        return $this->hasMany('\mywishlist\models\Utilisateur','role');
}
}