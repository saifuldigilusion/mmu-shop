@extends('layout')

</head>


@section('content')

  <!-- Page Content -->
  <div class="container mt-5 mb-5">
    <div class="row">
        <div class="col text-center">
            <h5>Uh-oh! Sorry..</h5>
            {{ $errorMsg }}
        </div>
    </div>
</div>
  <!-- /.container -->

@endsection