<?php
include 'Database.php';

$di = new \Phalcon\DI\FactoryDefault();

//Set up the database service
$di->set('db', function(){
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "root",
        "dbname" => "accounts"
    ));
});

$loader = new \Phalcon\Loader();
$loader->registerDirs(array(
    'apiModels/'
))->register();

$app = new Phalcon\Mvc\Micro();
$app->setDI($di);

$app->get('/api/outgoings', function ()
{
  $pdo = Database::connect();
  $app_list = array();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT * FROM outgoings ORDER BY id ASC';

  foreach ($pdo->query($sql) as $row) {
    array_push($app_list, array('id' => $row['id'], 'description' => $row['description'], 'quantity' => $row['quantity']));
  }

  Database::disconnect();
  echo json_encode($app_list);
});

$app->get('/api/outgoings/{id}', function ($id)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM outgoings where id = ?";
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);
  
  Database::disconnect();
  echo json_encode($data);
});


$app->post('/api/outgoings', function() use ($app) {
    $outgoings = json_decode($app->request->getRawBody());
    $phql = "INSERT INTO outgoings (id, description, quantity) VALUES (:id:, :description:, :quantity:)";
    $status = $app->modelsManager->executeQuery($phql, array(
        'id' => $outgoings->id,
        'description' => $outgoings->description,
        'quantity' => $outgoings->quantity
    ));

    //Comprueba si la operación ha ido bien
    if ($status->success() == true) {
        //$this->response->setStatusCode(201, "Created")->sendHeaders();
        $outgoings->id = $status->getModel()->id;
        $response = array('status' => 'OK', 'data' => $outgoings);
    } else {
        //Cambia el estado HTTP
        //$this->response->setStatusCode(409, "Conflict")->sendHeaders();

        //Envía el error a cliente
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response = array('status' => 'ERROR', 'messages' => $errors);
    }

    echo json_encode($response);
});

$app->delete('/api/outgoings/{id}', function ($id) use ($app) {
  $phql = "DELETE FROM outgoings WHERE id = :id:";
  $status = $app->modelsManager->executeQuery($phql, array(
    'id' => $id
  ));
    
  if ($status->success() == true) {
    $response = array('status' => 'OK');
  } else {
    //Change the HTTP status
    //$this->response->setStatusCode(409, "Conflict")->sendHeaders();

    //Envía el error a cliente
    $errors = array();
    foreach ($status->getMessages() as $message) {
      $errors[] = $message->getMessage();
    }
    
    $response = array('status' => 'ERROR', 'messages' => $errors);
  }

  echo json_encode($data);
});

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'This is crazy, but this page was not found!';
});

$app->handle();
?>