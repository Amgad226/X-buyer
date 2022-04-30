<!DOCTYPE html>
<html>
<head>
<title>trip info</title> 
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script> 
</head>
<body>

  <div class="card" style="width: 18rem;">
    {{-- <img class="card-img-top" src="{{$user->img}}" alt="Card image cap"> --}}
    <div class="card-body">
      <h5 class="card-title"><b>Entry to the hotel is allowed</b> </h5>
      {{-- <p class="card-text">name :{{ $user->first_name ." ". $user->last_name}}</p> --}}
      
      <a href="#" class="p-3 mb-2 bg-success text-white">success</a>
    </div>
  </div>
</body>
</html>