
<?php
include "../inc/db.php";
include "../inc/function.php";
session_start();

if (isset($_POST['process'])) {

    
    $process = $_POST['process'];
   
    if ($process == "addToCart") {
        $id = $_POST["product_id"];

        $query = "SELECT * FROM products where product_id=$id";
        //
        $product = $db->query($query, PDO::FETCH_OBJ)->fetch();
        $product->count = 1;
        echo addToCart($product);
    } else if ($process == "removeCart") {

        $id = $_POST['product_id'];
        echo removeCart($id);
    }
    else if ($process == "incCount") {

        $id = $_POST['product_id'];
        echo incCount($id);
    }
    else if ($process == "decCount") {

        $id = $_POST['product_id'];
        echo decCount($id);
    }
}

function addToCart($item)
{
    if (isset($_SESSION['shopcart'])) {
        $shopcart = $_SESSION['shopcart'];
        $products = $shopcart['products'];
    } else {
        $products = array();
    }

    if (array_key_exists($item->product_id, $products)) {
        $products[$item->product_id]->count++;
    } else {
        $products[$item->product_id] = $item;
    }

    $totalPrice = 0;
    $totalCount = 0;
    foreach ($products as $product) {
        $product->total_price = $product->count * $product->price;
        $totalPrice = $totalPrice + $product->total_price;
        $totalCount = $totalCount + $product->count;
    }



    $summary['total_price'] = $totalPrice;
    $summary['total_count'] = $totalCount;

    $_SESSION['shopcart']['summary'] = $summary;
    $_SESSION['shopcart']['products'] = $products;

    return $totalPrice;

}

function removeCart($id)
{
    if (isset($_SESSION['shopcart'])) {
      
        $shopcart = $_SESSION['shopcart'];
        $products = $shopcart['products'];

        if (array_key_exists($id, $products)) unset($products[$id]);

        $totalPrice = 0;
        $totalCount = 0;
        foreach ($products as $product) {
            $product->total_price = $product->count * $product->price;
            $totalPrice = $totalPrice + $product->total_price;
            $totalCount = $totalCount + $product->count;
        }
    
    
    
        $summary['total_price'] = $totalPrice;
        $summary['total_count'] = $totalCount;
    
        $_SESSION['shopcart']['summary'] = $summary;
        $_SESSION['shopcart']['products'] = $products;
    
        return true;

    } 

    
}

function incCount($id)
{
    if (isset($_SESSION['shopcart'])) {
        $shopcart = $_SESSION['shopcart'];
        $products = $shopcart['products'];
    }

    if (array_key_exists($id, $products)) {
        $products[$id]->count++;
    } 

    $totalPrice = 0;
    $totalCount = 0;
    foreach ($products as $product) {
        $product->total_price = $product->count * $product->price;
        $totalPrice = $totalPrice + $product->total_price;
        $totalCount = $totalCount + $product->count;
    }



    $summary['total_price'] = $totalPrice;
    $summary['total_count'] = $totalCount;

    $_SESSION['shopcart']['summary'] = $summary;
    $_SESSION['shopcart']['products'] = $products;

    return true;
}

function decCount($id)
{
    if (isset($_SESSION['shopcart'])) {
        $shopcart = $_SESSION['shopcart'];
        $products = $shopcart['products'];
    }

    if (array_key_exists($id, $products)) {
        $products[$id]->count--;
        if($products[$id]->count <= 0) unset($products[$id]);
    } 

    $totalPrice = 0;
    $totalCount = 0;
    foreach ($products as $product) {
        $product->total_price = $product->count * $product->price;
        $totalPrice = $totalPrice + $product->total_price;
        $totalCount = $totalCount + $product->count;
    }



    $summary['total_price'] = $totalPrice;
    $summary['total_count'] = $totalCount;

    $_SESSION['shopcart']['summary'] = $summary;
    $_SESSION['shopcart']['products'] = $products;

    return true;
}



?>