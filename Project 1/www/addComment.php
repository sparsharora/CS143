<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title> Add Comment</title>
</header>

<body>

  <div class="topnav">
  <a href="ActorDirector.php">Add Actor/Director information</a>
  <a href="Movie.php">Add Movie information</a>
  <a class="active" href="addComment.php">Add comments</a>
  <a href="ActorMovie.php">Actor-Movie relations</a>
  <a href="MovieDirector.php">Director-Movie relations</a>
  <a href="Search.php">Search Page</a>
  </div>
  <h2 style="text-align:center; color:red;"> Leave a comment for a movie </h2> <br /><br />

  <form action="addComment.php" method="GET">

    Name:
    <input type="text" name="name" maxlength="20"> <br /><br />


    <?php

    //We establish a connection first
    $db = new mysqli('localhost', 'cs143', '', 'CS143');

    if($db->connect_errno > 0)
    {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    if (!($rs5 = $db->query("SELECT id, title, year FROM Movie ORDER BY title ASC;")))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }

    $opts5="";

    while($row5=mysqli_fetch_row($rs5))
    {

      $p5mid=$row5[0];
      $p5title=$row5[1];
      $p5year=$row5[2];
      $opts5.="<option value=\"$p5mid\">".$p5title." [".$p5year."]</option>";
    }
    ?>
    Movie Title:<br />
    <select name="title"><?=$opts5?></select><br/><br/>


    Rating:
    <select  class="form-control" name="rating">
        <option value=""> </option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    <br /><br />

    Comments:<br />
    <textarea class="form-control" name="comment" rows="5"  placeholder="500 characters limit" ></textarea><br /><br /><br /><br />

    <input type="submit" VALUE="Submit" /><br />
  </form>



  <?php




  //Get input

    $i1name = $_GET["name"];
    $i1title = $_GET["title"];
    $i1rating = $_GET["rating"];
    $i1comment = $_GET["comment"];


    if($i1name=="" && $i1title=="" && $i1rating=="" && $i1comment=="")
    {
      echo "";
    }
    else if($i1name=="")
    {
      echo "Please enter a valid name";
    }
    else if($i1title=="")
    {
      echo "Please enter a movie title";
    }
    else if($i1rating=="")
    {
      echo "Please enter a rating between 0-5";
    }

    else
    {

       $query= "INSERT INTO Review VALUES ('$i1name', CURRENT_TIMESTAMP(), '$i1title', '$i1rating', '$i1comment');";



      if (!($rs = $db->query($query)))
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
