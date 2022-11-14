<?php
// Calcular Waiting Time
function waitingTime($processos){
    // Definindo a quantidade tempos de servico de cada baseado na qnt. de processos
    for($i = 0; $i < count($processos); $i++){
        $tempoServico[$i] = 0;
        //  Definindo tamanho da waiting list
        $wt[$i] = 0;
    }
    // O tempo de servico é a soma de todos os BurstTime dos Processos anteriores
    $tempoServico[0] = 0;

    for($i = 1; $i < count($processos); $i++){
        $tempoServico[$i] = ($tempoServico[$i-1] + $processos[$i-1][1]);   
        $wt[$i] = $tempoServico[$i] - $processos[$i][0];

        if($wt[$i] < 0){
            $wt[$i] = 0;
        }
    }

    return $wt;
}

// Calcular Turn around Time
function turnArroundTime($processos){
    $wt = waitingTime($processos);

    for($i = 0; $i < count($processos); $i++){
        $tat[$i] = $processos[$i][1] + $wt[$i];
    }

    return $tat;
}

//  Calcular media do waiting time
function averageWt($processos){
    $qtdProc = count($processos);
    $wt = array_sum(waitingTime($processos));

    return ($wt/$qtdProc);
}

//  Calcular media do Turnaround time
function averageTat($processos){
    $qtdProc = count($processos);
    $tat = array_sum(turnArroundTime($processos));

    return ($tat/$qtdProc);
}

// Lista de todos os processos
$processos = array();
$qtdProcessos = 3;

echo "Quantidade de processos: ".$qtdProcessos;

for ($i = 0; $i < $qtdProcessos; $i++) { 
   $at = rand(1, 10);
   $bt = rand(1, 10);

   array_push($processos, array($at, $bt));
}

/*
Estrutura do Processo
    [ [arrival_time, burst_time] ]
*/

echo "<pre>Processos<br>";
print_r($processos);
echo "</pre>";

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
$wt = waitingTime($processos);
$tat = turnArroundTime($processos);
$avgWt = averageWt($processos);
$avgTat = averageTat($processos);

//  Completion Time = Turn Around Time + Arrival Time
for ($i = 0; $i  < count($processos); $i++) {
    $tr .= "
        <tr>
            <td>".$i."</td>
            <td>".$processos[$i][1]."</td>
            <td>".$processos[$i][0]."</td>
            <td>".$wt[$i]."</td>
            <td>".$tat[$i]."</td>
            <td>".($tat[$i] + $processos[$i][0])."</td>
        </tr>";
}

$table .= $tr."</table>";

echo $table;

echo "<br><br>Average Waiting Time : ".$avgWt;
echo "<br>Average Turn-Around Time : ".$avgTat;