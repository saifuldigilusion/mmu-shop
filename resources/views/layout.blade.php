<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>MMU Shop</title>

  <link rel="icon" sizes="192x192" href="https://static.wixstatic.com/media/03f85b_83a125543edf4a48900cbf704d181a8f%7Emv2.png/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/03f85b_83a125543edf4a48900cbf704d181a8f%7Emv2.png">
  <link rel="shortcut icon" href="https://static.wixstatic.com/media/03f85b_83a125543edf4a48900cbf704d181a8f%7Emv2.png/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/03f85b_83a125543edf4a48900cbf704d181a8f%7Emv2.png" type="image/png"/>
  <link rel="apple-touch-icon" href="https://static.wixstatic.com/media/03f85b_83a125543edf4a48900cbf704d181a8f%7Emv2.png/v1/fill/w_32%2Ch_32%2Clg_1%2Cusm_0.66_1.00_0.01/03f85b_83a125543edf4a48900cbf704d181a8f%7Emv2.png" type="image/png"/>

  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom styles for this template -->
  <link href="/css/shop-homepage.css" rel="stylesheet">

  @yield('head')

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="/shop"><img src="/img/mmu-cnergy-white.png" alt="logo" style="display: inline-block;"/><span style="display: inline-block;">Shop</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-shopping-cart text-white" aria-hidden="true"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> My Cart</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  @yield('content')

  <!-- Footer -->
  <footer class="py-5 blue-mmu">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; 2020 MMU CNERGY. ALL RIGHTS RESERVED.</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  @yield('script')

</body>

</html>
