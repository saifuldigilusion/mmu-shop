@extends('layout')

</head>


@section('content')

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-12">

        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="{{ $product->image_big }}" alt="">
          <div class="card-body">
            <a href="/category/{{ strtolower(str_replace(' ', '', $category)) }}" class="badge badge-secondary">{{ $category }}</a>
            <h3 class="card-title">{{ $product->name }}</h3>
            <h4>RM{{ $product->price }}
              @if ($product->rrp_price > 0.00) 
              @if ($product->rrp_price != $product->price )
              <small><strike>RM{{ $product->rrp_price }}</strike></small>
              @endif
              @endif
            </h4>
            <p class="card-text">{{ $product->description }} </p>
            <a href="/cart/add?id={{ $product->id }}" class="btn btn-buy"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
          </div>
        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Product Detail
          </div>
          <div class="card-body">
            {!! $product->long_description !!}
          </div>
          <div class="card-footer">
            <a href="/cart/add?id={{ $product->id }}" class="btn btn-buy"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
          </div>
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->

@endsection