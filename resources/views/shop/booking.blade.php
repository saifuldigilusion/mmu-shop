@extends('layout')

@section('content')

  <!-- Page Content -->
  <div class="container mt-5 mb-5">
    
    <div class="row">

      <div class="col-md-12">
        <h4 class="mb-3">Reservation</h4>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Full name" value="{{ $order->name }}" {{ $bookByOrder ? "disabled": ""}} required>
              <div class="invalid-feedback">
                Please enter your full name
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="orderid">Order ID</label>
              <input type="text" class="form-control" name="orderid" id="orderid" placeholder="Order ID" value="{{ $order->orderid }}" {{ $bookByOrder ? "disabled": ""}} required>
              <div class="invalid-feedback">
                Please enter your Order ID.
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="phone">Phone</label>
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone no" value="{{ $order->phone }}" {{ $bookByOrder ? "disabled": ""}} required>
              <div class="invalid-feedback">
                Please enter your contact no
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="your@email.com" value="{{ $order->email }}" {{ $bookByOrder ? "disabled": ""}} required>
              <div class="invalid-feedback">
                Please enter a valid email address for receipt.
              </div>
            </div>
          </div>
        </div>

    </div> <!-- row -->

    <div class="row">
    <div class="col-md-12">
    <div class="accordion" id="accordionExample">

  @foreach($orderItems as $oi)
      @php
      $sc = $schedules[$oi->id];
      $slots = $scheduleSlots[$oi->id];
      $datesAndTime = array();
      foreach($slots as $s) {
        $d = $s->date;
        $datesAndTime[$d] = array();

        // TODO
      }
      @endphp
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          {{ $sc->name }} for {{ $oi->name }}
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <form method="post" id="form" action="/reservation/update/byorder" class="needs-validation" novalidate>
          @csrf
          <input type="hidden" name="orderid" value="{{ $order->orderid }}">
          <input type="hidden" name="orderitem" value="{{ $oi->id }}">
          <input type="hidden" name="scheduleid" value="{{ $sc->id }}">
          <div class="row">            
            <div class="col-md-6">

              <div class="form-group">
                <label for="name">Select Time Slot</label>
                <select class="form-control" id="date-{{ $oi->id }}" name="slot" required>
                  <option value="" disabled selected></option>
                  @foreach($slots as $s)
                    @php
                      $dt = date_format(date_create($s->start_date . " " . $s->start_time),"D d/m/Y H:i:s");   
                    @endphp
                    <option value="{{ $s->id }}">{{ $dt }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">
                  Please select available slot
                </div>
              </div>
              <button type="submit" class="btn btn-buy"> Book </button>

            </div>
          </div>
        </form>
      </div>
    </div>
  </div> <!-- card -->
  
  @endforeach

    </div> <!-- accordian -->
  </div> <!-- col -->
    </div> <!-- row -->
</div> <!-- /.container -->

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

  </script>
@endsection