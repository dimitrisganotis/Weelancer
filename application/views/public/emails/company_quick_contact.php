<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Job Quick Contact</title>

  <style>
    html {
      background-color: lightgrey!important;
    }

    body {
      max-width: 600px!important;
      margin: 100px auto!important;
      padding: 15px 25px!important;
      border-radius: 15px!important;
      background-color: white!important;
      color: black!important;
    }

    header {
      text-align: center!important;
      border-bottom: #25AD60 thin solid!important;
      padding-bottom: 5px!important;
    }

    main {
      padding: 15px!important;
    }

    p {
      font-size: 1.1em!important;
    }

    .button > a {
      display: block!important;
      padding: 15px!important;
      border-radius: 15px!important;
      background-color: #25AD60!important;
      color: white!important;
      font-weight: bold!important;
      text-align: center!important;
    }

    .link {
      max-width: 570px!important; 
      word-wrap: break-word!important;
    }

    footer {
      text-align: center!important;
      border-top: #25AD60 thin solid!important;
      padding-top: 10px!important;
    }

    small {
      font-size: 0.9em!important;
    }

  </style>
</head>
<body>
  <header>
    <h1>Weelancer - Quick Contact</h1>
  </header>

  <main>
    <p><?php echo 'Name: '.$username.'<br>Email: '.$email.'<br>Message: <br><br>'.$message; ?></p>
  </main>

  <footer>
    <small>Weelancer.com &copy; <?php echo date("Y"); ?>. All Rights Reserved</small>
  </footer>
</body>
</html>