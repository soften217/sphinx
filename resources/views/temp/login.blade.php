@extends('layouts.app') @section('content')
<html>
<style>
  /* Full-width input fields */
  
  input[type=text],
  input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }
  /* Set a style for all buttons */
  
  button {
    background-color: #66AAFF;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
  }
  
  button:hover {
    opacity: 0.8;
  }
  /* Extra styles for the cancel button */
  
  .cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
  }
  /* Center the image and position the close button */
  
  .imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
  }
  
  img.avatar {
    width: 40%;
    border-radius: 50%;
  }
  
  .container {
    padding: 16px;
  }
  
  span.psw {
    float: right;
    padding-top: 16px;
  }
  /* The Modal (background) */
  
  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
    padding-top: 60px;
  }
  /* Modal Content/Box */
  
  .modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto;
    /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 30%;
    /* Could be more or less, depending on screen size */
  }
  /* The Close Button (x) */
  
  .close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
  }
  
  .close:hover,
  .close:focus {
    color: red;
    cursor: pointer;
  }
  /* Add Zoom Animation */
  
  .animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
  }
  
  @-webkit-keyframes animatezoom {
    from {
      -webkit-transform: scale(0)
    }
    to {
      -webkit-transform: scale(1)
    }
  }
  
  @keyframes animatezoom {
    from {
      transform: scale(0)
    }
    to {
      transform: scale(1)
    }
  }
  
  @media screen and (max-width: 300px) {
    /* Change styles for span and cancel button on extra small screens */
    span.psw {
      display: block;
      float: none;
    }
    .cancelbtn {
      width: 100%;
    }
  }
  /*   .welcomePage {
    padding-top: 15%;
    padding-bottom: 15%;
    padding-left: 40%;
    padding-right: 40%;
  } */
  
  .welcomePageAlign {
    border: solid 2px skyblue;
    height: 30%;
    width: 40%;
    margin 100%;
    align: center;
  }
  
  .container6 {
    height: 5em;
    display: flex;
    align-items: center;
    justify-content: center
  }
  
  .container6 {
    margin: 0
  }
</style>

<body>
  <div class="welcomePageAlign">
    <div class="container6">

      <h2>Welcome to iQUIZ</h2>

    </div>
    <div class="container6">

      <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

    </div>
  </div>
  <div id="id01" class="modal">

    <form class="modal-content animate" role="form" method="POST" action="{{ url('/login') }}">
      {{ csrf_field() }}
      <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="img_avatar2.png" alt="Avatar" class="avatar">
      </div>

      <div class="container">

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email">E-Mail Address</label>

          <input id="email" type="email" name="email" value="{{ old('email') }}"> @if ($errors->has('email'))
          <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span> @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
          <label for="password" class="col-md-4 control-label">Password</label>

          <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password"> @if ($errors->has('password'))
            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span> @endif
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
          <div class="checkbox">
            <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
          <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

          <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
        </div>
      </div>
    </form>
  </div>

  <script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>

</html>

@endsection