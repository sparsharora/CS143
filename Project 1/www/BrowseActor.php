<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title>Browse Actor</title>
</header>

<body>

  <div class="topnav">
  <a href="ActorDirector.php">Add Actor/Director information</a>
  <a href="Movie.php">Add Movie information</a>
  <a href="addComment.php">Add comments</a>
  <a href="ActorMovie.php">Add Actor-Movie relations</a>
  <a href="MovieDirector.php">Add Director-Movie relations</a>
  <a class="active" href="Search.php">Search Page</a>
  </div>

  <h2 style="text-align:center; color:red;"> Browse Actor </h2> <br /><br />

  <?php

  //We establish a connection first
  $db = new mysqli('localhost', 'cs143', '', 'CS143');


  if($db->connect_errno > 0)
  {
      die('Unable to connect to database [' . $db->connect_error . ']');
  }

  $uid=$_GET["id"];

  if($uid=="")
  {
    echo "Invalid Actor ID <br />";
  }
  else {
    $qry = "SELECT first, last, sex, dob, dod FROM Actor WHERE id=$uid";

    if (!($rs = $db->query($qry)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }

    $row=mysqli_fetch_row($rs);

    echo "NAME:<br/><b>".$row[0]." ".$row[1]."</b><br/><br/>";
    echo "SEX:<br/><b>".$row[2]."</b><br/><br/>";
    echo "DATE OF BIRTH:<br/><b>".$row[3]."</b><br/><br/>";
    if($row[4]=="")
      echo "DATE OF DEATH:<br/><b> N/A </b><br/><br/>";
    else
      echo "DATE OF DEATH:<br/><b> ".$row[4]."</b><br/><br/>";

    $rs->free();

    echo "<br/><br/><u><b> MOVIES </b></u><br/><br/>";

    $qry1 = "SELECT id, title FROM Movie INNER JOIN (SELECT mid FROM Actor INNER JOIN MovieActor WHERE MovieActor.aid = Actor.id AND Actor.id = $uid) A ON Movie.id = A.mid ORDER BY title ASC;";

    if (!($rs1 = $db->query($qry1)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }

    $t=1;

    while($row1 = mysqli_fetch_row($rs1))
    {
        $t=0;
        echo "<a href=\"BrowseMovie.php?id=".$row1[0]."\">".$row1[1]. "</a><br/>";
    }

    if($t==1)
      echo "N/A<br/>";

  }

  $db->close();




     ?>




    </body>
  </html>
