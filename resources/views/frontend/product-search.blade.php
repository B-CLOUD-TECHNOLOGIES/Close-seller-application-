    @extends('frontend.frontend-master')

    @section('main')
        <link rel="stylesheet" href="{{ asset('users/assets/css/home.css') }}">

        @include('frontend._product-results')

    @endsection
