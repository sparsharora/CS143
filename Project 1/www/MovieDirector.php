<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title>Director/Movie relations</title>
</header>

<body>

  <div class="topnav">
  <a href="ActorDirector.php">Add Actor/Director information</a>
  <a href="Movie.php">Add Movie information</a>
  <a href="addComment.php">Add comments</a>
  <a href="ActorMovie.php">Add Actor-Movie relations</a>
  <a class="active" href="MovieDirector.php">Add Director-Movie relations</a>
  <a href="Search.php">Search Page</a>
  </div>

  <h2 style="text-align:center; color:red;"> Add a Director to Movie relation to the database </h2> <br /><br />

  <form action="MovieDirector.php" method="GET">
  <?php

  //We establish a connection first
  $db = new mysqli('localhost', 'cs143', '', 'CS143');


  if($db->connect_errno > 0)
  {
      die('Unable to connect to database [' . $db->connect_error . ']');
  }



  if (!($rs1 = $db->query("SELECT id, title, year FROM Movie ORDER BY title ASC;")))
  {
      $errmsg = $db->error;
      print "$errmsg <br/>";
      exit(1);
  }

  $opts="";

  while($row=mysqli_fetch_row($rs1))
  {

    $i5mid=$row[0];
    $i5title=$row[1];
    $i5year=$row[2];
    $opts.="<option value=\"$i5mid\">".$i5title." [".$i5year."]</option>";
  }

  if (!($rs2 = $db->query("SELECT id, first, last FROM Director ORDER BY first,last ASC;")))
  {
      $errmsg = $db->error;
      print "$errmsg <br/>";
      exit(1);
  }

  $opts1="";

  while($row1=mysqli_fetch_row($rs2))
  {

    $i5did=$row1[0];
    $i5first=$row1[1];
    $i5last=$row1[2];
    $opts1.="<option value=\"$i5did\">".$i5first." ".$i5last."</option>";
  }

  $rs1->free();
  $rs2->free();

    ?>

    Select a Movie: <br />
    <select name="Movie"><?=$opts?></select><br/><br/>

    Select the Director: <br />
    <select name="Director"><?=$opts1?></select><br/><br/>


    <input type="submit" VALUE="Submit" /><br />

    </form>

    <?php

    //Get input

      $i5mid = $_GET["Movie"];
      $i5did = $_GET["Director"];

      if($i5mid=="" && $i5did=="")
      {
        echo "";
      }
      else if($i5mid=="" || $i5did=="")
      {
        echo "Please select a Movie or Director from the list";
      }
      else {

        //Update MaxPersonID and set new ID for person

        $qry = "INSERT INTO MovieDirector VALUES('$i5mid', '$i5did');";

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
