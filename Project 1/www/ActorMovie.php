<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title>Actor/Movie relations</title>
</header>

<body>

  <div class="topnav">
  <a href="ActorDirector.php">Add Actor/Director information</a>
  <a href="Movie.php">Add Movie information</a>
  <a href="addComment.php">Add comments</a>
  <a class="active" href="ActorMovie.php">Add Actor-Movie relations</a>
  <a href="MovieDirector.php">Add Director-Movie relations</a>
  <a href="Search.php">Search Page</a>
  </div>

  <h2 style="text-align:center; color:red;"> Add an Actor to Movie relation to the database </h2> <br /><br />

  <form action="ActorMovie.php" method="GET">
  <?php

  //We establish a connection first
  $db = new mysqli('localhost', 'cs143', '', 'CS143');


  if($db->connect_errno > 0)
  {
      die('Unable to connect to database [' . $db->connect_error . ']');
  }



  if (!($rs1 = $db->query("SELECT id, first, last FROM Actor ORDER BY first, last ASC;")))
  {
      $errmsg = $db->error;
      print "$errmsg <br/>";
      exit(1);
  }

  $opts="";

  while($row=mysqli_fetch_row($rs1))
  {

    $i4last=$row[2];
    $i4first=$row[1];
    $i4aid=$row[0];
    $opts.="<option value=\"$i4aid\">".$i4first." ".$i4last."</option>";
  }

  if (!($rs2 = $db->query("SELECT id, title, year FROM Movie ORDER BY title ASC;")))
  {
      $errmsg = $db->error;
      print "$errmsg <br/>";
      exit(1);
  }

  $opts1="";

  while($row1=mysqli_fetch_row($rs2))
  {

    $i4mid=$row1[0];
    $i4title=$row1[1];
    $i4year=$row1[2];
    $opts1.="<option value=\"$i4mid\">".$i4title." [".$i4year."]</option>";
  }

  $rs1->free();
  $rs2->free();

    ?>

    Select an Actor: <br />
    <select name="Actor"><?=$opts?></select><br/><br/>

    Select the Movie that the Actor was in: <br />
    <select name="Movie"><?=$opts1?></select><br/><br/>

    Enter the Actor's Role in the movie (eg: Doorman, Charlie, Mad Hatter): <br />
    <input type="text" name="role" maxlength="50"> <br /><br />

    <input type="submit" VALUE="Submit" /><br />

    </form>

    <?php

    //Get input

      $i4role = $_GET["role"];
      $aid = $_GET["Actor"];
      $mid = $_GET["Movie"];

      if($i4role=="" && $aid=="" && $mid=="")
      {
        echo "";
      }
      else if($i4role=="")
      {
        echo "Please enter a valid role for the Actor";
      }
      else if($aid=="")
      {
        echo "Please select an Actor from the list";
      }
      else if($mid=="")
      {
        echo "Please select a Movie from the list";
      }
      else {

        //Update MaxPersonID and set new ID for person

        $qry = "INSERT INTO MovieActor VALUES('$mid', '$aid','$i4role');";

        if (!($rs = $db->query($qry)))
        {
            $errmsg = $db->error;
            print "$errmsg <br/>";
            exit(1);
        }
      }


$db->close();




   ?>




  </body>
</html>
