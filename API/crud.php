<?php
    header ("Content-Type: application/json");
    include '../config/connectiondb.php';
    
    try {
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode(file_get_contents('php://input'), true);

        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {

                    $myQuery = $myPDO->prepare("SELECT * FROM partidos WHERE id = :id");

                    if (!$myQuery->execute([':id' => $_GET['id']])){
                        throw new Exception("Error al ejecutar: ". implode(", ", $myQuery->errorInfo()));
                    }

                    $result = $myQuery->fetch(PDO::FETCH_ASSOC);

                } else {

                    $myQuery = $myPDO->prepare("SELECT * FROM partidos ORDER BY points DESC, goals_diference DESC, goals_in_favor DESC");
                
                    if (!$myQuery->execute()) {
                        throw new Exception("Error al ejecutar: " . implode(", ", $myQuery->errorInfo()));
                    }
                    $result = $myQuery->fetchAll(PDO::FETCH_ASSOC);

                }

                
                echo json_encode($result);
                break;
                
            case 'POST':

                $myQuery = $myPDO->prepare("
                    INSERT INTO partidos (Club, logo) 
                    VALUES (:club, :logo_url)
                ");

                $success = $myQuery->execute([
                    ':club' => $data['clubName'],
                    ':logo_url' => $data['logoUrl']
                ]);

                if (!$success) {
                    throw new Exception("Error SQL: " . implode(", ", $myQuery->errorInfo()));
                }

                http_response_code(201);
                echo json_encode(["message" => "Equipo agregado correctamente"]);

                break;
            
            case 'PUT':

                $myQuery = $myPDO->prepare("
                    UPDATE partidos 
                    SET 
                    Club = :club, 
                    logo = :logo, 
                    played_games = :played, 
                    wins = :wins,
                    draws = :draws, 
                    lost = :lost, 
                    goals_in_favor = :goals_in_favor, 
                    goals_against = :goals_against, 
                    goals_diference = :goals_diference, 
                    points = :points
                    WHERE id = :id");
                
                $success = $myQuery->execute([
                    ':club' => $data['clubName'],
                    ':logo' => $data['logoUrl'],
                    ':played' => $data['played_games'],
                    ':wins' => $data['wins'],
                    ':draws' => $data['draws'],
                    ':lost' => $data['lost'],
                    ':goals_in_favor' => $data['goals_in_favor'],
                    ':goals_against' => $data['goals_against'],
                    ':goals_diference' => $data['goals_diference'],
                    ':points' => $data['points'],
                    ':id' => $data['id']
                ]);

                if (!$success) {
                    throw new Exception("Error SQL: " . implode(", ", $myQuery->errorInfo()));
                }

                http_response_code(200);
                echo json_encode(["message" => "Equipo actualizado correctamente"]);

                break;

            case 'DELETE':
                // Aquí iría la lógica para eliminar un equipo
                $myQuery = $myPDO->prepare("DELETE FROM partidos WHERE id = :id");
                $success = $myQuery->execute([':id' => $data['id']]);

                if (!$success) {
                    throw new Exception("Error SQL: " . implode(", ", $myQuery->errorInfo()));
                }

                http_response_code(200);
                echo json_encode(["message" => "Equipo eliminado correctamente"]);

                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
            
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
?>
