<?php

// include "../lib/helpers.php";

$command_options = [];
$command_args = [];
$commandLine = null;

function analyseCommande($commandLineGlobale, &$commandLine, &$commandArgs, &$commandOptions, &$cheminOrig, &$cheminDest)
{
    $matches = [];
    // $estValide = preg_match("#^([A-Za-z]\w*) *((?:(?: +(?:(?:-[A-Za-z]+)|(?:[\\\/A-Za-z]+(?:[\.\-_]*[A-Za-z0-9]+)*|)))+)*)$$#", $commandLineGlobale, $matches);
    $estValide = preg_match("#^([A-Za-z]\w*) *((?:(?: +(?:(?:-[A-Za-z]+)|(?:[.\\\/A-Za-z]+(?:[\.\-_]*[\\\/A-Za-z0-9]+)*|)))+)*)$$#", $commandLineGlobale, $matches);

    if ($estValide) {
        $commandLine = $matches[1];
        $subject = explode(" ", $matches[2]);
        $patternOptions = '#^-([A-Za-z]+)$#';
        $patternArgs = '#^[^\-][A-Za-z\\\/]+([\.\-_]*[\\\/A-Za-z0-9]+)*$#';
        $replaceArgs = '$0';
        $replaceOptions = '$1';
        $commandOptions_tmp = preg_filter($patternOptions, $replaceOptions, $subject);
        $commandArgs = preg_filter($patternArgs, $replaceArgs, $subject);
        $commandOptions = [];
        foreach ($commandOptions_tmp as $option) {;
            $commandOptions = array_merge($commandOptions, str_split($option));
        }
        if (!empty($commandOptions && count($subject) != 1)) {
            $cheminOrig = rtrim(str_replace("\\", "/", $subject[2]), "/");
            $cheminDest = rtrim(str_replace("\\", "/", $subject[3]), "/");
        } elseif (empty($commandOptions)) {
            $cheminOrig = rtrim(str_replace("\\", "/", $subject[2]), "/");
            $cheminDest = rtrim(str_replace("\\", "/", $subject[3]), "/");
        }
    } else {
        echo ("n'est pas valide");
    }
}

function mypwd($dirPath)
{
    $dirPath = realpath(getcwd());
    echoWithColor($dirPath . PHP_EOL, COLOR_GREEN);
}

function lireRepertoire(string $dirpath): void
{
    if (is_dir($dirpath)) {
        $dirHandle = opendir($dirpath);
        while (($item = readdir($dirHandle)) != false) {
            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $dirpath . "/" . $item;
                if (is_dir($fichierAvecChemin)) {
                    echo ("- r : " . $fichierAvecChemin . "\n\n");
                    lireRepertoire($fichierAvecChemin);
                } else {
                    echo ("- f : " . $fichierAvecChemin . "\n");
                }
            }
        }
        closedir($dirHandle);
    } else {
        echo ("- f : " . $dirpath . "\n");
    }
}

function copyR($cheminOrig, $cheminDest)
{
    if (is_dir($cheminOrig)) {
        $dirHandle = opendir($cheminOrig);

        while (($item = readdir($dirHandle)) != false) {
            if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                $fichierAvecChemin = $cheminOrig . "/" . $item;
                if (is_dir($fichierAvecChemin)) {
                    if (!is_dir($cheminDest . "/" . $item)) {
                        mkdir($cheminDest . "/" . $item);
                    }
                    opendir($cheminDest . "/" . $item);
                    echoWithColor("Réperoire " . $cheminDest . "/" . $item . "créé...\n", COLOR_MAGENTA);
                    copyR($cheminOrig, $cheminDest);
                } elseif (!is_dir($cheminDest)) {
                    mkdir($cheminDest);
                    opendir($cheminDest);
                    echoWithColor("Réperoire " . $cheminDest . " créé ..." . PHP_EOL, COLOR_GREEN);
                    copy($fichierAvecChemin, $cheminDest . "/" . $item);
                    echoWithColor("Fichier " . $fichierAvecChemin . " copié dans " . $cheminDest . PHP_EOL, COLOR_MAGENTA);
                } else {
                    copy($fichierAvecChemin, $cheminDest . "/" . $item);
                    echoWithColor("Fichier " . $fichierAvecChemin . " copié dans " . $cheminDest . PHP_EOL, COLOR_MAGENTA);
                }
            }
        }
        closedir($dirHandle);
    } else {
        copy($cheminOrig, $cheminDest);
        echoWithColor("Fichier " . $cheminOrig . " copié dans " . $cheminDest . PHP_EOL, COLOR_MAGENTA);
    }
}


function mycp($commandOptions, $cheminOrig, $cheminDest)
{
    foreach ($commandOptions as $command) {
        if ($command == 'r') {
            $optionr = true;
        }
        if ($command == 'R') {
            $optionR = true;
        }
        if ($command == 'f') {
            $optionF = true;
        }
    }
    if (!$optionr && (file_exists($cheminOrig) || is_dir($cheminOrig))) {
        echoWithColor("Aucun fichier à copier! option -r pour copier un dossier", COLOR_RED);
    } elseif ($optionr && (file_exists($cheminOrig) || is_dir($cheminOrig))) {
        copyR($cheminOrig, $cheminDest);
    } elseif (file_exists($cheminOrig) && is_dir($cheminDest)) {
        $nomFichier = basename($cheminOrig);
        copy($cheminOrig, $cheminDest . "/" . "$nomFichier");
        echoWithColor("Fichier copié", COLOR_GREEN);
    } elseif (isset($optionF)) {
        chmod($cheminDest, 0755);
        copy($cheminOrig, $cheminDest);
        echoWithColor("Fichier copié", COLOR_GREEN);
    } else {
        copy($cheminOrig, $cheminDest);
        echoWithColor("Fichier copié", COLOR_GREEN);
    }
    // if (is_dir($cheminOrig) && !$optionr) {
    //     echoWithColor("Erreur : le chemin d'origine est un dossier!", COLOR_RED);
    //     echoWithColor("taper -r pour copier un répertoire", COLOR_RED);
    // } else {
    //     copy($cheminOrig, $cheminDest);
    //     echoWithColor("Fichier copié", COLOR_GREEN);
    // }
}
