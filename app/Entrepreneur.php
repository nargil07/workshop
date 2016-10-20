<?php

namespace App;

class Entrepreneur extends AbstractModel
{
    protected $primaryKey = "idEntepreneur";

    public function Utilisateur(){
        return $this->belongsTo('App\Utilisateur', 'idUtilisateur', 'idUtilisateur');
    }
}
