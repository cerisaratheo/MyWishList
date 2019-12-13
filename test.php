<?php

namespace mywishlist;
use mywishlist\bd\Eloquent;
use mywishlist\models\Liste;
use mywishlist\models\Item;

require 'src/vendor/autoload.php';

Eloquent::start('src/conf/conf.ini');

// QUESTION 1.1 -----------
echo '<h3>Liste des souhaits</h3>';
$souhaits = Liste::select('*')
                -> get();
foreach ($souhaits as $souhait)
    echo '<p>'.$souhait->no.' - '.$souhait->titre.'</p>';

// QUESTION 1.2 -----------
echo '<h3>Liste des items</h3>';
$items = Item::select('*')
    -> get();
foreach ($items as $item)
    echo '<p>'.$item->id.' - '.$item->nom.'</p>';

// QUESTION 1.3 -----------
if (isset($_GET['id'])){
    echo '<h3>Item numéro '.$_GET['id'].' (GET)</h3>';
    $item = Item::select('*')
        -> where('id','=', $_GET['id'])
        -> first();
    echo '<p>'.$item->id.' - '.$item->nom.' : '.$item->descr.'</p>';
}

// QUESTION 1.4 -----------
$i = new Item();
$i->nom = 'Carte graphique';
$i->descr = 'une rtx 2080 svp';
//$i->save();

echo '<h3>Ajout d\'un item (off)</h3>';
$nouvItem = Item::select('*')
        ->where('nom','=',$i->nom)
        ->first();
//echo '<p>'.$nouvItem->id.' - '.$nouvItem->nom.'</p>';

// QUESTION 2.1 -----------
echo '<h3>Nom de la liste de chaque items</h3>';
echo '<strong>(Si elle existe)</strong>';
$listeItems = Item::select('*')
        -> where('liste_id','!=', '0')
        -> get();
foreach ($listeItems as $item) {
    $nomListe = $item->liste()
        ->first()
        ->titre;
    echo '<p><b>Item</b> : '.$item->id.' -- <b>Liste</b> : '.$nomListe.'</p>';
}

// QUESTION 2.2 -----------
if (isset($_GET['no'])){
    echo '<h3>Liste numéro '.$_GET['no'].' (GET)</h3>';
    $l2 = Liste::select('*')
        -> where('no','=', $_GET['no'])
        -> first();
    if (! is_null($l2)) {
        echo '<p>Liste '.$l2->no.' : </p>';
        $i2 = $l2->item()->get();
        foreach ($i2 as $i)
            echo '<p> * Item '.$i->id.' : '.$i->nom.'</p>';
    }
    else {
        echo 'La liste numéro '.$_GET['no'].' n\'existe pas';
    }
}
