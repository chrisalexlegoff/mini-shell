<?php



function myps($command_options)
{
    foreach ($command_options as $command) {
        if ($command == 'a') {
            $optionA = " -a ";
        }
        if ($command == 'u') {
            $optionU = " -u ";
        }
        if ($command == 'x') {
            $optionX = " -x ";
        }
    }
    $osName = php_uname("a");
    if (preg_match("#Windows#", $osName)) {
        echo (shell_exec("tasklist"));
    }

    $osName = php_uname("a");
    if (preg_match("#Linux#", $osName)) {
        // echo (shell_exec("ps" . $optionA . $optionU . $optionX));

        $allProc = [];
        $repertoire = scandir("/proc");
        $repertoire = preg_filter("#^\d+$#", "$0", $repertoire);
        // var_dump($repertoire);
        foreach ($repertoire as $pid) {
           
            $processusEncours = [
                
                "PID" => intval($pid),
                "%CPU" => null,
                "MEM" => null,
                "VSZ" => null,
                "RSS" => null,
                "TTY" => "?",
                "STAT" => null,
                "START" => null,
                "TIME" => null
            ];
            
            
            $processusEncours["USER"] = shell_exec("ps -o uname= -p $pid"); 
            // shell_exec("sudo cp /proc/$pid/environ procTemp/");
            // shell_exec("sudo chmod 755 procTemp/environ");
            $tousLeFichierCmdLine = file("/proc/$pid/cmdline");
           
            // $tousLeFichierEnviron = file("procTemp/environ");
            $processusEncours["COMMAND"] = $tousLeFichierCmdLine[0];
        
            // $matches = [];
            
            // preg_filter("#^USER=(.+ )$#", $tousLeFichierEnviron[0], $matches);
        // var_dump($tousLeFichierEnviron[0]);
           

  

            $allProc[] = $processusEncours;
            $header = (array_keys($processusEncours));
            foreach ($header as $head) {
                echo($head . " ");
            }
            echo(PHP_EOL);
            foreach ($allProc as $processusEncours) {
                foreach ($processusEncours as $processus) {
                    print_r($processus . " ");
                }
                echo(PHP_EOL);
            }
        }
        // var_dump($allProc[2])
    }
}
