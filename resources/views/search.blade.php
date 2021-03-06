<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style type="text/css">
          .login-box {
              margin-top: 100px;
              padding: 20px;
              border-radius: 5px;
              box-shadow: 0 0 4px rgba(0,0,0,0.25);
          }
        </style>
    </head>
    <body>
        <div class="container">
          <div class="row">
            <div class="col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4 ">
              <div class="login-box">
                <div class="login-box-header">
                </div>
                <h3 class="text-center">Login</h3>

                <div class="login-box-inner">
                  <form action=""  method="POST" role="form" class="form-horizontal">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control e" placeholder="Email Address" required autofocus>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control p" placeholder="Password" required>
                    </div>
                    <input id="" type="hidden" name="urlPath" value="" class="form-control p" placeholder="">
                    <div class="form-group">
                      <div class="text-center">
                        <button type="submit" class="btn btn-submit-continue">Login</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
    </body>
</html>
