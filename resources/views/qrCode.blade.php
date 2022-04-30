<!DOCTYPE html>
<html>
<head>
    <title>How to Generate QR Code in Laravel 8? - ItSolutionStuff.com</title>
</head>
<body>
    
<div class="visible-print text-center">
     
    {{ $image=QrCode::format('svg')
                 ->size(200)
                 
                 ->generate('192.168.1.36:8000/ss');

    }};
    
     
</div>
<p>amgad</p>
</html>