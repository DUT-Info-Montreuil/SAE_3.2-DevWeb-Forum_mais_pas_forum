<?php

class Autorisations
{


// on attend d'avoir les noms des actions qu'on va choisir


//exemple des TP

//require_once __DIR__ . '/../Utilisateur/Model/UtilisateurRepository.php';
//    public static function peut(string $role ,string $module , string $action) : bool {
//        if (!in_array($role, ['administrateur', 'editeur', 'lecteur','editeur_iut','editeur_departement'], true)) {
//            return false;
//        }
//        $modules = ['iut', 'departement', 'utilisateur'];
//
//        if (!in_array($module, $modules, true)) {
//            return false;
//        }
//
//        if ($module === 'utilisateur' && $action === 'roles'){
//            return $role === 'administrateur';
//        }
//        $lectures = ['liste', 'detail'];
//
//        if (in_array($action, $lectures, true)) {
//            return true;
//        }
//        $ecritures = ['ajouter','modifier','suprimer','ajouter','formulaire_modification','formulaire_ajout'];
//        if ($module === 'iut') {
//            if (in_array($action, $ecritures, true)) {
//                return $role === 'administrateur' || $role === 'editeur' || $role === 'editeur_iut';
//            }
//            return false;
//        }
//        elseif ($module === 'departement') {
//            if (in_array($action, $ecritures, true)) {
//                return $role === 'administrateur' || $role === 'editeur'|| $role === 'editeur_departement';
//            }
//            return false;
//        }
//        return false;
//    }

}