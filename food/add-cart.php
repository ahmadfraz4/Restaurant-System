<?php include "../php/public/global/header.php" ?>
<?php include "../php/config/config.php" ?>
<?php include "../php/lib/App.php"; 

session_start();
if(!isset($_SESSION['user_id'])){
    header("location: ".APP_URL."/auth/login.php");
    exit;
}
$id = $_GET['id'];
$db = new App;
$food = $db->selectData("food",["id"=>$id])[0];



?>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
        <?php include "../php/public/global/navbar.php" ?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown"><?php echo $food['name'] ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Cart</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-12 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="<?php echo APP_URL; ?>/img/<?php echo $food['image'] ?>">
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h1 class="mb-4"><?php echo $food['name'] ?></h1>
                        <p class="mb-4"><?php echo $food['description'] ?></p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h3>Price: $ <?php echo $food['price'] ?></h3>                                   
                                </div>
                            </div>
                            
                        </div>
                        <button id="add-to-cart-button" onclick="ADD_TO_CART()" class="btn btn-primary py-3 px-5 mt-2" href="">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

      <!-- Footer Start -->
      <?php include "../php/public/global/footer.php" ?>
</body>
<script>
    const cartItem = JSON.parse(localStorage.getItem('cart'));
    const add_Cart_Btn = document.getElementById('add-to-cart-button');
    
    const id = <?php echo $_GET['id'] ?>;
       
    let itemFound = cartItem.find((item) => item.id == id);
    
    
    if(itemFound){
        add_Cart_Btn.disabled = true;
        add_Cart_Btn.innerText = 'ADDED TO CART';
    }else{
        add_Cart_Btn.innerText = 'ADD TO CART';
    }

    function ADD_TO_CART(){
        let confirmCart = window.confirm('Do you want to add item to cart');
        if(confirmCart){
            let cartData = [];

            if (localStorage.getItem('cart')) {
            cartData = JSON.parse(localStorage.getItem('cart'));
            }
            <?php 
                $jsonData = json_encode($food);
                echo "let foodData = " . json_encode($food) . ";";
            ?>
            let isItemExist;
            if(cartData && cartData.length > 0){
                isItemExist = cartData.find(item => JSON.stringify(item) === JSON.stringify(foodData));

            }

            if (!isItemExist) {
                // Add the new item to the cartData array
                cartData.push(foodData);

                // Store the updated cartData array in localStorage
                localStorage.setItem('cart', JSON.stringify(cartData));
            }

            const data = localStorage.getItem('cart');
            alert('item added to cart');
            add_Cart_Btn.disabled = true;
            add_Cart_Btn.innerText = 'ADDED TO CART';
        }
    }
</script>
</html>