<?php
require(__DIR__ .'/vendor/autoload.php');

if (file_exists(__DIR__ .'/.env'))
{
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

//info: pgsql:host={host};port={port};dbname={dbname};user={user};password={password}

$pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);
//'pgsql:host=ec2-54-208-233-243.compute-1.amazonaws.com;port=5432;dbname=dbce880i0cp286;user=pyhksezydzhbqn;password=f8f59e8898bc6b819052e79186e2fcf3bdd66301a45ba95dca0c0db0b5c47b4f'

$sql = "
SELECT *
FROM playlists
";
// INNER JOIN customers
//ON invoices.customer_id = customer.id
$statement = $pdo->prepare($sql); //creating a prepared statement for execution
$statement->execute();

//variable
$playlists = $statement->fetchAll(PDO::FETCH_OBJ);

//get tracks?


?>

<table>
  <thead>
    <tr>
      <th>Playlist Name</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($playlists as $playlist) : ?>
    <tr>
      <td>
        <?php echo $playlist->id ?>
      </td>
      <td>
        <a href='tracks.php?id=<?php echo $playlist->id ?>''>
          <?php echo $playlist->name ?>
        </a>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>