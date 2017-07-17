<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Menu</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.min.css">
    <style></style>
  </head>
  <body>
    <nav id="navBar">
      <ul id="menu">
        <h4 id="userId"><?php echo(isset($_SESSION["userId"]) ? $_SESSION["userId"] : ""); ?></h4>
        <?php echo(isset($_SESSION["userId"]) && !empty($_SESSION["userRole"]) ? "<a id='logOut' href='signout.php'><i class='fa fa-sign-out' aria-hidden='true'>Logout</i></a>" : ""); ?>
        <li><a href="index.php">Home</a></li>
        <?php echo(isset($_SESSION["userId"]) && !empty($_SESSION["userRole"]) ? "<li><a href='index.php'>Show Training Sessions</a></li>" : ""); ?>
        <?php echo(isset($_SESSION["userId"]) && !empty($_SESSION["userRole"]) ? "<li><a href='list.php'>Show Student List</a></li>" : ""); ?>
        <?php echo(isset($_SESSION["userId"]) && ($_SESSION["userRole"] == "admin") ? "<li><a href='add.php'>Add a Student</a></li>" : ""); ?>
        <?php echo(!isset($_SESSION["userId"]) ? "<li><a href='signup.php'>Sign Up</a></li>" : ""); ?>
        <?php echo(!isset($_SESSION["userId"]) ? "<li><a href='signin.php'>Sign In</a></li>" : ""); ?>
        <li><form action="list.php"><input type="text" name="search" placeholder="Search"></form>
      </ul>
    </nav>

    <article>
      <section>
