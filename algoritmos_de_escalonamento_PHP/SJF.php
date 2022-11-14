<?php
function waitingTime($processos){
    // Definindo a qnt. tempo de servico baseado na qnt de processos
    // Definindo tamanho da waiting list
    for($i = 0; $i < count($processos); $i++){
        $tempoServico[$i] = 0;
        $wt[$i] = 0;
    }
    
    for($i = 1; $i < count($processos); $i++){
        $tempoServico[$i] = ($tempoServico[$i-1] + $processos[$i-1][2]);
        $wt[$i] = $tempoServico[$i] - $processos[$i][1];

        if($wt[$i] < 0){
            $wt[$i] = 0;
        }
    }

    return $wt; 
}

function turnArroundTime($processos){
    $tat = array();
    $wt = waitingTime($processos);

    for($i = 0; $i < count($processos); $i++){
        $tat[$i] = $processos[$i][2] + $wt[$i];
    }

    return $tat;
}

function averageTat($processos){
    $turnArroundTime = array_sum(turnArroundTime($processos));
    return ($turnArroundTime/count($processos));
}

function averageWt($processos){
    $waitingTime = array_sum(waitingTime($processos));
    return ($waitingTime/count($processos));
}

function SJF($processos){
    // Ordenando por Job(Burst time) mais curto
    for($i = 0; $i < count($processos); $i++){
        for($j = 0; $j < (count($processos) - 1); $j++){
            if($processos[$j][2] > $processos[$j+1][2]){
                $valor1 = $processos[$j];
                $valor2 = $processos[$j+1];
                $processos[$j] = $valor1;
                $processos[$j+1] = $valor2;
            }
        }
    }

    return $processos;
}

echo ":::::::::::::::::::::::::::::::::::SJF:::::::::::::::::::::::::::::::::::";

$processos = [];
$qtdProcessos = rand(1, 10);
echo "<br><br>A quantidade de processos é ".$qtdProcessos;

for($i = 0; $i < $qtdProcessos; $i++){
    // id do processo
    $pid = "P".$i;
    // Arrival Time
    $at = rand(1, 10);
    // Burst Time
    $bt = rand(1, 10);
    array_push($processos, array($pid, $at, $bt));
}

echo "<pre>Processos<br>";
print_r($processos);
echo "</pre>";

$wt = waitingTime($processos);
$tat = turnArroundTime($processos);
$avgTat = averageTat($processos);
$avgWt = averageWt($processos);

$estiloTable = "
        <style>
            table, th, td {
                border: 1px solid black;
            }

            table {
                border-collapse: collapse;
            }
        </style>";

$table = $estiloTable."
    <table>
        <tr>
            <th>Process</th>
            <th>Burst Time</th>
            <th>Arrival Time</th>
            <th>Waiting Time</th>
            <th>Turn-Around Time</th>
            <th>Completion Time</th>
        </tr>";
$tr = "";

for ($i = 0; $i  < count($processos); $i++) {
    $tr .= "
        <tr>
            <td>".$processos[$i][0]."</td>
            <td>".$processos[$i][2]."</td>
            <td>".$processos[$i][1]."</td>
            <td>".$wt[$i]."</td>
            <td>".$tat[$i]."</td>
            <td>".($tat[$i] + $processos[$i][1])."</td>
        </tr>";
}

$table .= $tr."</table>";

echo $table;

echo "<br><br>Average Waiting Time : ".$avgWt;
echo "<br>Average Turn-Around Time : ".$avgTat;

echo "<br><br>:::::::::::::::::::::::DEPOIS::::::::::::::::::::::";

$processos = SJF($processos);
$wt = waitingTime($processos);
$tat = turnArroundTime($processos);
$avgTat = averageTat($processos);
$avgWt = averageWt($processos);

echo "<pre>Processos<br>";
print_r($processos);
echo "</pre>";

$table = $estiloTable."
    <table>
        <tr>
            <th>Process</th>
            <th>Burst Time</th>
            <th>Arrival Time</th>
            <th>Waiting Time</th>
            <th>Turn-Around Time</th>
            <th>Completion Time</th>
        </tr>";
$tr = "";

for ($i = 0; $i  < count($processos); $i++) {
    $tr .= "
        <tr>
            <td>".$processos[$i][0]."</td>
            <td>".$processos[$i][2]."</td>
            <td>".$processos[$i][1]."</td>
            <td>".$wt[$i]."</td>
            <td>".$tat[$i]."</td>
            <td>".($tat[$i] + $processos[$i][1])."</td>
        </tr>";
}

$table .= $tr."</table>";

echo $table;

echo "<br><br>Average Waiting Time : ".$avgWt;
echo "<br>Average Turn-Around Time : ".$avgTat;