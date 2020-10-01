@extends('layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

@php
$itemDelivery = false;
@endphp
<div class="container mt-5">
    <form id="form" method="POST" action="/cart/checkoutconfirm" class="needs-validation" novalidate>
        @csrf
        <div class="card shopping-cart">
            <div class="card-header bg-secondary text-light">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                My Shopping cart
                <a href="/shop" class="btn btn-outline-light btn-sm pull-right">Continue Shopping</a>
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
                        <span>
                            {{ $item->options["description"] }}
                        </span>
                        <p>
                          <span class="small">
                        @if($item->options["selfcollect"])
                          Self collect available.
                        @endif
                        @if($item->options["delivery"])
                            @php
                            $itemDelivery = true;
                            @endphp
                            Delivery charges to
                            @foreach($item->options["delivery_cost"] as $d)
                              {{ $d->name }} RM{{ $d->price }} , 
                            @endforeach
                        @endif
                          </span>
                        </p>
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
                  <input type="text" class="form-control" name="studentid" id="studentid" placeholder="MMU Student ID" value="">
                  <div class="invalid-feedback">
                    Please enter your MMU Student ID.
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="phone">Phone</label>
                  <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone no" value="" required>
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

              @if($itemDelivery)
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="todeliver"><label for="todeliver" class="form-check-label">Ship my item(s)</label>
                  <input type="hidden" name="delivery"  id="delivery" value="0">
                  </div>
                </div>
              </div>
              <div id="deliveryform" class="d-none">
              <h4 class="mb-3">Delivery Address:</h4>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="phone">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Street Address" value="">
                  <input type="text" class="form-control" name="address2" id="address2" placeholder="" value="" >
                </div>
                <div class="col-md-6 mb-3">
                  <label for="postcode">Postcode</label>
                  <input type="number" class="form-control" name="postcode" id="postcode" placeholder="" value="">
                  <div class="invalid-feedback">
                    Please enter a valid postcode.
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="state">State</label>
                  <select name="state" id="state" class="form-control">
                    <option value=""></option>
                    @foreach(Config::get('mmucnergy.malaysiaStates') as $s => $v)
                      <option value="{{ $s }}">{{ $s }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                 &nbsp;
                </div>
              </div>
            </div>
              @endif

            </div>

            <div class="col-md-4 order-md-2 mb-4">
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between bg-secondary text-light">
                    <span>Total (MYR)</span>
                    <strong>{{ $total }}</strong>
                </li>
                <span class="small">excl. delivery</span>
            </ul>
            <button class="btn btn-buy btn-lg btn-block" type="submit" {{ $count < 1 ? "disabled" : "" }} >Continue to checkout</button>
            </div>
        </div>
    </form>
</div>

@endsection
@section('script')
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

      @if($itemDelivery)
      (function() {
        $('#todeliver').change(function() {
          if(this.checked) {
            $("#deliveryform").removeClass("d-none");
            $("#delivery").val("1");
            $("#address").prop('required', true);
            $("#postcode").prop('required', true);
            $("#state").prop('required', true);
          }
          else {
            $("#deliveryform").addClass("d-none");
            $("#delivery").val("0");
            $("#address").prop('required', false);
            $("#postcode").prop('required', false);
            $("#state").prop('required', false);
          }
        });
      })();
      @endif
    </script>
@endsection