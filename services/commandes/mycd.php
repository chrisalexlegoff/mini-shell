<?php

function mycd(string &$path, string $chemin)
{
    $nouveauChemin = calculerChemin($path, $chemin);
    if ($nouveauChemin === false) {
        echoWithColor ("chemin invalide!!!!!\n",COLOR_RED);
    } else {
        $path = $nouveauChemin;
    }
}