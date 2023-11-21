@extends('main-layout')
@section('main-div')
    <div class="container">

        @php $i=1; $products = \App\Http\Helper\Helper::getProducts();
    $total = 0;
        @endphp
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }} L.E</td>
                    <td>{{ $product['qty'] }}</td>
                    <td>{{ $product['qty'] * $product['price'] }} L.E</td>
                    @php($total += $product['qty'] * $product['price'])
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <h2> Total Checkout: {{ $total }} L.E</h2>

    <br>
    <br>
    <br>
    <h3> Pay With: <img src="{{ asset('assets/img/fawry.png') }}"></h3>
    <button onclick="window.location='{{ route('fawry.store.QR') }}'" type="button" class="btn btn-secondary">QR Code</button>
    <button onclick="window.location='{{ route('fawry.pay') }}'" type="button" class="btn btn-secondary">Request To Pay (R2P)</button>
@endsection

