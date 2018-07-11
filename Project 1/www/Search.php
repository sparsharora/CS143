<html>
<header>
  <link rel="stylesheet" href="pages.css" />
  <title>Search Page</title>
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

  <h2 style="text-align:center; color:red;"> Search for an Actor or Movie in the database </h2> <br /><br />

  <form action="Search.php" method="GET">

    Enter an Actor, Actress or Movie: <br />
    <input type="text" name="enter" maxlength="200"> <br /><br />

    <input type="submit" VALUE="Submit" /><br />

  </form>

  <?php

  //We establish a connection first
  $db = new mysqli('localhost', 'cs143', '', 'CS143');


  if($db->connect_errno > 0)
  {
      die('Unable to connect to database [' . $db->connect_error . ']');
  }

  $s1in = $_GET["enter"];
  $store=explode(" ",$s1in);

  if($s1in=="")
  {
    echo "";
  }
  else {

    $qry = "SELECT id, first, last, dob FROM Actor WHERE (first like '%$store[0]%' OR last like '%$store[0]%')";


    $i=1;
    while($i<count($store))
    {
      $curr = $store[$i];
      $qry=$qry." AND (first like '%$store[$i]%' OR last like '%$store[$i]%')";
      $i++;
    }
    $qry=$qry."ORDER BY first ASC;";



    if (!($rs1 = $db->query($qry)))
    {
      $errmsg = $db->error;
      print "$errmsg <br/>";
      exit(1);
    }

    echo "Actors: <br /><br />";

    while($row = mysqli_fetch_row($rs1))
    {
      echo "<a href=\"BrowseActor.php?id=".$row[0]."\">".$row[1]." ".$row[2]." (".$row[3].")</a><br/>";
    }

    echo "<br /><br />";
    //-------

    $qry1 = "SELECT id, title, year FROM Movie WHERE (title like '%$store[0]%')";


    $j=1;
    while($j<count($store))
    {
      $qry1=$qry1." AND (title like '%$store[$j]%')";
      $j++;
    }
    $qry1=$qry1."ORDER BY title ASC;";

    if (!($rs = $db->query($qry1)))
    {
      $errmsg = $db->error;
      print "$errmsg <br/>";
      exit(1);
    }

    echo "Movies: <br /><br />";

    while($row1= mysqli_fetch_row($rs))
    {
      echo "<a href=\"BrowseMovie.php?id=".$row1[0]."\">".$row1[1]." (" .$row1[2].")</a><br/>";
    }



}
$rs1->free();
$rs->free();
$db->close();
?>

</body>
</html>
