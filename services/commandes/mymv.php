<?php

function MouveR(string $cheminEnCours, string $chemindestination): void
{
    if (is_dir($cheminEnCours)) {
        if (!is_dir($chemindestination)) {
            mkdir($chemindestination);
        }
        $dirHandle = opendir($cheminEnCours);
        while (($item = readdir($dirHandle)) != false) {
            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $cheminEnCours . "/" . $item;
                $fichierAvecchemindestination = $chemindestination . "/" . $item;
                if (is_dir($fichierAvecChemin)) {
                    echoWithColor("Répertoire : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_LIGHT_MAGENTA);
                    copyR($fichierAvecChemin, $fichierAvecchemindestination);
                } else {
                    echoWithColor("Fichier : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_GREEN);
                    copy($fichierAvecChemin, $fichierAvecchemindestination);
                }
            }
        }
        closedir($dirHandle);
    } else {
        echo ("- f : " . $cheminEnCours . "\n");
        copy($cheminEnCours, $chemindestination);
    }
}

function mymv($command_options, $cheminEnCours, $chemindestination)
{
    $nouveauCheminEncours = calculerCheminEnCoursCopy($cheminEnCours);
    $nouveauCheminDestination = calculerCheminDestinationCopy($chemindestination);
    if ($nouveauCheminEncours === false || $nouveauCheminDestination == false) {
        echoWithColor("chemin invalide!!!!!\n", COLOR_RED);
    }
    if (is_dir($nouveauCheminEncours)) {
        if (!is_dir($nouveauCheminDestination)) {
            mkdir($nouveauCheminDestination);
        }
        $dirHandle = opendir($nouveauCheminEncours);
        while (($item = readdir($dirHandle)) != false) {
            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $nouveauCheminEncours . "/" . $item;
                $fichierAvecchemindestination = $nouveauCheminDestination . "/" . $item;
                if (is_dir($fichierAvecChemin)) {
                    echoWithColor("Répertoire : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_LIGHT_MAGENTA);
                    copyR($fichierAvecChemin, $fichierAvecchemindestination);
                } else {
                    echoWithColor("Fichier : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_GREEN);
                    copy($fichierAvecChemin, $fichierAvecchemindestination);
                }
            }
        }
        closedir($dirHandle);
    } else {
        echo ("- f : " . $nouveauCheminEncours . "\n");
        copy($nouveauCheminEncours, $nouveauCheminDestination);
    }
    myrmMouve($nouveauCheminEncours);
}

function myrmMouve(string $chemin)
{

    if (is_dir($chemin)) {
        $dirHandle = opendir($chemin);
        while (($item = readdir($dirHandle)) != false) {

            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $chemin . "/" . $item;
                if (is_dir($fichierAvecChemin)) {
                    //echoWithColor("Répertoire : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_LIGHT_MAGENTA);
                    myrmMouve($fichierAvecChemin);
                } else {
                    //echoWithColor("Fichier : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_GREEN);
                    unlink($fichierAvecChemin);
                }
            }
        }
        closedir($dirHandle);
    } else {
        unlink($chemin);
    }
    rmRepMouve($chemin);
}

function rmRepMouve(string $chemin): void
{
    $nouveauChemin = $chemin;
    if (is_dir($nouveauChemin)) {
        $dirHandle = opendir($nouveauChemin);
        while (($item = readdir($dirHandle)) != false) {
            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $nouveauChemin . "/" . $item;
                if (is_dir($fichierAvecChemin)) {
                    rmRep($fichierAvecChemin);
                }
            }
            rmdir($chemin);
            break;
        }
    }
}
