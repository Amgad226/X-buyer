<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Curl extends Controller
{
     function Curl(Request $request){
    
//          $url = "https://www.geeksforgeeks.org/";
//     $input = $request->input('token');

//     $curl_handle = curl_init();
//   //  curl_setopt($curl_handle, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' .$input.'&aqs=chrome..69i57j69i60.1878j0j7&sourceid=chrome&ie=UTF-8');
//     curl_setopt($curl_handle, CURLOPT_URL,$url);
//     curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
//     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
//     $response = json_decode(curl_exec($curl_handle));
//     curl_close($curl_handle);
//       echo  $response;
     

// // Initialize a CURL session.
// $ch = curl_init();

// // Return Page contents.
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// //grab URL and pass it to the variable.
// curl_setopt($ch, CURLOPT_URL, $url);

// $result = curl_exec($ch);

// echo $result;



// $url = "https://www.geeksforgeeks.org/";
// $input = $request->input('token');

// $curl_handle = curl_init();
// //  curl_setopt($curl_handle, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' .$input.'&aqs=chrome..69i57j69i60.1878j0j7&sourceid=chrome&ie=UTF-8');
// curl_setopt($curl_handle, CURLOPT_URL,$url);
// curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
// curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
// $response = curl_exec($curl_handle);
// curl_close($curl_handle);
//   echo  $response;
 
// // "https://m.media-amazon.com/images/I/61mpMH5TzkL._AC_UY218_.jpg"



// // echo"Af";    
//  $curl = curl_init(); //$curl is going to be data type curl resource 
//  $search_string = "pc video games 2016";
//   $url = "https://www.amazon.com/s?k=$search_string";
//    curl_setopt ($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);

// //   https://m.media-amazon.com/images/I/61dwuOuWXmL._AC_UY327_FMwebp_QL65_.jpg
// //   https://m.media-amazon.com/images/I/615YaAiA-ML._AC_UY327_FMwebp_QL65_.jpg
// //   https://m.media-amazon.com/images/I/61kwRNPtMpL._AC_UY327_FMwebp_QL65_.jpg

//      $result = curl_exec ($curl); 
//       preg_match_all("!https://m.media-amazon.com/images/I/[^\s]*?._AC_UY327_FMwebp_QL65_.jpg!", $result, $matches );

    
  
//       print_r($matches);
//       $images = array_values(array_unique($matches[0])); 
//       for ($i = 0; $i < count ($images); $i++) 
//       {
//            echo "<div style='float: left; margin: 10 0 0 0; '>";
//             echo "<img src='$images[$i]'><br />";
//              echo "</div>"; 
//             }
//              curl_close($curl);









     }
}
