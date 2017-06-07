<?php
//date_default_timezone_set("Asia/Manila");
$start_time = microtime(TRUE);
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="copyright" content="Sphinx Team (iACADEMY)">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>Sphinx</title>

    <!-- Sweet Alert -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> {{--
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}


    <!-- Javascripts -->
    <!--   <script src="{{URL::asset('resources/dist/sweetalert.min.js')}}"></script>
  <link rel="stylesheet" href="{{URL::asset('/resources/dist/sweetalert.css')}}"> -->


    <style>
      .dropdown-menu>li>a:hover {
        color: #262626;
        text-decoration: none;
        background: none !important
      }
      /*   //////////////////   ////////////////////////   */
      /* Set all odd list items to a different color (zebra-stripes) */
      
      tr[id="list"]:nth-child(odd) {
        background: #eeeeee;
      }
      
      .dropdown-menu>li>a:hover {
        color: #262626;
        text-decoration: none;
        background-color: 000000
      }
      /* Include the padding and border in an element's total width and height */
      
      * {
        box-sizing: border-box;
      }
      /* Remove margins and padding from the list */
      
      ul {
        margin: 0;
        padding: 0;
      }
      /* Style the list items */
      
      ul li {
        cursor: pointer;
        position: relative;
        padding: 12px 8px 12px 20px;
        background: #eee;
        font-size: 14px;
        transition: 0.2s;
        list-style-type: none;
        /* make the list items unselectable */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      /* Set all odd list items to a different color (zebra-stripes) */
      
      ul li:nth-child(odd) {
        background: #f9f9f9;
      }
      /* Darker background-color on hover */
      
      ul li:hover {
        background: #ccc;
      }
      /* When clicked on, add a background color and strike out text */
      
      ul li.checked {
        background: #888;
        color: #fff;
        text-decoration: line-through;
      }
      /* Add a "checked" mark when clicked on */
      
      ul li.checked::before {
        content: '';
        position: absolute;
        border-color: #fff;
        border-style: solid;
        border-width: 0 2px 2px 0;
        top: 10px;
        left: 16px;
        transform: rotate(45deg);
        height: 15px;
        width: 7px;
      }
      /* Style the close button */
      
      .close {
        position: absolute;
        right: 0;
        top: 0;
        padding: 12px 16px 12px 16px;
      }
      
      .close:hover {
        background-color: #f44336;
        color: white;
      }
      /* Style the header */
      
      .header {
        background-color: #eeeeee;
        padding: 30px 40px;
        color: black;
        text-align: center;
      }
      /* Clear floats after the header */
      
      .header:after {
        content: "";
        display: table;
        clear: both;
      }
      /* Style the input */
      
      input[type=text] {
        border: 1px solid gray;
        border-radius: 4px;
        width: 100%;
        padding: 10px;
        float: left;
        font-size: 16px;
      }
      
      input[type=number] {
        border: 1px solid gray;
        border-radius: 4px;
        padding: 10px;
        float: left;
        font-size: 16px;
      }
      
      input[type=date] {
        border: 1px solid gray;
        border-radius: 4px;
        padding: 10px;
        float: left;
        font-size: 16px;
      }
      /* Style the "Add" button */
      
      .addBtn {
        padding: 10px;
        width: 100%;
        background: #d9d9d9;
        color: #555;
        float: left;
        text-align: center;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
      }
      
      .addBtn:hover {
        background-color: #bbb;
      }
      /* //////////////////////////////////////////////////////////////////     */
      
      body {
        font-family: 'Lato';
        height: 100%;
      }
      
      .fa-btn {
        margin-right: 6px;
      }
      
      #footer {
        height: 50px;
        /* the footer's total height */
      }
      
      #footer-content {
        text-align: center;
        height: 32px;
        /* height + top/bottom paddding + top/bottom border must add up to footer height */
        padding: 8px;
      }
      
      .imgcenter {
        float: right;
      }
    </style>
  </head>

  <style>
    .iconEnlarge {
      font-size: 64px;
    }
  </style>

  <body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">

          <!-- Collapsed Hamburger -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

          <!-- Branding Image -->
          <ul class="nav navbar-nav">
            <li style="text-align: center;">
               @if (Auth::guest())  
              <a href="{{ url('/glogin') }}">
                <img class="navbar-brand imgcenter" style="max-width: 85%; height: auto;" src={{ URL::to( '/image/logo-60px.png') }} alt="No img" /></br>
                <b>iQUIZ</b>
              </a>
              @else
              <a href="{{ url('/home') }}">
                <img class="navbar-brand imgcenter" style="max-width: 85%; height: auto;" src={{ URL::to( '/image/logo-60px.png') }} alt="No img" /></br>
                <b>iQUIZ</b>
              </a>
             @endif
            </li>
          </ul>
        </div>

        
    @if (Auth::guest()) 
    
    <div class="collapse navbar-collapse" id="app-navbar-collapse" style="text-align: center;">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
            <li><a href="{{ url('/glogin') }}"><i class="fa fa-home iconEnlarge" aria-hidden="true"></i>
              <br/><span style="font-size: 15px;"><b>Home</b></span></a></li>
          </ul>
    
    @else
    
      <div class="collapse navbar-collapse" id="app-navbar-collapse" style="text-align: center;">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
            <li><a href="{{ url('/home') }}"><i class="fa fa-home iconEnlarge" aria-hidden="true"></i>
              <br/><span style="font-size: 15px;"><b>Home</b></span></a></li>
          </ul>
    @endif


          <ul class="nav navbar-nav">
            @if (Auth::guest()) @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="fa fa-users iconEnlarge" aria-hidden="true"></i>
                <br/><span style="font-size: 15px;"><b>Group</b></span><span class="caret"></span>
              </a>

              <ul class="dropdown-menu" id="menu" role="menu">

                <?php
                      $user_groups = DB::table('user_group')->where('user_id', '=', auth()->user()->id)->get();
              
                      foreach ($user_groups as $user_group) {
                            $groups = DB::table('groups')->where('id', '=', $user_group->group_id)->get();
              
                              foreach ($groups as $group) {
                                    $id = $group->id;
                                    $isArchived = $group->isArchived;
                                
                                    if($isArchived==0)
                                    {
                                      echo '<li style="list-style-type: none;"><a href="/group/'.$id.'"><i class="fa fa-btn fa-users"></i>'.$id.'</a></li>';
                                    }
                              }
                      }
                  ?>

                  @if (auth()->user()->isFaculty == 1)
                  <li><a href="{{ url('/addgroup') }}"><i class="fa fa-btn fa-plus"></i>Create New Group..</a></li>
                  @else
                  <!--                   <li><a href="{{ url('/addgroup') }}"><i class="fa fa-btn fa-plus"></i>Join Group..</a></li> -->
                <form class="form-inline" role="form" method="POST" action="{{ url('/addgroup') }}">
                             {{ csrf_field() }}
                              <div class="form-group mx-sm-3">
                                <input type="text" class="form-control" name="code" placeholder="Join Code">
                                <span class="input-group-btn">
                          <button class="btn btn-secondary" type="submit">Join</button>
                         </span>
                </form>

                  @endif
              </ul>
            </li>
            @if (auth()->user()->isFaculty == 1)
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-university iconEnlarge" aria-hidden="true"></i>
                                <br/><span style="font-size: 15px;"><b>Question Bank</b></span><span class="caret"></span>
            </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/formquestion') }}"><i class="fa fa-btn fa-plus"></i>Create New Questions</a></li>
                <li><a href="{{ url('/questionbank') }}"><i class="fa fa-btn fa-plus"></i>Manage Questions</a></li>
              </ul>
            </li>
            @else @endif @endif
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
            <li>
              <a><i class="fa fa-clock-o iconEnlarge" aria-hidden="true"></i><br/>
                <span style="font-size: 15px;"><b><?php echo date("F j, Y, g:i a"); ?></b></span></a>
            </li>
            <li><a href="{{ url('/glogin') }}"><i class="fa fa-google iconEnlarge" aria-hidden="true"></i></i><br/>
              <span style="font-size: 15px;"><b>Login with Google</b></span></a></li>
            <!--             <li><a href="{{ url('/register') }}"><i class="fa fa-user-plus iconEnlarge" aria-hidden="true"></i><br/>
            <span style="font-size: 15px;"><b>Register</b></span></a></li> -->
            @else
            <li>
              <a>
                <i class="fa fa-clock-o iconEnlarge" aria-hidden="true"></i><br/>
                <span style="font-size: 15px;"><b><?php echo date("F j, Y, g:i a"); ?></b></span>
              </a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="fa fa-user-circle iconEnlarge" aria-hidden="true"></i>
                <span style="font-size: 15px;"><b>{{ Auth::user()->name }}</b> <br/>
                {{ Auth::user()->email }} </span><span class="caret"></span>
              </a>

              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/help') }}"><i class="fa fa-btn fa-question-circle"></i>Help</a></li>
                <li><a onclick="swal('Logging Out')" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout in App</a></li>
                <li><a onclick="swal('Logging Out')" href="{{ url('/logoutall') }}"><i class="fa fa-btn fa-sign-out"></i>Logout Google and App</a></li>
              </ul>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </nav>

    @if (Session::has('sweet_alert.alert'))
    <script>
      swal({!!Session::get('sweet_alert.alert') !!});
    </script>
    <?php Session::forget('sweet_alert'); ?> @endif @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{--
    <script src="{{ elixir('js/app.js') }}"></script> --}}

    <footer id="footer">
      <hr/>
      <div id="footer-content">
        <?php
$end_time = microtime(TRUE);
 
$time_taken = $end_time - $start_time;
 
$time_taken = round($time_taken,4);
 
echo 'Page generated in '.$time_taken.' seconds.';    
?> <br/> All rights reserved by Sphinx Team (iACADEMY).
          <br/> <pre>Build number 01.0.060717.1731 (Beta)</pre>
      </div>
    </footer>
  </body>

  </html>