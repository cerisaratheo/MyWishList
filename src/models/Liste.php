<?php


namespace mywishlist\models;


class Liste extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function item(){
        return $this->hasMany('mywishlist\models\Item','liste_id');
    }
}