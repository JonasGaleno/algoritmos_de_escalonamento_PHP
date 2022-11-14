<?php
// ROUND-ROBIN
function roundRobin($processos, $quantum, $qtdProcessos){
    // Tempo total que será adicionado ao WaitingTime
    $tempo = 0;
    // Valor hipotetico para o tempo gasto na troca de contexto entre processos
    $overHead = 1;
    
    // Copiando BurstTime dos processos para o btRestante
    // Criando uma lista de Waiting Time
    for($i = 0; $i < $qtdProcessos; $i++){
        $btRestante[$i] = $processos[$i][2];
        $wt[$i] = 0;
    }

    while (true){
        $finalizados = true;
        
        for($i = 0; $i < $qtdProcessos; $i++){
            // Para cada troca de contexto entre os processos, Adicionar ao Tempo Total
            $tempo += $overHead;
            
            // Finalizados
            if($btRestante[$i] > 0){
                $finalizados = false;

                // Se o tempo restante for maior que Quantum 
                if($btRestante[$i] > $quantum){
                    // Somar quantum ao tempo de processamento
                    $tempo += $quantum;
                    // Retirar do BurstTime restante o Tempo(quantum) que ja foi processado
                    $btRestante[$i] -= $quantum;
                }else{
                    //  Caso o tempo restante seja menor que quantum somar ao tempo, o tempo restante de bt
                    $tempo += $btRestante[$i];
                    // WaitingTime = tempo_total - burst_time do processo
                    $wt[$i] = $tempo - $processos[$i][2];
                    //  Zerando burst time
                    $btRestante[$i] = 0;
                }
            }
        }

        if($finalizados == true){
            break;
        }
    }

    return $wt;
}

function turnArroundTime($processos, $wt, $qtdProcessos){
    for($i = 0; $i < $qtdProcessos; $i++){
        $tat[$i] = $processos[$i][2] + $wt[$i];
    }

    return $tat;
}

function averageTat($tat, $qtdProcessos){
    $turnArroundTime = array_sum($tat);
    return ($turnArroundTime/$qtdProcessos);
}

function averageWt($wt, $qtdProcessos){
    $waitingTime = array_sum($wt);
    return ($waitingTime/$qtdProcessos);
}


$processos = [];
$qtdProcessos = rand(1, 10);
$quantum = rand(1, 10);

echo "A quantidade de processos é ".$qtdProcessos;
echo "<br><br>O Quantum é ".$quantum;

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

// Waiting Time
$wt = roundRobin($processos, $quantum, $qtdProcessos);
// TurnAround Time
$tat = turnArroundTime($processos, $wt, $qtdProcessos);
// Média de todos os TurnAround Time
$avgTat = averageTat($tat, $qtdProcessos);
// Média de todos os Waiting Time
$avgWt = averageWt($wt, $qtdProcessos);

echo "<pre>WT = <br>";
print_r($wt);
echo "</pre>";

echo "<pre>TAT = <br>";
print_r($tat);
echo "</pre>";

echo "<br>AVG_TAT = ".$avgTat."<br>AVG_WT = ".$avgWt."<br><br>";

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
        </tr>";
}

$table .= $tr."</table>";

echo $table;
echo "<br><br>Average Waiting Time : ".$avgWt;
echo "<br>Average Turn-Around Time : ".$avgTat;