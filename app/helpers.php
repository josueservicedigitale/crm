<?php
// app/helpers.php

use App\Models\Parametre;

if (!function_exists('parametre')) {
    /**
     * Récupère la valeur d'un paramètre
     */
    function parametre(string $cle, $defaut = null)
    {
        return Parametre::obtenir($cle, $defaut);
    }
}

if (!function_exists('parametres_groupe')) {
    /**
     * Récupère tous les paramètres d'un groupe
     */
    function parametres_groupe(string $groupe): array
    {
        return Parametre::parGroupe($groupe);
    }
}

if (!function_exists('definir_parametre')) {
    /**
     * Définit ou met à jour un paramètre
     */
    function definir_parametre(string $cle, $valeur, array $options = [])
    {
        return Parametre::definir($cle, $valeur, $options);
    }
}