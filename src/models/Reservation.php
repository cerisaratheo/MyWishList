<?php


namespace mywishlist\models;


class Reservation extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'reservation';
    protected $primaryKey = 'id_item';
    public $timestamps = false;

}