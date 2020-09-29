@extends('layout')

@section('content')
    
  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-12">

        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            @for($i=0; $i < $carousels->count(); $i++ )
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" class="{{ $i==0 ? "active": "" }}""></li>
            @endfor
          </ol>
          <div class="carousel-inner" role="listbox">
            {{ $i = 0 }}
            @foreach($carousels as $carousel)
            {{ $i++ }}
            <div class="{{ $i==1 ? "carousel-item active": "carousel-item" }}">
              <img class="d-block img-fluid" src="{{ $carousel->image }}" alt="slide">
              <div class="carousel-caption d-none d-md-block">
                <h5>{{ $carousel->title }}</h5>
                <p>{{ $carousel->description }}</p>
              </div>
            </div>
            @endforeach
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

        <div class="row">
            @foreach ($products as $product)

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="/product/{{ $product->id }}" class="img-hover">
                <img class="card-img-top image-hover" src="{{ $product->image }}" alt="">
                <div class="img-hover-middle">
                  <div class="img-hover-text">More details..</div>
                </div>
              </a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="/product/{{ $product->id }}">{{ $product->name }}</a>
                </h4>
                <h5>RM{{ $product->price }}
                    @if ($product->rrp_price > 0.00) 
                    @if ($product->rrp_price != $product->price )
                    <small><strike>RM{{ $product->rrp_price }}</strike></small>
                    @endif
                    @endif
                </h5>
                <p class="card-text">
                    {{ $product->description }}
                </p>
              </div>
              <div class="card-footer">
                <a href="/cart/add?id={{ $product->id }}" class="btn btn-buy"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                <div class="float-right">
                  <a href="{{ route('product-detail', [$product->id]) }}" class="btn btn-default">More</a>
                  </div>
              </div>
            </div>
          </div>

            @endforeach
            
        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
@endsection