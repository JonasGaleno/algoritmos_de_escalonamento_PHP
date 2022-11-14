<?php

function hiperPeriodo($processos, $qtd){
    $temp = 0;

    for($i = 0; $i < $qtd; $i++){
        if($processos[$i][3] > $temp){
            $temp = $processos[$i][3];
        }
    }

    return $temp;
}

function escolherMenorDeadline($qtd, $deadlines){
    $menorDeadline = 10000;
    $escolhido = -1;

    for($i = 0; $i < $qtd; $i++){
        if($deadlines[$i] < $menorDeadline){
            $menorDeadline = $deadlines[$i];
            $escolhido = $i;
        }
    }

    return $escolhido;
}

function edf($processos, $qtd){
    $relogio = 0;

    for($i = 0; $i < $qtd; $i++){
        $deadlines[$i] = $processos[$i][2];
        $periodos[$i] = $processos[$i][3];
        $contador[$i] = 0;
    }

    echo '<pre>Processos<br>';
    print_r($processos);
    echo '<br>Deadlines<br>';
    print_r($deadlines);
    echo '<br>Periodos<br>';
    print_r($periodos);
    echo '</pre>';

    while(true){
        $escolhido = escolherMenorDeadline($qtd, $deadlines);
        echo '<br><br>Processo escolhido: '.$escolhido;

        if($periodos[$escolhido] >= $relogio){
            $relogio += $processos[$escolhido][1];

            echo '<br>Processo: P'.$escolhido.' executando...';
            echo '<br>Relogio: '.$relogio;
            echo '<br>Burst Time do Processo P'.$escolhido.': '.$processos[$escolhido][1];
            
            echo '<br>Deadline ANTERIOR do Processo : '.$deadlines[$escolhido];
            $deadlines[$escolhido] += $processos[$escolhido][3];
            echo '<br>Deadline do Processo P'.$escolhido.' Atualizada: '.$deadlines[$escolhido];
            $deadlines[$escolhido] += $processos[$escolhido][3];
            
            echo '<br>Periodo ANTERIOR do Processo: '.$periodos[$escolhido];
            $periodos[$escolhido] += $processos[$escolhido][3];
            echo '<br>Deadline do Processo P'.$escolhido.' Atualizada: '.$periodos[$escolhido];

            $contador[$escolhido] += 1;
        }

        if($relogio >= 20){
            break;
        }
    }

    for($i = 0; $i < $qtd; $i++){
        echo '<br><br>O Processo P'.$i.' executou '.$contador[$i].' vezes';
    }
}

$processos = array(
    array(0, 3, 7, 20),
    array(1, 2, 4, 5),
    array(2, 2, 8, 10)
);

$qtd = count($processos);

edf($processos, $qtd);