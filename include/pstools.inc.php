<?php
  function PsExecute($command, $timeout = 60, $sleep = 2) {
        // First, execute the process, get the process ID

        $pid = PsExec($command);

        if( $pid === false )
            return false;

        $cur = 0;
        // Second, loop for $timeout seconds checking if process is running
        while( $cur < $timeout ) {
            sleep($sleep);
            $cur += $sleep;
            // If process is no longer running, return true;

           echo "\n ---- $cur ------ \n";

            if( !PsExists($pid) )
                return true; // Process must have exited, success!
        }

        // If process is still running after timeout, kill the process and return false
        PsKill($pid);
        return false;
    }

    function PsExec($commandJob) {

        $command = $commandJob.' > /dev/null 2>&1 & echo $!';
        exec($command ,$op);
        $pid = (int)$op[0];

        if($pid!="") return $pid;

        return false;
    }

    function PsExists($pid) {

        exec("ps ax | grep $pid 2>&1", $output);

        while( list(,$row) = each($output) ) {

                $row_array = explode(" ", $row);
                $check_pid = $row_array[0];

                if($pid == $check_pid) {
                        return true;
                }

        }

        return false;
    }

    function PsKill($pid) {
        exec("kill -9 $pid", $output);
    }
?>
