<?php
require(__DIR__ .'./vendor/autoload.php');

if (file_exists('.env'))
{
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

//info: pgsql:host={host};port={port};dbname={dbname};user={user};password={password}

$pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);
//'pgsql:host=ec2-54-208-233-243.compute-1.amazonaws.com;port=5432;dbname=dbce880i0cp286;user=pyhksezydzhbqn;password=f8f59e8898bc6b819052e79186e2fcf3bdd66301a45ba95dca0c0db0b5c47b4f'
$playlist_id = null;
$playlist_id = $_GET['id'];

if(is_null($playlist_id))
{
  header("Location: index.php");
}

$sql = "
SELECT tracks.name AS trackName, albums.title, tracks.composer,  tracks.unit_price, genres.name AS genreName
FROM tracks INNER JOIN playlist_track ON playlist_track.track_id = tracks.id INNER JOIN playlists ON playlists.id = playlist_track.playlist_id 
INNER JOIN genres ON genres.id = tracks.genre_id INNER JOIN albums ON albums.id = tracks.album_id
WHERE playlist_id = $playlist_id
";
/*
SELECT playlists.name as playlistName, tracks.name as trackName, genres.name as genreNames, 
albums.title as albumTitle, tracks.unit_price as price
-------------------------
SELECT *
FROM tracks
INNER JOIN playlist_track ON playlist_track.playlist_id = $playlist_id
WHERE tracks.id = playlist_track.track_id
*/

$statement = $pdo->prepare($sql); //creating a prepared statement for execution
$statement->execute();

//variable
$tracks = $statement->fetchAll(PDO::FETCH_OBJ);


?>

<table>
  <thead>
  <?php if (empty($tracks)) { ?>
    <tr>
    <?php 

    $sql = "SELECT playlists.name FROM playlists WHERE playlists.id = $playlist_id";
    $statement = $pdo->prepare($sql); //creating a prepared statement for execution
    $statement->execute();

    $playlistName = $statement->fetch(PDO::FETCH_ASSOC);
    
    foreach ($playlistName as $plName) :
    echo "No results for $plName"; //print out name of playlist
    endforeach;
    ?>
    </tr>
    <?php } else  {?>
    <tr>
      <th>Track Name</th>
      <th>Album title</th>
      <th>Artist Name</th>
      <th>Price</th>
      <th>Genre Name</th>
    </tr>
    <?php } ?>
  </thead>
  <tbody>
  <?php foreach ($tracks as $track) : ?>
    <tr>
    <?php foreach ($track as $value) : ?>
      <td>        
        <?php 
        if(empty($value))
        {
          echo "[empty]";
        }
        else{
          echo $value;
          }
          ?>
      </td>
      <?php endforeach ?>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>