<?php

//inclusion services
include_once "../projet_mini_shell_christophe_philippe/services/commandes/myps.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/myhelp.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/mypwd.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/mycp.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/mycd.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/myls.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/myrm.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/mymv.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/myfind.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/mytail.php";
include_once "../projet_mini_shell_christophe_philippe/services/commandes/Commands.php";

// Inclusion lib
include_once "../projet_mini_shell_christophe_philippe/services/helpers/helpers.php";

$path = getcwd();

echoWithColor("-------------------------- mini shell philippe et christophe -----------------------------------------" . PHP_EOL, COLOR_BLUE);
echoWithColor(php_uname('a') . PHP_EOL, COLOR_YELLOW);
while (true) {
    $Line = readlineWithColor($path."> ", COLOR_BLUE);
    analyseCommande($Line, $commandLine, $command_args, $command_options, $est_decoupage_options = true);
    switch (strtolower($commandLine)) {
        case "mycp":
            mycp($command_options, $command_args[0] , $command_args[1]);
        break;
        case "mypwd":
            mypwd($path);
        break;
        case "myhelp":
            myhelp($commandLine);
        break;
        case "myfind":
            analyseCommande($Line, $commandLine, $command_args, $command_options, $est_decoupage_options = false);
            myfind($path, $command_args[0], $command_options);
        break;
        case "mytail":
            analyseCommande($Line, $commandLine, $command_args, $command_options, $est_decoupage_options = false);
            mytail($path, $command_args, $command_options); 
        break;   
        break;
        case "mymv":
            mymv($command_options, $command_args[0] , $command_args[1]);
        break;
        case "myps":
            myps($command_options);
        break;
        case "mycd":
            mycd($path, $command_args[0]);
        break;
        case "myrm":
            myrm($command_options, $command_args[0]);
        break;
        case "myls":
            myls($path, $command_options, $command_args);
        break;
        case "exit":
            echoWithColor("Au revoir!", COLOR_MAGENTA);
            break 2;
        case "myfind":
            analyseCommande($Line, $commandLine, $command_args, $command_options, $est_decoupage_options = false);
            // myfind($path, $command_args[0], $command_options);
        break;
        default: 
            echoWithColor("Commande inconnue : \n", COLOR_LIGHT_RED);
            $choix=strtolower(readlineWithColor("Souhaitez-vous afficher la liste des commandes disponibles pour le MiniShell ? o/n ",COLOR_BLUE));
            switch ($choix) {
                case "n":
                    break;  
                case "o":  
                    myhelp($commandLine); 
            }
    }
}
