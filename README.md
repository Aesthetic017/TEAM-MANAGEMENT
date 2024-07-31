Project Overview
This project is a web service designed to manage information about teams and their players for a chosen team-based sport. The service is implemented using PHP with MySQL for database management, using the PHP Data Objects (PDO) extension for database interactions. Additionally, a minimalistic user interface is provided for testing and interacting with the web service.

Project Structure
Database: MySQL database to store team and player information.
Backend: PHP scripts to handle API requests.
Frontend: Minimalistic HTML/JavaScript interface for testing the web service.
Database Schema
Tables
Teams

id (INT, Primary Key, Auto Increment)
name (VARCHAR)
sport (VARCHAR)
average_age (FLOAT)
Players

id (INT, Primary Key, Auto Increment)
team_id (INT, Foreign Key references Teams.id)
surname (VARCHAR)
given_names (VARCHAR)
nationality (VARCHAR)
date_of_birth (DATE)
Initial Data
Teams: Three teams with example names and sports.
Players: Three players per team with their respective details.
Web Service API
Endpoints
Retrieve information on all teams

Method: GET
Endpoint: /teams
Response: JSON list of teams with a link to each team's players.
Retrieve information on all players of a specific team

Method: GET
Endpoint: /teams/{teamId}/players
Response: JSON list of players for the specified team.
Retrieve information on a specific player of a team

Method: GET
Endpoint: /teams/{teamId}/players/{playerId}
Response: JSON details of the specified player.
Add a player to a team

Method: POST
Endpoint: /teams/{teamId}/players
Request Body: JSON object with player details.
Response: JSON confirmation of the added player.
Delete an existing player from a team

Method: DELETE
Endpoint: /teams/{teamId}/players/{playerId}
Response: JSON confirmation of the deletion.
Update information for an existing player of a team

Method: PUT
Endpoint: /teams/{teamId}/players/{playerId}
Request Body: JSON object with updated player details.
Response: JSON confirmation of the updated player.
Error Handling
Proper error responses for invalid requests, such as non-existing resources or invalid data formats.
User Interface
Description
The interface is a simple web page with the following elements:

Dropdown Menu: Select HTTP method (GET, POST, PUT, DELETE).
Text Field: Enter the resource URL.
Text Area: Enter JSON request body (for POST and PUT requests).
Send Button: Trigger the request.
Response Area: Display HTTP status code and response body.
Clear Button: Clear the response area.
