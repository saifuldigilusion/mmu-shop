
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>MMU Shop</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/pricing/">

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/cart.css">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="/css/shop.css" rel="stylesheet">
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
                        <a href="/shop" class="btn btn-danger">SHOP</a><br>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <p class="class">
    <h2 class="" style="text-align:center;font-size:28px"><span style="color:rgb(10, 76, 156); font-size:40px;">GET YOUR PRECIOUS MOMENT</span></h2>
    <h2 class="font_2" style="text-align:center;font-size:28px"><span style="color:rgb(10, 76, 156); font-size:40px;">CELEBRATE YOUR ACHIVEMENT</span></h2>

    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <a href="/cart">My Shopping cart</a>
</p>
</div>
<div class="container">
  <div class="card-deck mb-3 text-center">
    @foreach ($products as $product)
    <div class="card mb-4 shadow-sm">
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">{{ $product->name }}</h4>
      </div>
      <div class="card-body">
      <img src="{{ $product->image }}"/>
        <ul class="list-unstyled mt-3 mb-4">
            <li><h4>RM{{ $product->price }}</h4></li>
            @if ($product->rrp_price > 0.00) 
                @if ($product->rrp_price != $product->price )
          <li><strike>RM{{ $product->rrp_price }}</strike></li>
                @endif
            @endif
          <li>{{ $product->description }}</li>
        </ul>
        <a href="/cart/add?id={{ $product->id }}" class="btn btn-lg btn-block btn-primary">Buy</a>
      </div>
    </div>
    @endforeach
    </div><!-- end card-deck -->
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <a href="/cart">My Shopping cart</a>
  <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">
        MMU Cnergy
        <small class="d-block mb-3 text-muted">&copy; 2020</small>
      </div>
    </div>
  </footer>
</div><!-- end container -->
</body>
</html>
