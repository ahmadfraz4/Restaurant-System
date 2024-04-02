<?php

$client_id = 'ATSNyueFgg1IAH6qnR96Z6c3C7Gaqtu8KaJW_VFztgTp_IxpOaMRLswJ58PY0VBlJwcU5z0OC0qmtnni';
include '../config/config.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5c5946fe44.js" crossorigin="anonymous"></script>
    <title>Pay Page</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-dark" >
    <div class="container" style="margin-top: none">
        <a class="navbar-brand  text-white" href="#">Pay Page</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
        </div>
    </div>
    </nav>

    <div class="container">  
                    <!-- Replace "test" with your own sandbox Business account app client ID -->
                    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $client_id; ?>&currency=USD"></script>
                    <!-- Set up a container element for the button -->

                    <div id="paymentResponse" class="hidden"></div>
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>
    <body>
        <script>
            paypal.Buttons({
                createOrder: (data, actions) =>{
                    return actions.order.create({
                        "purchase_units" : [{
                            "amount" : {
                                "currency_code" :   "USD",
                                "value" : <?php session_start(); echo $_SESSION['total_price'] ?>,
                            },
                            "items" : []
                        }]
                    })
                },  
                onApprove : (data, actions) => {
                    return actions.order.capture().then(function(orderData){
                        

                        window.location.href = '<?php echo $path.'/php/api/complete-order.php' ?>'
                    })
                }
            }).render('#paypal-button-container')
            
        </script>
</html>