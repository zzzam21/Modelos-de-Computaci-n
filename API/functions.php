<?php function recalcularPosiciones($pdo) {
    // 1. Resetear a cero
    $pdo->query("UPDATE partidos SET 
        played_games=0, wins=0, draws=0, lost=0, 
        goals_in_favor=0, goals_against=0, goals_diference=0, points=0");

    // 2. Traer partidos finalizados
    $matches = $pdo->query("SELECT * FROM matches WHERE status = 'finalizado'")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($matches as $m) {
        $t1 = $m['id_team1'];
        $t2 = $m['id_team2'];
        $g1 = (int)$m['goals_team1'];
        $g2 = (int)$m['goals_team2'];

        $p1 = 0; $w1 = 0; $d1 = 0; $l1 = 0;
        $p2 = 0; $w2 = 0; $d2 = 0; $l2 = 0;

        if ($g1 > $g2) { $p1 = 3; $w1 = 1; $l2 = 1; }
        elseif ($g1 < $g2) { $p2 = 3; $w2 = 1; $l1 = 1; }
        else { $p1 = 1; $p2 = 1; $d1 = 1; $d2 = 1; }

        // Actualizar Equipo 1 (Calculando la diferencia de goles matemáticamente)
        $sql1 = "UPDATE partidos SET 
            played_games = played_games + 1, wins = wins + $w1, draws = draws + $d1, lost = lost + $l1,
            goals_in_favor = goals_in_favor + $g1, goals_against = goals_against + $g2,
            goals_diference = (goals_in_favor ) - (goals_against ), 
            points = points + $p1 
            WHERE id = ?";
        $pdo->prepare($sql1)->execute([$t1]);

        // Actualizar Equipo 2
        $sql2 = "UPDATE partidos SET 
            played_games = played_games + 1, wins = wins + $w2, draws = draws + $d2, lost = lost + $l2,
            goals_in_favor = goals_in_favor + $g2, goals_against = goals_against + $g1,
            goals_diference = (goals_in_favor) - (goals_against), 
            points = points + $p2 
            WHERE id = ?";
        $pdo->prepare($sql2)->execute([$t2]);
    }
}
?>