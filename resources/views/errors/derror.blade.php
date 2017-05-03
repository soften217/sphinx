@extends('layouts.app')

@section('content')

<!DOCTYPE html>

        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>


        <div class="container">
            <div class="content">
                <div class="title">{{$notify}}</div>
                <a href="{{ URL::previous() }}">Go Back</a>
            </div>
        </div>



@endsection
