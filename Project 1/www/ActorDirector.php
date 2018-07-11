<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title>Add Actor/Director</title>
</header>

<body>

  <!-- Navigation Bar for every page-->
  <div class="topnav">
  <a class="active" href="ActorDirector.php">Add Actor/Director information</a>
  <a href="Movie.php">Add Movie information</a>
  <a href="addComment.php">Add comments</a>
  <a href="ActorMovie.php">Actor-Movie relations</a>
  <a href="MovieDirector.php">Director-Movie relations</a>
  <a href="Search.php">Search Page</a>
  </div>

  <h2 style="text-align:center; color:red;"> Add an Actor or Director to the database </h2> <br /><br />

  <form action="ActorDirector.php" method="GET">
    Choose a Field to add to: <br />
    <input type="radio" name="field" value="Actor" checked> Actor
    <input type="radio" name="field" value="Director"> Director <br /><br />

    First Name:<br />
    <input type="text" name="first" maxlength="20"> <br /><br />

    Last Name:<br />
    <input type="text" name="last" maxlength="20"> <br /><br />

    Sex:<br />
    <input type="radio" name="sex" value="Male" checked> Male
    <input type="radio" name="sex" value="Female"> Female <br /><br />

    Date of Birth: <br />
    (format: YYYY-MM-DD)<br />
    <input type="text" name="dob" maxlength="20"> <br /><br />

    Date of Death: <br />
    (format: YYYY-MM-DD, leave blank if still alive)<br />
    <input type="text" name="dod" maxlength="20"> <br /><br /><br />

    <input type="submit" VALUE="Submit" /><br />

  </form>

  <?php

  //We establish a connection first
  $db = new mysqli('localhost', 'cs143', '', 'CS143');

  if($db->connect_errno > 0)
  {
      die('Unable to connect to database [' . $db->connect_error . ']');
  }


  //Get input

    $i1field = $_GET["field"];
    $i1first = trim($_GET["first"]);
    $i1last = trim($_GET["last"]);
    $i1sex = $_GET["sex"];
    $i1dob = $_GET["dob"];
    $i1dod = $_GET["dod"];

    if($i1field=="" && $i1first=="" && $i1last=="" && $i1sex=="" && $i1dob=="" && $i1dod=="")
    {
      echo "";
    }
    else if($i1first=="" || $i1last=="")
    {
      echo "Please enter a valid first and last name";
    }
    else if($i1dob=="")
    {
      echo "Please enter a valid Date of Birth";
    }
    else {

      //Update MaxPersonID and set new ID for person

      if (!($rs = $db->query("UPDATE MaxPersonID SET id=id+1;")))
      {
          $errmsg = $db->error;
          print "$errmsg <br/>";
          exit(1);
      }

      if (!($rs = $db->query("SELECT id FROM MaxPersonID;")))
      {
          $errmsg = $db->error;
          print "$errmsg <br/>";
          exit(1);
      }

      $row = mysqli_fetch_row($rs);
      $nid = $row[0];

      if($i1field=="Actor")
      {
        if($i1dod=="")
          $qry = "INSERT INTO Actor VALUES('$nid', '$i1last','$i1first', '$i1sex', '$i1dob', NULL);";
        else
          $qry = "INSERT INTO Actor VALUES('$nid', '$i1last','$i1first', '$i1sex', '$i1dob', '$i1dod');";
      }
      else
      {
        if($i1dod=="")
            $qry = "INSERT INTO Director VALUES('$nid', '$i1last','$i1first', '$i1dob', NULL);";
        else
            $qry = "INSERT INTO Director VALUES('$nid', '$i1last','$i1first', '$i1dob', '$i1dod');";
      }

      if (!($rs = $db->query($qry)))
      {
          $errmsg = $db->error;
          print "$errmsg <br/>";
          exit(1);
      }

    }

    $rs->free();
    $db->close();
    ?>

  </body>
</html>
