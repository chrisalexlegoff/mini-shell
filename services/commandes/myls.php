<?php

function perms($filename)
{

    $perms = fileperms($filename);

    switch ($perms & 0xF000) {
        case 0xC000: // Socket
            $info = 's';
            break;
        case 0xA000: // Lien symbolique
            $info = 'l';
            break;
        case 0x8000: // Régulier
            $info = 'r';
            break;
        case 0x6000: // Block special
            $info = 'b';
            break;
        case 0x4000: // dossier
            $info = 'd';
            break;
        case 0x2000: // Caractère spécial
            $info = 'c';
            break;
        case 0x1000: // pipe FIFO
            $info = 'p';
            break;
        default: // Inconnu
            $info = 'u';
    }

    // Propriétaire
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
        (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));

    // Groupe
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
        (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));

    // Tout le monde
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
        (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));

    echoWithColor($info . " ", COLOR_WHITE);
}

function myls(string $path, array $command_options, array $command_args)
{
    $ls = array_diff(scandir($path), array('..', '.'));
    $cptItem = 0;
    if (!empty($command_args)) {
        $nouveauChemin = calculerChemin($path, $command_args[0]);
        if ($nouveauChemin === false) {
            echoWithColor("chemin invalide!!!!!\n", COLOR_RED);
        } else {
            $path = $nouveauChemin;
            $ls = array_diff(scandir($path), array('..', '.'));
    $cptItem = 0;
            foreach ($command_options as $option) {
                if (preg_match("#i#", $option)) {
                    $optionI = true;
                } else {
                    $optionI = false;
                }
            }
        }
        if (!empty($command_options)) {
            foreach ($command_options as $option) {
                switch ($option) {
                    case 'l':
                        foreach ($ls as $item) {
                            $items = stat($path . "/" . $item);
                            if (preg_match("#^[^.].+$#", $item)) {
                                $cptItem++;
                                if (getOs() == 'Windows') {
                                    echoWithColor($items[2] . " ", COLOR_WHITE);
                                    echoWithColor(date("d/m/Y H:i", $items[9] + 3600) . " ", COLOR_BLUE);
                                    echoWithColor($items[7] . " ", COLOR_WHITE);
                                    if ($optionI) {
                                        echoWithColor($items[1] . " ", COLOR_WHITE);
                                    }
                                    echoWithColor($item . PHP_EOL, COLOR_YELLOW);
                                }
                                if (getOs() == 'Linux') {
                                    if ($optionI) {
                                        echoWithColor($items[1] . " ", COLOR_WHITE);
                                    }
                                    perms($path . "/" . $item);
                                    echoWithColor($items[3] . " ", COLOR_LIGHT_MAGENTA);
                                    echo (posix_getpwuid($items[4])["name"] . " ");
                                    echo (posix_getgrgid($items[5])["name"] . " ");
                                    echoWithColor(date("M d H:i", $items[9] + 3600) . " ", COLOR_BLUE);
                                    echoWithColor($items[7] . " ", COLOR_WHITE);
                                    echoWithColor($item . PHP_EOL, COLOR_YELLOW);
                                }
                            }
                        }
                        break;
                    case 'i':
                        foreach ($ls as $item) {
                            $items = stat($path . "/" . $item);
                            if (preg_match("#^[^.].+$#", $item)) {
                                $cptItem++;
                                if (getOs() == 'Windows') {
                                    echoWithColor($items[2] . " ", COLOR_WHITE);
                                    echoWithColor(date("d/m/Y H:i", $items[9] + 3600) . " ", COLOR_BLUE);
                                    echoWithColor($items[7] . " ", COLOR_WHITE);
                                    echoWithColor($item . PHP_EOL, COLOR_YELLOW);
                                }
                                if (getOs() == 'Linux') {
                                    if (is_dir($path . "/" . $item)) {
                                        echoWithColor($items[1] . " ", COLOR_WHITE);
                                        echoWithColor($item . " ", COLOR_LIGHT_MAGENTA);
                                        $cptItem++;
                                    } else {
                                        echoWithColor($items[1] . " ", COLOR_WHITE);
                                        echoWithColor($item . " ", COLOR_YELLOW);
                                        $cptItem++;
                                    }
                                }
                            }
                        }
                        break;
                }
            }
        } elseif (empty($command_options)) {
            foreach ($ls as $item) {
                if (preg_match("#^[^.].+$#", $item)) {
                    $items = stat($path . "/" . $item);
                    if (preg_match("#^[^.].+$#", $item)) {
                        $cptItem++;
                        if (getOs() == 'Windows') {
                            echoWithColor($items[2] . " ", COLOR_WHITE);
                            echoWithColor(date("d/m/Y H:i", $items[9] + 3600) . " ", COLOR_BLUE);
                            echoWithColor($items[7] . " ", COLOR_WHITE);
                            echoWithColor($item . PHP_EOL, COLOR_YELLOW);
                        }
                        if (getOs() == 'Linux') {
                            if (is_dir($path . "/" . $item)) {
                                echoWithColor($item . " ", COLOR_LIGHT_MAGENTA);
                                $cptItem++;
                            } else {
                                echoWithColor($item . " ", COLOR_YELLOW);
                                $cptItem++;
                            }
                        }
                    }
                }
            }
        }
        if ($cptItem == 0) {
            echoWithColor(basename($path) . " est vide ", COLOR_MAGENTA);
        }
        echo (PHP_EOL);
    } else {
        foreach ($ls as $item) {
            $items = stat($path . "/" . $item);
            if (preg_match("#^[^.].+$#", $item)) {
                $cptItem++;
                if (getOs() == 'Windows') {
                    echoWithColor($items[2] . " ", COLOR_WHITE);
                    echoWithColor(date("d/m/Y H:i", $items[9] + 3600) . " ", COLOR_BLUE);
                    echoWithColor($items[7] . " ", COLOR_WHITE);
                    echoWithColor($item . PHP_EOL, COLOR_YELLOW);
                }
                if (getOs() == 'Linux') {
                    if (is_dir($path . "/" . $item)) {
                        echoWithColor($item . " ", COLOR_LIGHT_MAGENTA);
                        $cptItem++;
                    } else {
                        echoWithColor($item . " ", COLOR_YELLOW);
                        $cptItem++;
                    }
                }
            }
        }
    }
    if ($cptItem == 0) {
        echoWithColor(basename($path) . " est vide ", COLOR_MAGENTA);
    }
    echo (PHP_EOL);
}
