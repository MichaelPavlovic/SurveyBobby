<?php
date_default_timezone_set("America/Toronto");
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Survey Bobby</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel= "stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<body> -->

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-logo" href="#">&#129437</a>
      <a class="navbar-brand" href="#">Survey Bobby</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Profile</a></li>
      <li><a href="#">My Survey(s)</a></li>
	  <li><a href="#">New Survey</a></li>
      <li><a href="#">Log out</a></li>
    </ul>
    <form class="navbar-form navbar-left" action="/action_page.php">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</nav>
<div class="container">
  <h3>All surveys available to take</h3>
  
</div>
<div>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">S.no</th>
      <th scope="col">Survey Name</th>
      <th scope="col">Category</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Costco shopping</td>
      <td>Satisfaction</td>
      <td>Survey about Costco shopping satisfaction</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Web Development at Humber College</td>
      <td>Satisfaction</td>
      <td>Alumni satisfaction survey for Web Development program at humber college</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td >Corona Virus</td>
	  <td>Survey</td>
	  <td>Measures that you are taking to prevent Covid-19</td>
    </tr>
  </tbody>
</table>
</div>
</body>
</html>