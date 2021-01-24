<?php

function calculerChemin(string $cheminEnCours, string $chemindestination)
{
    //si windows 
    if (getOS() === "Windows") {
        $patternAbsolu = "#^[a-z]:.*$#i";
    } else {
        $patternAbsolu = "#^/.*$#i";
    }
    $cheminEnCours = str_replace("\\", "/", $cheminEnCours);
    $chemindestination = str_replace("\\", "/", $chemindestination);
    if (preg_match($patternAbsolu, $chemindestination)) {
        if (!file_exists($chemindestination))
            return false;
        return $chemindestination;
    }
    
    $partieChemin = explode("/", $chemindestination);
    foreach ($partieChemin as $unePartie) {
        if (preg_match("#^\.{2}.*#", $unePartie)) {
            $cheminEnCours = dirname($cheminEnCours, 1);
        } else if (preg_match("#^[^.]+$#i", $unePartie)) {
            $cheminEnCours = $cheminEnCours . "/" . $unePartie;  
        }
        $cheminEnCours = str_replace("\\", "/", $cheminEnCours);
        $cheminEnCours = str_replace("//", "/", $cheminEnCours);
    }

    if (!file_exists($cheminEnCours))
        return false;

    return $cheminEnCours;
}

function analyseCommande($Line, &$commandLine, &$command_args, &$command_options, $est_decoupage_options = true)
{
    $Line = trim($Line);
    $commandLine = null;
    $command_args = [];
    $command_options = [];
    $matches = [];
    $patternArgs = "([^ -]+([-]?[^ -]*)*[-]?)|(?:(?:\"[^\"]+\")|(?:\'[^\']+\'))";

    $estValide = preg_match("#^([A-Za-z]\w*) *((?:(?: +(?:(?:-[A-Za-z0-9]+)|" . $patternArgs . "))+)*)$#", $Line, $matches);

    if ($estValide) {
        $commandLine = $matches[1];
        $subject = preg_split("/[\s]*(\\\"[^\\\"]+\\\")[\s]*|" . "[\s]*('[^']+')[\s]*|" . "[\s,]+/", trim($matches[2]), 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        //récuperer les options
        $command_options = recupererOptions($subject, $est_decoupage_options);
        //récuperer les arguments
        $command_args = recupererArguments($subject);
    } else {
        echoWithColor("Saisie de la liste de commande incorrecte \n", COLOR_RED);
    }
}
function recupererArguments($subject)
{
    $patterns = ["#^\'([^\']+)\'$#", "#^\"([^\"]+)\"$#", "#^[^ -]+([-]?[^ -]*)*[-]?$#"];
    $replaces = ["$1", "$1", "$0"];
    $command_args = preg_filter($patterns, $replaces, $subject);
    $command_args = array_values($command_args);
    return $command_args;
}
function recupererOptions($subject, $est_decoupage_options)
{
    $patternOptions = '#^-([A-Za-z0-9]+)$#';
    $replaceOptions = '$1';
    $command_options_tmp = preg_filter($patternOptions, $replaceOptions, $subject);
    $command_options = [];
    if ($est_decoupage_options) {
        foreach ($command_options_tmp as $option) {;
            $command_options = array_merge($command_options, str_split($option));
        }
    } else {
        $command_options =  $command_options_tmp;
    }
    return $command_options;
}
function returnCommand (&$commandLine){
    
    if (! is_null($commandLine)){
        return $commandLine;
    }else
    echoWithColor ("Erreur, commande inexistante", COLOR_LIGHT_MAGENTA);
    echo PHP_EOL;
}

// function lireRepertoire(string $path): void
// {
//     if (is_dir($path)) {
//         $dirHandle = opendir($path);
//         while (($item = readdir($dirHandle)) != false) {
//             if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
//                 $fichierAvecChemin = $path . "/" . $item;
//                 if (is_dir($fichierAvecChemin)) {
//                     echo ("- r : " . $fichierAvecChemin . "\n\n");
//                     lireRepertoire($fichierAvecChemin);
//                 } else {
//                     echo ("- f : " . $fichierAvecChemin . "\n");
//                 }
//             }
//         }
//         closedir($dirHandle);
//     } else {
//         echo ("- f : " . $path . "\n");
//     }
// }

// 
// function calculPath($currentPath, $path) {
//     //si absolu
//     //deux windows ou linux
//     //si windows
    
//     $pattern = strpos(strtoupper($_SERVER['OS']), 'WINDOW') === 0?"#[a-z]:/?.*#i":"#/.*#";


//     if(preg_match($pattern ,$path)){
//         if(!file_exists($path)){
//             return false;
//         }
//         return $path;
//     }

//     $currentPath = str_replace("\\","/",$currentPath);
//     $path = str_replace("\\" ,"/",$path);

//     $partiesChemin = explode ("/",$path);
    
//     foreach ($partiesChemin as $partie) {
//         if(preg_match("#^\.{2}$#i",$partie)){
//             $currentPath = dirname ($currentPath);
//         }else if(!preg_match("#^\.?$#i",$partie)){
//             $currentPath .= "/".$partie;
//             $currentPath = str_replace("//","/",$currentPath);
//         }

        
//     }
//     if(!file_exists($currentPath)){
//         return false;
//     }
//     return $currentPath;
// }

// function afficherRep(string &$chemin){ // permet d'afficher les dossiers et sous dossiers jusqu'à arriver aux fichiers
//     $allFiles = [];
//     if (!preg_match("#[/\\\\]?\.\.?$#",$chemin)) {
//         if (is_dir($chemin)){
//             $dirContent = [];
//             $dirContent = scandir($chemin);
//             foreach ($dirContent as $elt) {
//                $allFiles = array_merge($allFiles, afficherRep($chemin."/".$elt));
//             }

//         } else if (is_file($chemin)){
//             $allFiles[] = $chemin;
//         }
//     }
//     return $allFiles;
// }
