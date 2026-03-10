<?php
    header("Content-Type: application/json");
    include '../config/connectiondb.php'; 
    include 'functions.php';
    
    try {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode(file_get_contents('php://input'), true);

        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $myQuery = $myPDO->prepare("SELECT * FROM matches WHERE id_match = :id");
                    $myQuery->execute([':id' => $_GET['id']]);
                    $result = $myQuery->fetch(PDO::FETCH_ASSOC);
                } else {
                    $sql = "SELECT m.*, t1.Club as name_team1, t2.Club as name_team2 
                            FROM matches m
                            JOIN partidos t1 ON m.id_team1 = t1.id
                            JOIN partidos t2 ON m.id_team2 = t2.id
                            ORDER BY m.match_date DESC";
                    $myQuery = $myPDO->prepare($sql);
                    $myQuery->execute();
                    $result = $myQuery->fetchAll(PDO::FETCH_ASSOC);
                }
                echo json_encode($result);
                break;
                
            case 'POST':
                $myQuery = $myPDO->prepare("
                    INSERT INTO matches (id_team1, id_team2, goals_team1, goals_team2, status, match_date) 
                    VALUES (:t1, :t2, 0, 0, 'pendiente', :mdate)
                ");
                $success = $myQuery->execute([
                    ':t1' => $data['id_team1'],
                    ':t2' => $data['id_team2'],
                    ':mdate' => $data['match_date']
                ]);
                echo json_encode(["message" => "Creado exitosamente"]);
                break;
            
            case 'PUT':
                $myPDO->beginTransaction(); // Iniciamos transacción
                
                $myQuery = $myPDO->prepare("
                    UPDATE matches 
                    SET goals_team1 = :g1, goals_team2 = :g2, status = 'finalizado'
                    WHERE id_match = :id
                ");
                
                $myQuery->execute([
                    ':g1' => $data['goals_team1'],
                    ':g2' => $data['goals_team2'],
                    ':id' => $data['id_match']
                ]);

                recalcularPosiciones($myPDO);
                
                $myPDO->commit(); // Guardamos cambios
                echo json_encode(["message" => "Resultado registrado y posiciones actualizadas"]);
                break;

            case 'DELETE':
                $myPDO->beginTransaction();
                
                $myQuery = $myPDO->prepare("DELETE FROM matches WHERE id_match = :id");
                $myQuery->execute([':id' => $data['id_match']]);

                recalcularPosiciones($myPDO);
                
                $myPDO->commit();
                echo json_encode(["message" => "Partido eliminado y tabla actualizada"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    } catch (Exception $e) {
        if ($myPDO->inTransaction()) $myPDO->rollBack();
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }

    // Movemos la función fuera del switch para mayor claridad
    
?>