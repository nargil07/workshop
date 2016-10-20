<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stagiaire extends AbstractModel
{
    protected $primaryKey = "idStagiaire";

    public function Utilisateur(){
        return $this->belongsTo('App\Utilisateur', 'idUtilisateur', 'idUtilisateur');
    }
}
