<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    @include('pdf.style')
    <style>
        @page { margin: 0; }
    </style>
</head>
<body style=" background: #f0ebe9" class="w-100">
    <div class="mb-n5">
        <img src="{{asset('images/logo.jpg')}}" width="100px" alt="">
    </div>
    <div class="pb-1 col-1 mx-auto" style="background: #d0a88a"></div>
    <h1 class="text-center text-uppercase mt-3 mb-3 display-3 font-weight-lighter" style="color: #fa881e">Catalogue</h1>
    <div class="px-5" style="display: table; width: 100%">
        @foreach ($products as $key=>$product)
            @if ($key % 3 == 0 )
                @if($key != 0)
                    </div>
                @endif
            <div style="display: table-row;">
            @endif
            <div class="" style="display: table-cell; width: 30%;">
                <div class="card mx-2 mb-3" style="height: 275px">
                    <div class="card-body p-0">
                        <div class="border-bottom">
                        <img src="{{ url($product['photo']) }}" style="height:200px" alt="Photo {{ $product['name'] }}"
                            class="img-fluid w-100 border-bottom">
                        <br>
                        </div>
                        <div class="px-3">
                            <h6 class="text-capitalize mt-3">PRIX UNITAIRE:</h6>
                            <h6 class="text-capitalize mb-2" style="font-weight: lighter !important;">{{ $product['price'] }} FCFA/ X$ / Y£</h6>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</body>
</html>
