<?php
//require(__DIR__ .'./vendor/autoload.php');
/* 
if (file_exists('.env))
{
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
*/
//info: pgsql:host={host};port={port};dbname={dbname};user={user};password={password}
//postgres://pyhksezydzhbqn:f8f59e8898bc6b819052e79186e2fcf3bdd66301a45ba95dca0c0db0b5c47b4f@ec2-54-208-233-243.compute-1.amazonaws.com:5432/dbce880i0cp286
$pdo = new PDO('pgsql:host={ec2-54-208-233-243.compute-1.amazonaws.com};port={5432};dbname={dbce880i0cp286};user={pyhksezydzhbqn};password={f8f59e8898bc6b819052e79186e2fcf3bdd66301a45ba95dca0c0db0b5c47b4f}');

// $pdo = new PDO('pgsql:host=ec2-54-208-233-243.compute-1.amazonaws.com;port=5432;dbname=d19pn8ipucoqlv;user=tudyzzncbblfmc;password=d91d99e2bfe09dc191bf99c4c85b14cd40cbba150423b2a108480af692bc5865');

$sql = "
SELECT id, invoice_data, total 
FROM invoices
INNER JOIN customers
ON invoices.customer_id = customer.id
";

$statement = $pdo->prepare($sql); //creating a prepared statement for execution
$statement->execute();

//variable
$invoices = $statement->fetchAll(PDO::FETCH_OBJ);

var_dump($invoices);
die();

//SELECT invoices.id, invoice_date, total
// FROM invoices
// INNER JOIN customers
// ON invoices.customer_id = customer.id
?>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Date</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($invoices as $invoice) : ?>
    <tr>
      <td>
        <?php echo $invoice->id ?>
      </td>
      <td>
        <?php echo $invoice->total ?>
      </td>
      <td>
        <?php echo $invoice->invoice_date ?>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>