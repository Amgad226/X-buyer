

@section('contant')




            
         
         
<div class="card mt-5" >
 <div class="row">
  <div class="col-lg-12">
    
  <div class="w-1 p-3">
<div class="border border-secondary" >
    {{-- <div class="card-header "> <h2 class="text-left">{{  }} </h2> </div> --}}
   
    <table class="table table-dark">
        {{$i=1}}
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">user  </th>
            <th scope="col">item  </th>
            <th scope="col">offer</th>
          </tr>
        </thead>
        <tbody>
            @foreach($offer as $of)
          <tr>
            <th scope="row">{{$i}}</th>
            <td>{{$of->user->first_name}}</td>
            {{-- <td>{{$of->title}}</td>
            <td>{{$of->item->user->count()}}</td> --}}
          </tr>
          {{$i++;}}
          @endforeach
         
        </tbody>
      </table>