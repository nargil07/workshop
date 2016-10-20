<?php

namespace App\Http\Controllers;

use App\Entrepreneur;
use App\Stagiaire;
use App\Utilisateur;
use Hamcrest\Util;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;

class UtilisateurController extends Controller
{
    public function inscription(Request $request)
    {
        if ($request->has("mail") && $request->has("pwd")) {
            $user = new Utilisateur();
            if ($request->has("siret") && $request->has("raisonSocial")) {

                try {

                    $user->mail = $request->mail;
                    $user->mdp = $request->pwd;
                    $user->save();

                } catch (QueryException $queryException) {
                    $user->delete();
                    return response()->json([
                        "error" => "Le mail existe déjà"
                    ]);
                }
                try {
                    $entrepreneur = new Entrepreneur();
                    $entrepreneur->raisonSocial = $request->raisonSocial;
                    $entrepreneur->siret = $request->siret;
                    $entrepreneur->Utilisateur()->associate($user);
                    $entrepreneur->save();
                } catch (QueryException $queryException) {
                    $user->delete();
                    return response()->json([
                        "error" => "Le siret existe déjà"
                    ]);
                }

                return response()->json(true);
            } elseif ($request->has("nom") && $request->has("prenom") && $request->has("dateNaissance")) {
                try {
                    $user->mail = $request->mail;
                    $user->mdp = $request->pwd;
                    $user->save();

                } catch (QueryException $queryException) {
                    $user->delete();
                    return response()->json([
                        "error" => "Le mail existe déjà"
                    ]);
                }
                $stagiaire = new Stagiaire();
                $stagiaire->nom = $request->nom;
                $stagiaire->prenom = $request->prenom;
                $stagiaire->dateNaissance = $request->dateNaissance;
                $stagiaire->Utilisateur()->associate($user);
                $stagiaire->save();
                return response()->json("true");
            } else {
                return [
                    "error" => "il manque des informations"
                ];
            }
        } else {
            $result = [
                "error" => "il manque le mail ou le mot de passe"
            ];
            return response()->json($result);
        }
    }

    public function connexion(Request $request){
        if($request->has("mail") && $request->has("pwd")){
            $user = Utilisateur::where('mail', $request->mail)
                        ->where('mdp', $request->pwd)->first();
            if($user != null){
                return response()->json($user);
            }else{
                return response()->json(false);
            }
        }
    }
}
