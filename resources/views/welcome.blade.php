@extends('layouts.app')

@section('content')
<style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container1 {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body container1">
            <div class="content">
                <div class="title">Sphinx Development</div>
                  <p style="font-size:24;">
                    Members:
                  </p>
          </div>
          <div>
                  <ul style="list-style: none;">
                  <li>Joem Casusi</li>
                  <li>Jeian Nueva</li>
                  <li>Vincent Paulin</li>
                  <li>GJay Reyes</li>
              </ul>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>


@endsection
