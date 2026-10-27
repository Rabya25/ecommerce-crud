<?php
declare(strict_types=1);

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

echo "connected to database!";

if(($_GET['action'] ?? '') === 'delete'){
    $id = (int)($_GET['id']?? 0);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute(['id'=>$id]);
    header('Location: products.php');
    exit;
    }


if(($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'){
    $action = $_POST['action'] ?? '';
    $name = $_POST['name'] ?? '';
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);

 if( $action === 'create'){
    $stmt = $pdo->prepare(
        "INSERT INTO products(name, price, stock) 
           VALUES(:name, :price, :stock)"
     );
     $stmt->execute(['name' => $name, 'price' => $price, 'stock' => $stock]);
 }elseif( $action === 'update'){
      $id = (int)($_POST['id'] ?? 0);
    $stmt = $pdo->prepare(
        "UPDATE products SET name = :name, price =:price, stock = :stock 
          WHERE id = :id"
    );
    $stmt->execute([
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
        'id' => $id             
    ]);
 } 
  header('Location: products.php');
  exit;
}

$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();

$editing = null;

if(($_GET['action'] ?? '') === 'edit'){
    $editId = (int)($_GET['id'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id =:id");
    $stmt->execute(['id'=>$editId]);
    $editing = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Products</title>
  </head>
  <body>
    <h1>Products</h1>
    <form method='POST'>
        <input type="text" name="name"  value="<?= $editing['name'] ?? '' ?>">
        <input type="number" name="price" value="<?= $editing['price'] ?? '' ?>">
        <input type="number" name="stock" value="<?= $editing['stock'] ?? '' ?>">

        <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
        <input type="hidden" name="id" value="<?= $editing['id'] ?? '' ?>">

        <button type="submit"><?= $editing ? 'Save Changes' : 'Add Product' ?></button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= $product['name']?></td>
                <td>$<?= $product['price']?></td>
                <td><?= $product['stock']?></td>
                <td>
                   <a href="products.php?action=edit&id=<?= $product['id']?>">Edit</a> 
                   <a href="products.php?action=delete&id=<?= $product['id']?>"
                   onclick="return confirm('Delete?')"
                   >Delete</a>  
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  </body>

</html>