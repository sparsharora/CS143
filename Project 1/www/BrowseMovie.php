<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title>Browse Movie</title>
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

  <h2 style="text-align:center; color:red;"> Browse Movie </h2> <br /><br />

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
    echo "Invalid Movie ID <br />";
  }
  else {
    $qry = "SELECT title, year, rating, company FROM Movie WHERE id=$uid";

    if (!($rs = $db->query($qry)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }

    $row=mysqli_fetch_row($rs);

    echo "TITLE:<br/><b>".$row[0]."</b><br/><br/>";
    echo "YEAR:<br/><b>".$row[1]."</b><br/><br/>";
    if($row[2]!="")
      echo "MPAA RATING:<br/><b>".$row[2]."</b><br/><br/>";
    else
      echo "MPAA RATING:<br/><b>N/A</b><br/><br/>";

    if($row[3]!="")
      echo "COMPANY PRODUCER:<br/><b>".$row[3]. "</b><br/><br/>";
    else
      echo "COMPANY PRODUCER:<br/><b>N/A</b><br/><br/>";

    $qry1 = "SELECT genre FROM MovieGenre WHERE mid=$uid";
    if (!($rs1 = $db->query($qry1)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }
    /*if(!$row1=mysqli_fetch_row($rs1))
    echo "GENRE:<br/><b>N/A</b><br/><br/>";
    else
    echo "GENRE:<br/><b>".$row1[0]."</b><br/><br/>";
*/
    $t1=1;
    $i0=1;
    while($row1 = mysqli_fetch_row($rs1))
    {
      $t1=0;
      if($i0==1)
      {
        echo "GENRE:<br/><b>".$row1[0]."";
        $i0=0;
      }
      else {
        echo ", ".$row1[0]."";
      }

    }

    if($t1==1)
      echo "GENRE: <b><br/>N/A<br/><br/>";
    else {

      echo "</b><br/><br/>";
    }

    $rs->free();

    $qry2 = "SELECT first, last FROM MovieDirector INNER JOIN Director ON MovieDirector.did = Director.id WHERE MovieDirector.mid = $uid;";

    if (!($rs2 = $db->query($qry2)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }
    $t2=1;
    $i1=1;
    while($row2 = mysqli_fetch_row($rs2))
    {
      $t2=0;
      if($i1==1)
      {
        echo "DIRECTOR:<br/><b>".$row2[0]." ".$row2[1]."";
        $i1=0;
      }
      else {
        echo ", ".$row2[0]." ".$row2[1]."";
      }

    }
    echo "</b>";

    if($t2==1)
      echo "DIRECTOR:<br/><b>N/A</b><br/>";
    else {
      echo "</b><br/>";
    }

    echo "<br/><u><b> ACTORS </b></u><br/><br/>";
    $qry3 = "SELECT id, first, last FROM MovieActor INNER JOIN Actor ON MovieActor.aid = Actor.id WHERE MovieActor.mid = $uid;";
    if (!($rs3 = $db->query($qry3)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }
    $t=1;
    while($row3 = mysqli_fetch_row($rs3))
    {
        $t=0;
        echo "<a href=\"BrowseActor.php?id=".$row3[0]."\">".$row3[1]." ".$row3[2]. "</a><br/>";
    }

    if($t==1)
      echo "N/A<br/>";
    $rs3->free();

    echo "<br/><br/><u><b> REVIEWS </b></u><br/><br/>";

    $avgQuery = "SELECT AVG(rating) FROM (SELECT rating FROM Review WHERE mid=$uid) AA;";
    $commentQuery = "SELECT comment, name, time FROM Review WHERE mid=$uid ORDER BY time DESC";

    if (!($rs55 = $db->query($avgQuery)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }

    $row55 = mysqli_fetch_row($rs55);
    if($row55[0]=="")
      echo "AVERAGE RATING:  <b><br/>N/A</b><br/><br/>";
    else
      echo "AVERAGE RATING:  <b><br/>".$row55[0]."</b><br/><br/>";


    echo "COMMENTS:  <br/><br/>";

    if (!($rs56 = $db->query($commentQuery)))
    {
        $errmsg = $db->error;
        print "$errmsg <br/>";
        exit(1);
    }

    $i56 = 0;
    $t56=1;
    while($row56 = mysqli_fetch_row($rs56))
    {
      $t56=0;
      echo "<i>'" .$row56[0]. "' </i>-     ".$row56[1].",     ".$row56[2];

      echo "<br/><br/>";
      $i56++;
  }


  if($t56==1)
    echo "<b>NO COMMENTS YET. </b> <br/>";

  $rs56->free();


  }

  $db->close();
  ?>
  <br/>
  <form action="addComment.php">
      <input type="submit" style="font-size:400%;" value="ADD COMMENT!">
  </form>

  </body>
  </html>
