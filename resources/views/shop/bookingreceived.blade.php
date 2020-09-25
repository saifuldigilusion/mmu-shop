@extends('layout')

</head>


@section('content')

  <!-- Page Content -->
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h2 class="text-primary">Thank you for your reservation!</h2>
      </div>
    </div>
    <div class="row mt-5">

      <div class="col-md-12 order-md-1">
          <h4 class="mb-3">Reservation Details</h4>

            <div class="row">
              <div class="col-md-6 mb-3">
                  <label class="text-muted">Booking No</label>
                  <strong>{{ $booking->bookingid }}</strong>
              </div>
              <div class="col-md-6 mb-3">
                  <label class="text-muted">Date</label>
                  <strong>{{ date("d/m/Y", strtotime($booking->created_at)) }}</strong>
              </div>
          </div>

              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label class="text-muted">Name</label>
                      <strong>{{ $order->name }}</strong>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="text-muted">Order No</label>
                      <strong>{{ $order->orderid }}</strong>
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

              <div class="row">
                <div class="col-md-12 mb-3">
                {{ $schedule->name }} {{ $orderItem->name }} 
                <p>
                    Reservation: {{ date_format(date_create($scheduleSlot->start_date . " " . $scheduleSlot->start_time),"D d/m/Y H:i:s") }}
                </p>
                <p>
                    <a href="/reservation/byorder/{{ $order->orderid }}" class="btn btn-buy"> Back to Reservation </a>
                </p>
                </div>
              </div>
  
      </div>

  </div>

    </div>
  <!-- /.container -->

@endsection