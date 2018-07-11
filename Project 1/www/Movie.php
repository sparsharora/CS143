<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title>Add Movie information</title>
</header>

<body>

  <!-- Navigation Bar for every page-->
  <div class="topnav">
  <a href="ActorDirector.php">Add Actor/Director information</a>
  <a class="active" href="Movie.php">Add Movie information</a>
  <a href="addComment.php">Add comments</a>
  <a href="ActorMovie.php">Actor-Movie relations</a>
  <a href="MovieDirector.php">Director-Movie relations</a>
  <a href="Search.php">Search Page</a>
  </div>

  <h2 style="text-align:center; color:red;"> Add a Movie to the database </h2> <br /><br />

  <form action="Movie.php" method="GET">
    Enter the Movie Title: <br />
    <input type="text" name="title" maxlength="100"> <br /><br />

    Year of Release: <br />
    (format: YYYY)<br />
    <input type="text" name="yr"> <br /><br />

    Rating (MPAA):<br />
    <select name="rating">
      <option value="PG-13" selected="selected">PG-13</option>
      <option value="R">R</option>
      <option value="G">G</option>
      <option value="PG">PG</option>
      <option value="NC-17">NC-17</option>
      <option value="NR">NR</option>
    </select><br /><br />

    Company:<br />
    <input type="text" name="cmp" maxlength="50"> <br /><br />

    Genre:<br />
      <input type="checkbox" name="genre[]" value="" selected="selected">Action
      <input type="checkbox" name="genre[]" value="Adventure">Adventure
      <input type="checkbox" name="genre[]" value="Animated">Animated
      <input type="checkbox" name="genre[]" value="Biography">Biography
      <input type="checkbox" name="genre[]" value="Comedy">Comedy
      <input type="checkbox" name="genre[]" value="Crime">Crime
      <input type="checkbox" name="genre[]" value="Documentary">Documentary
      <input type="checkbox" name="genre[]" value="Drama">Drama
      <input type="checkbox" name="genre[]" value="Family">Family
      <input type="checkbox" name="genre[]" value="Fantasy">Fantasy<br/>
      <input type="checkbox" name="genre[]" value="Historical Drama">Historical Drama
      <input type="checkbox" name="genre[]" value="Horror">Horror
      <input type="checkbox" name="genre[]" value="Kids">Kids
      <input type="checkbox" name="genre[]" value="Musical">Musical
      <input type="checkbox" name="genre[]" value="Romance">Romance
      <input type="checkbox" name="genre[]" value="Romantic Comedy">Romantic Comedy
      <input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi
      <input type="checkbox" name="genre[]" value="Thriller">Thriller
      <input type="checkbox" name="genre[]" value="War">War
      <input type="checkbox" name="genre[]" value="Western">Western
    </select><br /><br />

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

    $i2title = $_GET["title"];
    $i2yr = $_GET["yr"];
    $i2rate = $_GET["rating"];
    $i2cmp = $_GET["cmp"];
    $i2gen = $_GET["genre"];


    if($i2title=="" && $i2yr=="" && $i2rate=="" && $i2cmp=="" && $i2gen=="")
    {
      echo "";
    }
    else if($i2title=="")
    {
      echo "Please enter a valid Movie title";
    }
    else if($i2cmp=="")
    {
      echo "Please enter a valid Company name";
    }
    else if($i2yr=="" || $i2yr>2018 || $i2yr<0)
    {
      echo "Please enter a valid Release year";
    }
    else {

      //Update MaxPersonID and set new ID for person

      if (!($rs = $db->query("UPDATE MaxMovieID SET id=id+1;")))
      {
          $errmsg = $db->error;
          print "$errmsg <br/>";
          exit(1);
      }

      if (!($rs = $db->query("SELECT id FROM MaxMovieID;")))
      {
          $errmsg = $db->error;
          print "$errmsg <br/>";
          exit(1);
      }

      $row = mysqli_fetch_row($rs);
      $nid = $row[0];

      $qry = "INSERT INTO Movie VALUES('$nid', '$i2title','$i2yr', '$i2rate', '$i2cmp');";

      if (!($rs = $db->query($qry)))
      {
          $errmsg = $db->error;
          print "$errmsg <br/>";
          exit(1);
      }

      for($k=0;$k<count($i2gen);$k++)
      {
        $qry1 = "INSERT INTO MovieGenre VALUES('$nid', '$i2gen[$k]');";


        if (!($rs1 = $db->query($qry1)))
        {
            $errmsg = $db->error;
            print "$errmsg <br/>";
            exit(1);
        }
      }

    }


    $db->close();
    ?>

  </body>
</html>
