<?php

function myfind(string $path, string $command_args, $command_Options): void
{

    list($option)  =  $command_Options;
    if ($option == 'name') {

        echoWithColor(" - Recherche par nom de Fichier : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (is_dir($fichierAvecChemin)) {


                        //if (preg_match("#^.*".$command_args.".*$#i",$fichierAvecChemin)) {
                        //    echoWithColor(" - Directory : ". $fichierAvecChemin . "\n" ,COLOR_GREEN);}

                    } else {
                        if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                            echoWithColor(" - Nom de fichier : " . $fichierAvecChemin . "\n", COLOR_GREEN);
                        }
                    }
                }
            }
            closedir($dirHandle);
        } else {


            if (preg_match("#^.*" . $command_args . ".*$#i", $path)) {
                echoWithColor(" - Nom de fichier : " . $path . "\n", COLOR_GREEN);
            }
        }
    }

    if ($option == NULL) {

        echoWithColor(" - Recherche par défaut (option non précisée) de tous les Fichiers : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (is_dir($fichierAvecChemin)) {


                        //if (preg_match("#^.*".$command_args.".*$#i",$fichierAvecChemin)) {
                        //    echoWithColor(" - Directory : ". $fichierAvecChemin . "\n" ,COLOR_GREEN);}

                    } else {
                        echoWithColor(" - Nom de fichier : " . $fichierAvecChemin . "\n", COLOR_GREEN);
                    }
                }
            }
            closedir($dirHandle);
        } else {


            echoWithColor(" - Nom de fichier : " . $fichierAvecChemin . "\n", COLOR_GREEN);
        }
    }


    if ($option == 'type') {

        echoWithColor(" - Recherche par type de Fichier : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (!is_dir($fichierAvecChemin)) {

                        if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                            $type = filetype($fichierAvecChemin);
                            echoWithColor("- Fichier : " . $fichierAvecChemin . "  Type de Fichier : " . $type . "\n", COLOR_GREEN);
                        }
                    }
                }
            }


            closedir($dirHandle);
        } else {

            if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                $type = filetype($fichierAvecChemin);
                echoWithColor("- Fichier : " . $fichierAvecChemin . "  Type de Fichier : " . $type . "\n", COLOR_GREEN);
            }
        }
    }


    if ($option == 'size') {

        echoWithColor(" - Recherche par taille de Fichier : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (!is_dir($fichierAvecChemin)) {

                        if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                            $size = filesize($fichierAvecChemin);
                            echoWithColor("- Fichier : " . $fichierAvecChemin . "  Taille (octets) : " . $size . "\n", COLOR_GREEN);
                        }
                    }
                }
            }


            closedir($dirHandle);
        } else {

            if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                $size = filesize($fichierAvecChemin);
                echoWithColor("- Fichier : " . $fichierAvecChemin . "  Taille (octets) : " . $size . "\n",  COLOR_GREEN);
            }
        }
    }

    if ($option == 'atime') {

        echoWithColor(" - Recherche par date de dernier accès au Fichier : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (!is_dir($fichierAvecChemin)) {

                        if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                            $atime = fileatime($fichierAvecChemin);
                            echoWithColor("$fichierAvecChemin a été accédé le : " . date("F d Y H:i:s.", fileatime($fichierAvecChemin)), COLOR_GREEN);
                        }
                        echo "\n";
                    }
                }
            }


            closedir($dirHandle);
        } else {

            if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                $atime = fileatime($fichierAvecChemin);
                echoWithColor("$fichierAvecChemin a été accédé le : " . date("F d Y H:i:s.", fileatime($fichierAvecChemin)), COLOR_GREEN);
            }
            echo "\n";
        }
    }


    if ($option == 'mtime') {

        echoWithColor(" - Recherche par date de dernière modification du Fichier : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (!is_dir($fichierAvecChemin)) {

                        if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                            $mtime = filemtime($fichierAvecChemin);
                            echoWithColor("$fichierAvecChemin a été modifié le : " . date("F d Y H:i:s.", filemtime($fichierAvecChemin)), COLOR_GREEN);
                        }
                        echo "\n";
                    }
                }
            }


            closedir($dirHandle);
        } else {

            if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                $mtime = filemtime($fichierAvecChemin);
                echoWithColor("$fichierAvecChemin a été modifié le : " . date("F d Y H:i:s.", filemtime($fichierAvecChemin)), COLOR_GREEN);
            }
            echo "\n";
        }
    }


    if ($option == 'ctime') {

        echoWithColor(" - Recherche par date de création du Fichier : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (!is_dir($fichierAvecChemin)) {

                        if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                            $ctime = filectime($fichierAvecChemin);
                            echoWithColor("$fichierAvecChemin a été créé le : " . date("F d Y H:i:s.", filectime($fichierAvecChemin)), COLOR_GREEN);
                        }
                        echo "\n";
                    }
                }
            }


            closedir($dirHandle);
        } else {

            if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                $ctime = filectime($fichierAvecChemin);
                echoWithColor("$fichierAvecChemin a été modifié le : " . date("F d Y H:i:s.", filectime($fichierAvecChemin)), COLOR_GREEN);
            }
            echo "\n";
        }
    }


    if ($option == 'user') {

        echoWithColor(" - Recherche par User (propriétaire du fichier) : \n", COLOR_DEFAULT);

        if (is_dir($path)) {

            $dirHandle = opendir($path);
            while (($item = readdir($dirHandle)) != false) {
                if (!preg_match("#[/\\\\]?\.\.?$#", $item)) {
                    $fichierAvecChemin = $path . "/" . $item;
                    $fichierAveccommand_args = $command_args . "/" . $item;
                    if (!is_dir($fichierAvecChemin)) {

                        if (preg_match("#^.*" . $command_args . ".*$#i", $fichierAvecChemin)) {
                            $user = fileowner($fichierAvecChemin);
                            $user = posix_getpwuid($user);
                            //$filename = $fichierAvecChemin;
                            //print_r(posix_getgrgid(filegroup($filename)));

                            /*$iterator = new DirectoryIterator(dirname($fichierAvecChemin));
                $groupid  = $iterator->getGroup();
                echo 'Le dossier appartient au groupe ' . $groupid . "\n";
                print_r(posix_getgrgid($groupid));*/

                            /*$filename = $fichierAvecChemin;
                print_r(posix_getpwuid(fileowner($filename)));*/

                            // $filename = $fichierAvecChemin;
                            // print_r(filegroup($filename));

                            print_r($user);
                        }


                        //echoWithColor("- Fichier : ". $fichierAvecChemin . "  User : ". $user . "\n" , COLOR_GREEN); }

                    }
                }
            }


            closedir($dirHandle);
        } else {

            if (preg_match("#^.*" . $cosmmand_arg . ".*$#i", $fichierAvecChemin)) {
                //$user=fileowner  ( $fichierAvecChemin ) ;
                $user = fileowner($fichierAvecChemin);
                $user = posix_getpwuid($user);
                //$filename = $fichierAvecChemin;
                //print_r(posix_getgrgid(filegroup($filename))); }

                /*$iterator = new DirectoryIterator(dirname($fichierAvecChemin));
                $groupid  = $iterator->getGroup();
                echo 'Le dossier appartient au groupe ' . $groupid . "\n";
                print_r(posix_getgrgid($groupid));*/



                // $filename = $fichierAvecChemin;
                // print_r(fileowner($filename));}
                print_r($user);

                //echoWithColor("- Fichier : ". $fichierAvecChemin . "  User : ". $user . "\n" , COLOR_GREEN); }
            }
        }
    }
}
