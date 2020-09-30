@extends('layout')

</head>


@section('content')

  <!-- Page Content -->
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

              @if($order->delivery)
              <div class="row">
                  <div class="col-md-12">
                      Delivery Address
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Address</label>
                    <strong>{{ $order->address }}</strong><br>
                    <strong>{{ $order->address2 }}</strong>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Postcode</label>
                    <strong>{{ $order->postcode }}</strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted">State</label>
                    <strong>{{ $order->state }}</strong><br>
                </div>
                <div class="col-md-6 mb-3">
                   &nbsp;
                </div>
            </div>
            @endif
      </div>

      <div class="col-md-4 order-md-2 mb-4 text-center">
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between ">
                <span>Sub Total (MYR)</span>
                <strong>{{ number_format($order->sub_total, 2, '.', '') }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between ">
              <span>Delivery Charges (MYR)</span>
              <strong>{{ number_format($order->shipping, 2, '.', '') }}</strong>
          </li>
              <li class="list-group-item d-flex justify-content-between bg-secondary text-light">
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
          <div class="card-header bg-secondary text-light">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
              Purchased Items
              <div class="clearfix"></div>
          </div>
          <div class="card-body">
              <!-- PRODUCT -->
              @if($order->total > 0)
                  @foreach($orderItems as $item)
                      <div class="row">
                          <div class="col-12 col-sm-12 col-md-2 text-center">
                              <img class="img-responsive"
                                  src="{{ $item->image }}" alt="preview"
                                  width="120" height="80">
                          </div>
                          <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                              <h4 class="product-name"><strong>{{ $item->name }}</strong></h4>
                              <h4>
                                  <small>{{ $item->description }}</small>
                              </h4>
                              <p>
                                <span class="small">
                              @if($item->shipping > 0)
                                Delivery charges for {{ $item->qty }} items is RM{{ number_format($item->shipping * $item->qty, 2, '.', '') }}
                              @endif
                                </span>
                              </p>
                              @if($item->booking) 
                                <a href="/reservation/byorder/{{ $order->orderid }}" class="btn btn-primary"> Book my session </a>
                              @endif
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
    </div>
  <!-- /.container -->

@endsection