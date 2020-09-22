<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>MMU Shop</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/cart.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <nav class="navbar navbar-expand-xl nav_area border-bottom shadow-sm">
        <div class="container">
            <div class="logo">
                <a href="http://www.mmu-cnergy.com" class="logo-light">
                    <img alt="image1__2_-removebg-preview.png"
                        src="https://static.wixstatic.com/media/acbcfd_f17d7aafa4b54bbd8167038c3f355efb~mv2.png/v1/fill/w_279,h_163,al_c,q_85,usm_0.66_1.00_0.01/image1__2_-removebg-preview.webp"
                        style="width: 286px; height: 163px; object-fit: contain; object-position: center center;">
                </a>
            </div>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav ml-auto navbar-center main_menu onepage_nav">
                    <li class="nav-item active">
                      <a href="/shop" class="btn btn-danger">SHOP</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
      <form id="form" method="POST" action="/cart/checkout" class="needs-validation" novalidate>
        @csrf
        <div class="card shopping-cart">
            <div class="card-header bg-light text-dark">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                My Shopping cart
                <a href="/shop" class="btn btn-outline-info btn-sm pull-right">Continue Shopping</a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <!-- PRODUCT -->
                @if($total > 0) 
                @foreach ($items as $item)
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2 text-center">
                        <img class="img-responsive" src="{{ $item->options["image"] }}" alt="prewiew" width="120"
                            height="80">
                    </div>
                    <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                        <h4 class="product-name"><strong>{{ $item->name }}</strong></h4>
                        <h4>
                            <small>{{ $item->options["description"] }}</small>
                        </h4>
                    </div>
                    <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                        <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                            <h6><strong>{{ number_format($item->price, 2, '.', '') }} <span class="text-muted">x</span></strong></h6>
                        </div>
                        <div class="col-4 col-sm-4 col-md-4">
                            <div class="quantity">
                                <!--<button type="button" value="+" class="plus" onclick=countAddRemove(this)>+</button> -->
                                <input type="number" step="1" max="99" min="1" value="{{ $item->qty }}" title="Qty" class="qty"
                                    size="4" data-product="{{ $item->rowId }}" onchange=updateCart(this)>
                                <!-- <button type="button" value="-" class="minus" onclick=countAddRemove(this)>-</button> -->
                            </div>
                        </div>
                        <div class="col-2 col-sm-2 col-md-2 text-right">
                            <a href="/cart/remove?row={{ $item->rowId }}" class="btn btn-outline-danger btn-xs">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
                @else
                  <div class="row">
                    <div class="col text-center">
                    You have empty cart. <a href="/shop">Continue shopping.. </a>
                    </div>
                  </div>
                @endif
                <!-- END PRODUCT -->
            </div>
        </div>
        <div class="row mt-5">

        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Please fill up below:</h4>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Full name" value="" required>
                  <div class="invalid-feedback">
                    Please enter your full name
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="studentid">Student ID</label>
                  <input type="text" class="form-control" name="studentid" id="studentid" placeholder="MMU Student ID" value="" required>
                  <div class="invalid-feedback">
                    Please enter your MMU Student ID.
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone no" value="" required>
                  <div class="invalid-feedback">
                    Please enter your contact no
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="your@email.com" value="" required>
                  <div class="invalid-feedback">
                    Please enter a valid email address for receipt.
                  </div>
                </div>
              </div>
        </div>

        <div class="col-md-4 order-md-2 mb-4">
          <ul class="list-group mb-3">
              <li class="list-group-item d-flex justify-content-between">
                  <span>Total (MYR)</span>
                  <strong>{{ $total }}</strong>
              </li>
          </ul>
          <button class="btn btn-primary btn-lg btn-block" type="submit" {{ $count < 1 ? "disabled" : "" }} >Continue to checkout</button>
      </div>
    </form>
        </div>

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
          <div class="row">
            <div class="col-12 col-md">
              MMU Cnergy
              <small class="d-block mb-3 text-muted">&copy; 2020</small>
            </div>
          </div>
        </footer>
    </div>
    <script>

(function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})();

      function countAddRemove(a) {
    
        if(a.type == "button") {
          var oldValue = $(a).parent().find("input").val();
          var newValue = 1;
          if(a.value == "+") {
            newValue = parseFloat(oldValue) + 1;
          }
          else {
            if(a.value == "-") {
              if(oldValue > 1) {
                newValue = parseFloat(oldValue) - 1;
              }
            }
          }

          $(a).parent().find("input").val(newValue);
        }
       
      }

      function updateCart(a) {
        console.log(a);
        var form = document.createElement('form');
        var rowId = a.getAttribute('data-product');
        var quantity = a.value;
        document.body.appendChild(form);
        form.method = 'post';
        form.action = '/cart/update';
        data = { text: 'checkout', _token: $('meta[name="csrf-token"]').attr('content'), row: rowId, qty: quantity}
        for (var name in data) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = data[name];
            form.appendChild(input);
        }
        form.submit();
      }
    </script>
</body>
</html>
