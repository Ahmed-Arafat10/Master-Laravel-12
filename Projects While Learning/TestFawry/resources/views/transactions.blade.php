@extends('main-layout')
@section('main-div')

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ref_num</th>
                <th scope="col">merchant_ref_num</th>
                <th scope="col">order_amount</th>
                <th scope="col">payment_amount</th>
                <th scope="col">fawry_fees</th>
                <th scope="col">status</th>
                <th scope="col">payment_method</th>
                <th scope="col">signature</th>
                <th scope="col">taxes</th>
                <th scope="col">type</th>
                <th scope="col">QR Code</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->ref_num }}</td>
                    <td>{{ $item->merchant_ref_num }}</td>
                    <td>{{ $item->order_amount }}</td>
                    <td>{{ $item->payment_amount }}</td>
                    <td>{{ $item->fawry_fees }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->payment_method }}</td>
                    <td>{{ $item->signature }}</td>
                    <td>{{ $item->taxes }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{!! $item->qr_code !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection

