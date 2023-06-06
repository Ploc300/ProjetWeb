<?php
include_once "Library\jpgraph-4.4.1\src\jpgraph.php";
include_once "Library\jpgraph-4.4.1\src\jpgraph_bar.php";
# Get logs into an arry ===========================================
function getLogs()
{
    $logs = array();
    $file_success = fopen("logs/success.log", "r");
    $file_failed = fopen("logs/failed.log", "r");
    while (!feof($file_success)) {
        $line = fgets($file_success);
        if ($line != "") {
            $email = explode(" de ", $line)[0];
            $ip = explode(" à ", explode(" de ", $line)[1])[0];
            $date = explode(" à ", $line)[1];
            $logs[] = array("email" => $email, "ip" => $ip, "date" => $date, "success" => true);
        }
    }
    fclose($file_success);
    while (!feof($file_failed)) {
        $line = fgets($file_failed);
        if ($line != "") {
            $email = explode(" de ", $line)[0];
            $ip = explode(" à ", explode(" de ", $line)[1])[0];
            $date = explode(" à ", $line)[1];
            $logs[] = array("email" => $email, "ip" => $ip, "date" => $date, "success" => false);
        }
    }
    fclose($file_failed);
    return $logs;
    // $logs return example:
    //     [0]=>
    //   array(4) {
    //     ["email"]=>
    //     string(12) "admin@iut.fr"
    //     ["ip"]=>
    //     string(3) "::1"
    //     ["date"]=>
    //     string(36) "Friday 19th of May 2023 03:04:20 PM"
    //     ["success"]=>
    //     bool(true)
    //   }
    //   [1]=>
    //   array(4) {
    //     ["email"]=>
    //     string(12) "admin@iut.fr"
    //     ["ip"]=>
    //     string(3) "::1"
    //     ["date"]=>
    //     string(36) "Friday 19th of May 2023 03:05:41 PM"
    //     ["success"]=>
    //     bool(true)
    //   }
}

function getIPOccurences($logs)
{
    $ipOccurrences = array();
    foreach ($logs as $log) {
        if (isset($ipOccurrences[$log['ip']])) {
            $ipOccurrences[$log['ip']]++;
        } else {
            $ipOccurrences[$log['ip']] = 1;
        }
    }
    return $ipOccurrences;
}

function afficheGraphsLogs($logs)
{
    $ipOccurrences = getIPOccurences($logs);

    $ipAddresses = array();
    $occurrences = array();

    foreach ($ipOccurrences as $ip => $count) {
        $ipAddresses[] = $ip;
        $occurrences[] = $count;
    }

    $graph = new Graph(400, 400);
    $graph->SetScale("textlin");

    $graph->title->Set("IP Occurrences");

    $barPlot = new BarPlot($occurrences);

    $barPlot->SetFillColor("#00bfff");
    $barPlot->SetColor("#000000");

    $graph->Add($barPlot);

    $graph->xaxis->SetTickLabels($ipAddresses);

    $graph->yaxis->title->Set("Number of Occurrences");
    $graph->xaxis->title->Set("IP Addresses");
    $graph->xaxis->SetLabelAlign("center");

    ob_start();
    $graph->Stroke();
    ob_get_clean();
    $graph->img->Stream(_IMG_AUTO);
}



?>