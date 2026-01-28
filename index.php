<?php
session_start();

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if(!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

if(isset($_POST['add_to_cart'])){
    $_SESSION['cart'][] = ['name'=>$_POST['product_name'],'price'=>$_POST['product_price']];
}
if(isset($_POST['buy_now'])){
    $_SESSION['cart'] = [['name'=>$_POST['product_name'],'price'=>$_POST['product_price']]];
}
if(isset($_POST['add_to_wishlist'])){
    $_SESSION['wishlist'][] = ['name'=>$_POST['product_name'],'price'=>$_POST['product_price']];
}
if(isset($_POST['place_order'])){
    $_SESSION['cart'] = [];
    $success = true;
}
function total($c){$t=0;foreach($c as $i){$t+=$i['price'];}return $t;}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ShopHaus Luxury Fashion</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',sans-serif;background:#f8f5f2;color:#222}
header{position:fixed;top:0;width:100%;background:#fff;padding:18px 40px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;z-index:1000}
header h1{font-family:'Playfair Display',serif;font-size:26px;cursor:pointer}
header nav a{margin-left:25px;text-decoration:none;color:#333;font-weight:500}
.container{max-width:1300px;margin:auto;padding:120px 25px}
section{margin-bottom:100px}
h2{font-family:'Playfair Display',serif;font-size:36px;margin-bottom:25px}
.hero{height:90vh;background:url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d') center/cover no-repeat;display:flex;align-items:center;justify-content:center;color:white;text-align:center}
.hero h2{font-size:56px;background:rgba(0,0,0,.4);padding:20px 40px;border-radius:10px}
.products{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:40px}
.card{background:#fff;padding:20px;border-radius:10px;transition:.3s}
.card:hover{transform:translateY(-6px);box-shadow:0 10px 25px rgba(0,0,0,.08)}
.card img{width:100%;height:340px;object-fit:cover;border-radius:8px}
.price{color:#b76e79;font-weight:600;margin:10px 0}
.btn{padding:10px 14px;border:none;border-radius:4px;margin:5px 2px;cursor:pointer;font-size:14px}
.cart-btn{background:#222;color:#fff}
.buy-btn{background:#b76e79;color:#fff}
.box{background:#fff;padding:40px;border-radius:10px;box-shadow:0 5px 20px rgba(0,0,0,.05);line-height:1.9}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border-bottom:1px solid #ddd;text-align:left}
footer{text-align:center;padding:40px;background:#111;color:#fff;margin-top:60px}
</style>

<script>
function go(id){document.getElementById(id).scrollIntoView({behavior:'smooth'});}
</script>
</head>
<body>

<header>
<h1 onclick="go('home')">ShopHaus</h1>
<nav>
<a onclick="go('about')">About</a>
<a onclick="go('shop')">Shop</a>
<a onclick="go('wishlist')">Wishlist</a>
<a onclick="go('cart')">Cart</a>
<a onclick="go('checkout')">Checkout</a>
<a onclick="go('contact')">Contact</a>
</nav>
</header>

<div id="home" class="hero">
<h2>Timeless Fashion for Modern Living</h2>
</div>

<div class="container">

<section id="about" class="box">
<h2>Our Philosophy</h2>
<p>ShopHaus is built on the belief that fashion should be refined, timeless, and expressive...</p>
<p>We create collections that balance elegance and modern design, allowing you to move seamlessly from day to evening...</p>
<p>Every piece is selected with attention to fabric, tailoring, and silhouette...</p>
</section>

<section id="shop">
<h2>Featured Collection</h2>
<div class="products">
<?php
$items = [
["Wool Blend Coat","https://images.unsplash.com/photo-1539109136881-3be0616acf4b",220],
["Minimal Linen Shirt","https://images.unsplash.com/photo-1520975661595-6453be3f7070",85],
["Elegant Black Dress","https://images.unsplash.com/photo-1496747611176-843222e1e57c",160],
["Leather Crossbody Bag","https://images.unsplash.com/photo-1512436991641-6745cdb1723f",140],
["Tailored Trousers","https://images.unsplash.com/photo-1503341504253-dff4815485f1",120],
["Classic White Heels","https://images.unsplash.com/photo-1528701800489-20be3cce26f0",110]
];
foreach($items as $p){
echo "<div class='card'>
<img src='{$p[1]}'>
<h4>{$p[0]}</h4>
<div class='price'>€{$p[2]}</div>
<form method='post'>
<input type='hidden' name='product_name' value='{$p[0]}'>
<input type='hidden' name='product_price' value='{$p[2]}'>
<button name='add_to_cart' class='btn cart-btn'>Add to Cart</button>
<button name='buy_now' class='btn buy-btn'>Buy Now</button>
<button name='add_to_wishlist' class='btn'>Wishlist</button>
</form>
</div>";
}
?>
</div>
</section>

<section id="wishlist" class="box">
<h2>Your Wishlist</h2>
<?php if(empty($_SESSION['wishlist'])) echo "No items saved."; else {
echo "<table>";
foreach($_SESSION['wishlist'] as $w){ echo "<tr><td>{$w['name']}</td><td>€{$w['price']}</td></tr>"; }
echo "</table>";
} ?>
</section>

<section id="cart" class="box">
<h2>Your Cart</h2>
<?php if(empty($_SESSION['cart'])) echo "Cart is empty."; else {
echo "<table>";
foreach($_SESSION['cart'] as $c){ echo "<tr><td>{$c['name']}</td><td>€{$c['price']}</td></tr>"; }
echo "</table><h3>Total: €".total($_SESSION['cart'])."</h3>";
echo "<button class='btn cart-btn' onclick=\"go('checkout')\">Checkout</button>";
} ?>
</section>

<section id="checkout" class="box">
<h2>Checkout</h2>
<?php if(isset($success)) echo "<p>Order placed successfully!</p>";
elseif(empty($_SESSION['cart'])) echo "Your cart is empty.";
else { ?>
<form method="post">
<input required placeholder="Full Name"><br><br>
<input required placeholder="Email"><br><br>
<input required placeholder="Address"><br><br>
<button name="place_order" class="btn buy-btn">Place Order</button>
</form>
<?php } ?>
</section>

<section id="contact" class="box">
<h2>Contact Us</h2>
<p>Email: support@shophaus.com</p>
<p>Phone: +1 234 567 890</p>
</section>

</div>

<footer>
© <?=date("Y")?> ShopHaus — Luxury Fashion Redefined
</footer>

</body>
</html>
