<?php

function mytail(string $path, array $command_args, $command_Options ): void
{
    list ($option)  =  $command_Options;

    if  ($option == 'n') {  

        echoWithColor(" - Affichage de xx dernières lignes du Fichier : \n" ,COLOR_DEFAULT);
    
        if (is_dir($path)) {
            
            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args[1] . "/" . $item;
                    if (!is_dir($fichierAvecChemin)) {
    
                        if (preg_match("#^.*".$command_args[1].".*$#i",$fichierAvecChemin)) {
                            $monfichier=fopen ("$fichierAvecChemin", "r");
                            $ligne=[];
                            while (!feof($monfichier)) {
                            $ligne[]=fgets($monfichier);
                            }
                            fclose($monfichier);

                            $nbLignes=count($ligne);
                            $nb=$command_args[0];

                            if ($command_args[0] == NULL) {
                                for ($i=$nbLignes;$i=($nbLignes-10);$i--)
                                echoWithColor("ligne : " .$ligne[$i] . "\n" , COLOR_GREEN);
                                
                            } else { for ($i=$nbLignes;$i=($nbLignes-$nb);$i--)
                                echoWithColor("ligne : " .$ligne[$i] . "\n" , COLOR_GREEN);


                            }
                
                    }
                        
                    } 
                }
    
        }
            closedir($dirHandle);
        } else {
    
    
            if (preg_match("#^.*".$command_args[1].".*$#i",$fichierAvecChemin)) {
                $monfichier=fopen ("$fichierAvecChemin", "r");
                $ligne=[];
                while (!feof($monfichier)) {
                $ligne[]=fgets($monfichier);
                }
                fclose($monfichier);

                $nbLignes=count($ligne);
                $nb=$command_args[0];
                $nbEdit=$nbLignes-$nb;

                if ($command_args[0] == NULL) {
                for ($i=$nbLignes;$i<=$nbEdit;$i--)
                echoWithColor("ligne : " .$ligne[$i] . "\n" , COLOR_GREEN);
                                
                } else { for ($i=$nbLignes;$i=($nbLignes-$nb);$i--)
                    echoWithColor("ligne : " .$ligne[$i] . "\n" , COLOR_GREEN);

                }
            }
        }
    } else {
    echoWithColor ("option 'n' obligatoire pour mytail ! \n",COLOR_RED);}
}
    

?>