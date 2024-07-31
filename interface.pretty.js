
function addTeam() {
    var teamName = document.getElementById('teamName').value;
    var teamLocation = document.getElementById('teamLocation').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://student.csc.liv.ac.uk/sgadeshp/api.php/teams', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Team added successfully!');
        } else {
            alert('Error adding team. Please try again.');
        }
    };
    xhr.send(JSON.stringify({ name: teamName, location: teamLocation }));
}

function addPlayer() {
    var playerName = document.getElementById('playerName').value;
    var playerTeamId = document.getElementById('playerTeamId').value;
    var playerSurName = document.getElementById('playerSurName').value;
    var playerDOB = document.getElementById('playerDOB').value;
    var playerNationality = document.getElementById('playerNationality').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://student.csc.liv.ac.uk/sgadeshp/api.php/players/', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Player added successfully!');
        } else {
            alert('Error adding player. Please try again.');
        }
    };





    xhr.send(JSON.stringify({ name: playerName, team_id: playerTeamId, given_names: playerSurName, surname: playerSurName, 
        date_of_birth: playerDOB, nationality: playerNationality }));
}

function getPlayerDetails() {
    var playerId = document.getElementById('playerId').value;
    var xhr = new XMLHttpRequest();
    // alert(playerId)
    xhr.open('GET', 'http://student.csc.liv.ac.uk/sgadeshp/api.php/players/' + playerId, true);
    xhr.onload = function () {
        var playerDetailsDiv = document.getElementById('playerDetails');
        if (xhr.status === 200) {
            var player = JSON.parse(xhr.responseText);
            // alert(player)
            playerDetailsDiv.innerHTML = 
            '<strong>Name:</strong> ' + player.name + 
            '<br><strong>Surname:</strong> ' + player.surname + 
            '<br><strong>Team ID:</strong> ' + player.team_id + 
            '<br><strong>DOB:</strong> ' + player.date_of_birth +
            '<br><strong>Given Name:</strong> ' + player.given_names + 
            '<br><strong>Nationality:</strong> ' + player.nationality
            ;
        } else {
            playerDetailsDiv.innerHTML = 'Player not found.';
        }
    };
    xhr.send();
}
