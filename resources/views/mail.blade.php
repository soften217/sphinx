@extends('layouts.app')

@section('content')

<?php
$to = "jeian.nueva@jeiannueva.pw";
// $to = "jmccasusi@gmail.com";
$subject = "iQUIZ Inquiry/Request for Help";
$txt = "Hello world!";
$headers = "From: jeian.nueva@gmail.com";

// mail($to,$subject,$txt,$headers);
?>

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
  
  input[type=email] {
        border: 1px solid gray;
        border-radius: 4px;
        width: 100%;
        padding: 10px;
        float: left;
        font-size: 16px;
      }
  
  .textarea {
        border: 1px solid gray;
        border-radius: 4px;
        width: 100%;
        padding: 10px;
        float: left;
        font-size: 16px;
      }
        </style>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Help - Send Email</b></div>

                <div class="panel-body container1">
            <div class="content">
                    <form method="post" action="./help">
                      <table>
                          {{ csrf_field() }}
<!--                         <col width="20%">
                      <col width="80"> -->
                        <tr style="padding:15px;">
                          <td style="padding:15px;">To: </td>
                          <td style="padding:15px;"><input id='to' name='to' type='email' value='<?php echo $to ?>' disabled/></td>
                        </tr>
                        <tr style="padding:15px;">
                          <td style="padding:15px;">Subject: </td>
                          <td style="padding:15px;"><input id='subject' name='subject' type='text' value='<?php echo $subject ?>' disabled/></td>
                        </tr>
                        <tr style="padding:15px;">
                          <td style="padding:15px;"> Message </td>
                          <td style="padding:15px;"><textarea id='message' name="message" cols="100" rows="10"></textarea></td>
                        </tr>
                        
                      </table>
                        <button type="submit" value="Submit">Submit</button>
                      
                    </form>
          </div>
        </div>
            </div>
        </div>
    </div>
</div>


@endsection
