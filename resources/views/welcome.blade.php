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
/*                 font-weight: 100; */
/*                 font-family: 'Lato'; */
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
              <div class="panel-heading"><b>What is iQUIZ?</b></div>

                <div class="panel-body container1">
            <div class="content">
                <div class="title">iQUIZ</div>
                  <p style="font-size:30;">
                    The iQUIZ is a web application that will help both students and faculties by giving them convenience in quiz and 
                    examination processes. It will be having several helpful features such as student/faculty login system, a questionnaires 
                    repository, an auto-generator for sets of quiz and examination questions, an online scheduler, a time-limit setter, 
                    an auto-checker, an automated grading system and a pdf-generator for offline use. 
                  </p>
          </div>
        </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>The Team</b></div>

                <div class="panel-body container1">
            <div class="content">
                <div class="title"> Sphinx Development </div>
                  <p style="font-size:24;">
                    Members:
                  </p>
          </div>
          <div>
                  <ul style="list-style: none;">
                  <li>Casusi, Joem</li>
                  <li>Nueva,Jeian</li>
                  <li>Paulin, Vincent</li>
                  <li>Reyes, Jan Gabriel</li>
              </ul>
            </div>
        </div>
            </div>
        </div>
    </div>
</div> -->


@endsection
