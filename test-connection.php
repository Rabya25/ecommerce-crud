<?php
$pdo = new PDO(
  "mysql:host=localhost;dbname=ecomer;charset=utf8mb4",
  "root",
  "",
  [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]
);

echo "connected to the databse...\n";

// $stmt = $pdo->query("SELECT * FROM products;");
// $products = $stmt->fetchAll();
// foreach($products as $product){
//   echo $product['name'] . " - $" . $product['price'] . "\n";
// }

// $stmt = $pdo->prepare("SELECT * FROM products WHERE name = :name;");
// $stmt->execute(['name'=>'Laptop']);
// $prod = $stmt->fetch();
// if( $prod === false){
//   echo "product not found";
// }else {
//   echo $prod['name'] . " - $" . $prod['price'] . "\n";
// }

// $stmt = $pdo->prepare(
//   "INSERT INTO products(name, price, stock, category_id) 
//    VALUES(:name, :price, :stock, :category_id)"
//    );
// $stmt->execute([
//   'name' => 'Gaming Mouse',
//   'price' => 45.99,
//   'stock' => 15, 
//   'category_id' => 1,
//     ]);

// $newProd = $pdo->lastInsertId();
// echo $newProd . "\n";

// $stmt = $pdo->prepare(
//   "INSERT INTO products(name, price, stock, category_id) 
//   VALUES(:name, :price, :stock, :category_id)"
// );

// $stmt->execute([
//   'name' => 'Gaming mouse',
//   'price' => 45.99,
//   'stock' => 15,
//   'category_id' => 1,
// ]
// );

// $id = $pdo->lastInsertId();
// echo $id . "\n";

$stmt = $pdo->prepare("DELETE FROM products WHERE name = :name");
$stmt->execute(['name'=>'Gaming mouse']);
$affected = $stmt->rowCount();
echo $affected . "\n";