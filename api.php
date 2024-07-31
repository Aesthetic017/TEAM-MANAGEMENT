<?php

// Database credentials
$host = 'studdb.csc.liv.ac.uk';
$dbname = 'sgadeshp';
$username = 'sgadeshp';
$password = 'aesthe25A';

// Create a PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Define base URL
$base_url = 'http://student.csc.liv.ac.uk/sgadeshp/';

// Set response headers
header('Content-Type: application/json');

// Get the HTTP method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Get the request URI
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

// Get the resource (teams or players)
$resource = array_shift($request);

// Get the ID from the request, if any
$id = array_shift($request);

// Check which resource is requested
switch ($resource) {
    case 'teams':
        // Handle CRUD operations for teams

        switch ($method) {
            case 'GET':
                // Retrieve all teams
                $stmt = $pdo->query("SELECT * FROM teams");
                $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($teams);
                break;
            case 'POST':
                // Add a Team
                $data = json_decode(file_get_contents('php://input'), true);

        
                    if (isset($data['name'])) {
                        $name = $data['name'];
                        $average_Age = $data['average_Age'];
                        $sport = $data['sport'];
                        $stmt = $pdo->prepare("INSERT INTO `teams`(`name`, `sport`, `average_age`) VALUES 
                        ('$name','$sport','$average_Age')");
                        $stmt->execute([$data['name'], $data['team_id']]);
                        echo json_encode(['message' => 'Team added']);
                    } else {
                        http_response_code(404); // Not Found
                        echo json_encode(['error' => 'Team not found']);
                    }
               
                break;
            default:
                http_response_code(405); // Method Not Allowed
                echo json_encode(['error' => 'Method Not Allowed']);
                break;
        }

        break;

    case 'players':
        // Handle CRUD operations for players

        switch ($method) {
            case 'GET':
                // Retrieve player details
                if ($id) {
                    $stmt = $pdo->prepare("SELECT * FROM players WHERE player_id = $id");
                    $stmt->execute([$id]);
                    $player = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($player) {
                        echo json_encode($player);
                    } else {
                        http_response_code(404); // Not Found
                        echo json_encode(['error' => 'Player not found']);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(['error' => 'Player ID not provided']);
                }
                break;


            case 'POST':
                // Add a player to a team
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['name']) && isset($data['team_id'])) {
                    // Check if team exists
                    $id  = $data['team_id'];
                    $stmt = $pdo->prepare("SELECT * FROM teams WHERE team_id = $id");

                    $stmt->execute([$data['team_id']]);
                    $team = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($team) {

                        $surname = $data['surname'];
                        $name = $data['name'];
                        $given_names = $data['given_names'];
                        $nationality = $data['nationality'];
                        $date_of_birth = $data['date_of_birth'];

                        $stmt = $pdo->prepare("INSERT INTO players (`team_id`, `name`,`surname`, `given_names`, 
                        `nationality`, `date_of_birth`) VALUES ('$id','$name', '$surname','$given_names','$nationality','$date_of_birth')");
                        $stmt->execute([$data['name'], $data['team_id']]);
                        echo json_encode(['message' => 'Player added']);
                    } else {
                        http_response_code(404); // Not Found
                        echo json_encode(['error' => 'Team not found']);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(['error' => 'Name or Team ID not provided']);
                }
                break;

            case 'PUT':
                // Update player details
                if ($id) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (isset($data['name']) && isset($data['team_id'])) {
                        // Check if player exists
                        $id = $data['team_id'];
                        $stmt = $pdo->prepare("SELECT * FROM players WHERE player_id = $id");
                        $stmt->execute([$id]);
                        $player = $stmt->fetch(PDO::FETCH_ASSOC);
                        // var_dump($player);
                        if ($player) {
                            // Check if team exists
                            $team_id  = $player['team_id'];
                            $stmt = $pdo->prepare("SELECT * FROM teams WHERE team_id = $team_id");
                            $stmt->execute([$data['team_id']]);
                            $team = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($team) {
                                $name = $data['name'];
                                // $id = $data['id'];
                                $surname = $data['surname'];
                                $given_names = $data['given_names'];
                                $nationality = $data['nationality'];
                                $date_of_birth = $data['date_of_birth'];
                                $stmt = $pdo->prepare("UPDATE players SET name = '$name',surname = '$surname', team_id = '$team_id' , given_names = '$given_names' ,
                                 nationality = '$nationality' , date_of_birth = '$date_of_birth'   WHERE player_id = $id");
                                $stmt->execute([$data['name'], $data['team_id'], $id]);
                                echo json_encode(['message' => 'Player updated']);
                            } else {
                                http_response_code(404); // Not Found
                                echo json_encode(['error' => 'Team not found']);
                            }
                        } else {
                            http_response_code(404); // Not Found
                            echo json_encode(['error' => 'Player not found']);
                        }
                    } else {
                        http_response_code(400); // Bad Request
                        echo json_encode(['error' => 'Name or Team ID not provided']);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(['error' => 'Player ID not provided']);
                }
                break;

            case 'DELETE':
                // Delete a player from a team
                if ($id) {
                    $stmt = $pdo->prepare("DELETE FROM players WHERE player_id = $id");
                    $stmt->execute([$id]);
                    echo json_encode(['message' => 'Player deleted']);
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(['error' => 'Player ID not provided']);
                }
                break;

            default:
                http_response_code(405); // Method Not Allowed
                echo json_encode(['error' => 'Method Not Allowed']);
                break;
        }

        break;

    default:
        // Invalid resource
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Invalid resource']);
        break;
}

// Close the database connection
$pdo = null;
