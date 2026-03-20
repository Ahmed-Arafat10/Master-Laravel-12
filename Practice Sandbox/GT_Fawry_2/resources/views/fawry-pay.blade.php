@extends('main-layout')
@section('main-div')
        <div class="container">
            <form method="post" action="{{ route('fawry.store.R2f') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Your Phone</label>
                    <input required type="number" name="phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Enter Your E-Wallet Phone Number Please</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
@endsection

