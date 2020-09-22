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
      <div class="row mt-5">
        <div class="col">
          @if($statusId == 1)
            <h2 class="text-primary">Thank you for your order!</h2>
            {{ str_replace('_', ' ', $msg) }}
          @else
            <h2 class="text-danger">Uh-oh! Sorry, payment failed</h2>
            {{ str_replace('_', ' ', $msg) }}
          @endif
        </div>
      </div>
      <div class="row mt-5">

        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Receipt</h4>

              <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Order Id</label>
                    <strong>{{ $order->orderid }}</strong>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Puchase Date</label>
                    <strong>{{ $order->date }}</strong>
                </div>
            </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Name</label>
                        <strong>{{ $order->name }}</strong>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Student ID</label>
                        <strong>{{ $order->studentid }}</strong>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Phone</label>
                        <strong>{{ $order->phone }}</strong>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Email</label>
                        <strong>{{ $order->email }}</strong>
                    </div>
                </div>
    
        </div>

        <div class="col-md-4 order-md-2 mb-4 text-center">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    @if($statusId == 1)
                      <span>Total Paid (MYR)</span>
                    @else
                    <span>Total (MYR)</span>
                    @endif
                    <strong>{{ $order->total }}</strong>
                </li>
            </ul>
            Thanks for your puchase.
        </div>

    </div>


        <div class="card shopping-cart">
            <div class="card-header bg-light text-dark">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                Purchased Items
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <!-- PRODUCT -->
                @if($order->total > 0)
                    {{ logger($orderItems) }}
                    @foreach($orderItems as $item)
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2 text-center">
                                <img class="img-responsive"
                                    src="{{ $item->image }}" alt="prewiew"
                                    width="120" height="80">
                            </div>
                            <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                                <h4 class="product-name"><strong>{{ $item->name }}</strong></h4>
                                <h4>
                                    <small>{{ $item->description }}</small>
                                </h4>
                            </div>
                            <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                                <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                                    <h6><strong>{{ $item->price }} <span class="text-muted">x</span></strong></h6>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4">
                                    <div class="quantity">
                                        {{ $item->qty }}
                                    </div>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 text-right">
                                    &nbsp;
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

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    MMU Cnergy
                    <small class="d-block mb-3 text-muted">&copy; 2020</small>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
