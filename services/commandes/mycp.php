<?php

function copyR(string $cheminEnCours, string $chemindestination): void
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


function calculerCheminEncoursCopy(string $cheminEnCours)
{
    //si windows 
    if (getOS() === "Windows") {
        $patternAbsolu = "#^[a-z]:.*$#i";
    } else {
        $patternAbsolu = "#^/.*$#i";
    }
    $cheminEnCours = str_replace("\\", "/", $cheminEnCours);
    // $chemindestination = str_replace("\\", "/", $chemindestination);
    if (preg_match($patternAbsolu, $cheminEnCours)) {
        if (!file_exists($cheminEnCours));
        return false;
        return $cheminEnCours;
    }
    return $cheminEnCours;
}

function calculerCheminDestinationCopy(string $chemindestination)
{
    //si windows 
    if (getOS() === "Windows") {
        $patternAbsolu = "#^[a-z]:.*$#i";
    } else {
        $patternAbsolu = "#^/.*$#i";
    }
    $chemindestination = str_replace("\\", "/", $chemindestination);
    // $chemindestination = str_replace("\\", "/", $chemindestination);
    if (preg_match($patternAbsolu, $chemindestination)) {
        if (!file_exists($chemindestination) && !is_dir($chemindestination));
        return false;
        return $chemindestination;
    }
    return $chemindestination;
}

function mycp($command_options, $cheminEnCours, $chemindestination)
{
    $nouveauCheminEncours = calculerCheminEnCoursCopy($cheminEnCours);
    $nouveauCheminDestination = calculerCheminDestinationCopy($chemindestination);
    if ($nouveauCheminEncours === false || $nouveauCheminDestination == false) {
        echoWithColor("chemin invalide!!!!!\n", COLOR_RED);
    } elseif (!empty($command_options)) {
        foreach ($command_options as $option) {
            switch ($option) {
                case 'r':
                    copyR($nouveauCheminEncours, $nouveauCheminDestination);
                case 'R':
                    copyR($nouveauCheminEncours, $nouveauCheminDestination);
                case 'f':
                    if (!is_dir($nouveauCheminDestination)) {
                        chmod($nouveauCheminDestination, 0755);
                    copy($nouveauCheminEncours, $nouveauCheminDestination);
                    echoWithColor("Fichier copié" . PHP_EOL, COLOR_GREEN); 
                    } else {
                    break;
                    }  
            }
        }
    } else {
        if (is_dir($nouveauCheminEncours)) {
            echoWithColor("Aucun fichier à copier! option -r pour copier un dossier", COLOR_RED);
        } elseif (!is_dir($nouveauCheminEncours) && is_dir($nouveauCheminDestination)) {
            $nomFichier = basename($nouveauCheminEncours);
            copy($nouveauCheminEncours, $nouveauCheminDestination . "/" . "$nomFichier");
            echoWithColor("Fichier copié", COLOR_GREEN);
        } elseif (file_exists($nouveauCheminEncours)) {
            copy($nouveauCheminEncours, $nouveauCheminDestination);
        } else {
            echoWithColor("ERREUR" . PHP_EOL, COLOR_RED);
        }
    }
}