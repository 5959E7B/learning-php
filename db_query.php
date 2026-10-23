<?php
    $hostname = "localhost";
    $username = "testing";
    $password = "correct horse battery staple";
    $database_name = "testing";

    $db = mysqli_connect($hostname, $username, $password, $database_name);

    $result = mysqli_query($db, "SELECT username, comment FROM comments JOIN users ON (comments.user_id = users.id) ORDER BY comments.id ASC LIMIT 10;");
    
    foreach ($result->fetch_all() as $i) {
        foreach ($i as $k) {
            print($k . "\t");
        }
        print("\n");
    }
 ?>