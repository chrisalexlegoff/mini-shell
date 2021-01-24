<?php

function calculerCheminEncoursFile(string $cheminEnCours)
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

function myrm(array $command_options, string $cheminEnCours)
{
    $chemin = calculerCheminEnCoursFile($cheminEnCours);
    if ($chemin === false) {
        echoWithColor("chemin invalide!!!!!\n", COLOR_RED);
    } else {
        $cptDir = 0;
        foreach ($command_options as $option) {
            if (preg_match("#i#", $option)) {
                $optionI = true;
            }
            if (!empty($command_options)) {
                foreach ($command_options as $option) {
                    switch ($option) {
                        case 'd':
                            if (!is_dir($chemin)) {
                                echoWithColor("option incorrecte! -d sert à supprimer un dossier unique", COLOR_RED);
                            } elseif (is_dir($chemin)) {
                                $items = array_diff(scandir($chemin), array('..', '.'));
                                foreach ($items as $item) {
                                    if (is_dir($chemin . "/" . $item)) {
                                        echoWithColor("Effacement impossible! " . basename($chemin) . " contient un répertoire, utiliser l'option r ou R" . PHP_EOL, COLOR_LIGHT_RED);
                                        $cptDir++;
                                    }
                                }
                                if ($cptDir == 0) {
                                    if ($optionI) {
                                        while (true) {
                                            $reponse = readlineWithColor("Voulez-vous continuer l'opération ? taper Y pour continuer ou 'entrer' pour quitter", COLOR_RED);
                                            if ($reponse != 'y') {
                                                break 2;
                                            } else {
                                                break;
                                            }
                                        }
                                    }
                                    foreach ($items as $item) {
                                        if (!is_dir($chemin . "/" . $item)) {
                                            unlink($chemin . "/" . $item);
                                        }
                                    }
                                    rmdir($chemin);
                                    echoWithColor($chemin . " éffacé avec succès!" . PHP_EOL, COLOR_GREEN);
                                }
                            }
                            break;
                        case 'r':
                            rmFile($chemin, $command_options);
                            break;
                        case 'R':
                            rmFile($chemin, $command_options);
                            break;
                    }
                }
            } elseif (is_dir($chemin)) {
                echoWithColor("Aucun fichier à supprimer! option -r ou -R pour supprimer un dossier", COLOR_RED);
            } elseif (file_exists($chemin)) {
                if ($optionI) {
                    while (true) {
                        $reponse = readlineWithColor("Voulez-vous continuer l'opération ? taper Y pour continuer ou 'entrer' pour quitter", COLOR_RED);
                        if ($reponse != 'y') {
                            unlink($chemin);
                            echoWithColor($chemin . " a été supprimé avec succès.", COLOR_GREEN);
                        } else {
                            break;
                        }
                    }
                } else {
                    unlink($chemin);
                    echoWithColor($chemin . " a été supprimé avec succès.", COLOR_GREEN);
                }
            } else {
                echoWithColor("ERREUR" . PHP_EOL, COLOR_RED);
            }
        }
    }
}

function rmFile(string $cheminEnCours, $command_options): void
{
    $quit = false;
    foreach ($command_options as $option) {
        if (preg_match("#i#", $option)) {
            $optionI = true;
        } else {
            $optionI = false;
        }
    }

    if (is_dir($cheminEnCours)) {
        $dirHandle = opendir($cheminEnCours);
        while (($item = readdir($dirHandle)) != false) {

            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $cheminEnCours . "/" . $item;
                if ($optionI) {
                    while (true) {
                        $reponse = readlineWithColor("Voulez-vous vraiment éffacer " . $fichierAvecChemin . " ? taper Y pour continuer ou 'entrer' pour quitter", COLOR_RED);
                        if ($reponse != 'y') {
                            break;
                        } else {
                            if (is_dir($fichierAvecChemin)) {
                                //echoWithColor("Répertoire : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_LIGHT_MAGENTA);
                                rmFile($fichierAvecChemin, $command_options);
                            break;
                            } else {
                                //echoWithColor("Fichier : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_GREEN);
                                unlink($fichierAvecChemin);
                            break;
                            }
                        }
                    }
                } elseif (is_dir($fichierAvecChemin)) {
                    //echoWithColor("Répertoire : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_LIGHT_MAGENTA);
                    rmFile($fichierAvecChemin, $command_options);
                } else {
                    //echoWithColor("Fichier : " . $fichierAvecchemindestination . " créé ..." . PHP_EOL, COLOR_GREEN);
                    unlink($fichierAvecChemin);
                }
            }
        }
        closedir($dirHandle);
    } elseif ($optionI) {
        while (true) {
            $reponse = readlineWithColor("Voulez-vous vraiment éffacer " . $cheminEnCours . "  ? taper Y pour continuer ou 'entrer' pour quitter", COLOR_RED);
            if ($reponse != 'y') {
                unlink($cheminEnCours);
                echoWithColor($cheminEnCours . " a été supprimé avec succès.", COLOR_GREEN);
            break;
            } else {
                break;
            }
        }
    } else {
        unlink($cheminEnCours);
    }


    if (!$quit) {
        rmRep($cheminEnCours);
        echoWithColor("Dossier " . $cheminEnCours . " supprimé avec succès." . PHP_EOL, COLOR_GREEN);
    }
}
// if (is_dir($cheminEnCours)) {
//     $dirHandle = opendir($cheminEnCours);
//     while (($item = readdir($dirHandle)) != false) {
//         if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
//             $fichierAveccheminEnCours = $cheminEnCours . "/" . $item;
//             if (is_dir($fichierAveccheminEnCours)) {
//                 rmFile($fichierAveccheminEnCours, $command_options);
//             } elseif ($optionI) {
//                 while (true) {
//                     $reponse = readlineWithColor("Voulez-vous continuer l'opération ? taper Y pour continuer ou 'entrer' pour quitter", COLOR_RED);
//                     if ($reponse != 'y') {
//                         unlink($fichierAveccheminEnCours);
//                         echoWithColor($fichierAveccheminEnCours . " a été supprimé avec succès.", COLOR_GREEN);
//                     } else {
//                         $quit = true;
//                         break;
//                     }
//                 }
//             } else {
//                 unlink($fichierAveccheminEnCours);
//             }
//         } 
//     }
//     closedir($dirHandle);

// } elseif ($optionI) {
//     while (true) {
//         $reponse = readlineWithColor("Voulez-vous continuer l'opération ? taper Y pour continuer ou 'entrer' pour quitter", COLOR_RED);
//         if ($reponse != 'y') {
//             unlink($cheminEnCours); 
//             echoWithColor($cheminEnCours . " a été supprimé avec succès.", COLOR_GREEN);
//             rmFile($cheminEnCours, $command_options);

//         } else {
//             $quit = true;
//             break;
//         }
//     }
// } else {
//     unlink($cheminEnCours);
// }

// if (!$quit) {
//     rmRep($cheminEnCours);
// }


function rmRep(string $cheminEnCours): void
{
    $nouveauChemin = $cheminEnCours;
    if (is_dir($nouveauChemin)) {
        $dirHandle = opendir($nouveauChemin);
        while (($item = readdir($dirHandle)) != false) {
            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $nouveauChemin . "/" . $item;
                if (is_dir($fichierAvecChemin)) {
                    rmRep($fichierAvecChemin);
                }
            }
            rmdir($cheminEnCours);
            break;
        }
    }
}
