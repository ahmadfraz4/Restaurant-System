<?php include "./php/public/global/header.php";
if(session_status() === PHP_SESSION_NONE){
  session_start();
}
if(!isset($_SESSION['user_id'])){
  header("location: ".APP_URL.'/auth/login.php');
}
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
      <?php include "./php/public/global/navbar.php" ?>

      <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
          <h1 class="display-3 text-white mb-3 animated slideInDown">Cart</h1>
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
    <div class="container">

      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Price</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody id="table-body">
          </tbody>
        </table>
        <div class="position-relative mx-auto" style="max-width: 400px; padding-left: 679px;">
          <p style="margin-left: -7px;" class="d-flex py-3 ps-4 pe-5" type="text"> <span>Total: </span> $ <span id="price"> 0</span></p>
          
            <button type="button" id="submit_button" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">Checkout</button>
          
        </div>
      </div>
    </div>
    <!-- Service End -->


    <!-- Footer Start -->
    <?php include "./php/public/global/footer.php" ?>
</body>
<script>
  let check_out_price;
  let tableBody = document.getElementById('table-body');
  let cart;
  if (localStorage.getItem('cart')) {

     cart = JSON.parse(localStorage.getItem('cart'));

    renderCart(cart);

    function renderCart(cart){
      tableBody.innerHTML = '';
        cart.forEach((item, index) => {
        let tr = document.createElement('tr');
        let td1 = document.createElement('td');
        let td2 = document.createElement('td');
        let td3 = document.createElement('td');
        let td4 = document.createElement('td');

        let img = document.createElement('img');
        img.src= `<?php echo APP_URL; ?>/uploads/${item.image}`;

        let delBtn = document.createElement('button');
        delBtn.classList.add('btn', 'btn-danger', 'text-white');
        delBtn.innerText = "Delete"
        delBtn.onclick = () => {
          handleClick(item.id)
        };

        // td.appendChild(img);
        td1.innerHTML = item.name;
        td2.innerHTML = item.price;
        td3.appendChild(delBtn);
        td4.appendChild(img);

        tr.appendChild(td4);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tableBody.appendChild(tr);
      })
      
      let total = 0;
      cart.forEach((item,index)=>{
        total += Number(item.price);
      })
      document.getElementById("price").innerText = total;
      check_out_price = total;
    }

    let ordered_items = cart.map(item => item.id);
    console.log(ordered_items)

     document.getElementById('submit_button').addEventListener('click',()=>{
      if(check_out_price && ordered_items){
        submitPrice(check_out_price, ordered_items);
      }
     })

     async function submitPrice(price, ordered_items){
       let response = await fetch('./php/api/save-total-price.php',{
         method : 'POST',
         body : JSON.stringify({total_price : price, ordered_items})
        });
        if(response.ok){
          // console.log('hi');
         let data = await response.json();
         if(data.success && data.path){
           window.location.href = data.path;
         }else{
          alert('something went wrong');
         }
        }else{
          alert('something went wrong');
        }
     } 

    function handleClick(id){
      let cartItems = JSON.parse(localStorage.getItem('cart'));
      let filteredCart =  cartItems.filter(item => item.id != id);
      localStorage.setItem('cart', JSON.stringify(filteredCart));
      renderCart(filteredCart);
    }

  }
</script>

</html>