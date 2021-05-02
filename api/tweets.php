<?php
    $conn = new mysqli("localhost", "tweetlytics", "", "tweetlytics");
    $conn2 = new mysqli("localhost", "tweetlytics", "", "tweetlytics"); // needed to get to work within prepared statement execution

    $offset = time()*1000;
    if(@(!empty($_GET["offset"]))) $offset = $_GET["offset"];
    $minViews = null;
    if(@(!empty($_GET["minimum_impressions"]))) $minViews = $_GET["minimum_impressions"];

    $tweets = [];

    if(@(!empty($_GET["tweet"]))) {
        $stmt = $conn->prepare("SELECT tweet_id, text, created_at, next_monitor FROM tweets WHERE tweet_id = ?");
        $stmt->bind_param("s", $_GET["tweet"]);
    }
    else if($minViews == null) {
        $stmt = $conn->prepare("SELECT tweet_id, text, created_at, next_monitor FROM tweets WHERE created_at < ? ORDER BY created_at DESC LIMIT 10;");
        $stmt->bind_param("i", $offset);
    }
    else {
        $stmt = $conn->prepare("SELECT tweet_id, text, created_at, next_monitor FROM tweets WHERE created_at < ? AND (SELECT impressions FROM tweet_metrics WHERE tweet = tweet_id ORDER BY timestamp DESC LIMIT 1) > ? ORDER BY created_at DESC LIMIT 10;");
        $stmt->bind_param("ii", $offset, $minViews);
    }
    $stmt->execute();
    $stmt->bind_result($tweetTmp["id"], $tweetTmp["text"], $tweetTmp["created_at"], $tweetTmp["next_monitor"]);
    while($stmt->fetch()) {
        $tweet = ["id" => $tweetTmp["id"], "text" => $tweetTmp["text"], "created_at" => $tweetTmp["created_at"], "next_monitor" => $tweetTmp["next_monitor"], "metrics" => []];
        $metricsRes = $conn2->query("SELECT timestamp, retweets, quotes, likes, replies, impressions, profile_clicks FROM tweet_metrics WHERE tweet = " .$tweet["id"]. " ORDER BY timestamp DESC;");
        while($metric = $metricsRes->fetch_assoc()) {
            $tweet["metrics"][] = ["timestamp" => $metric["timestamp"], "retweets" => $metric["retweets"], "quotes" => $metric["quotes"], "likes" => $metric["likes"], "replies" => $metric["replies"], "impressions" => $metric["impressions"], "profile_clicks" => $metric["profile_clicks"]];
        }
        $tweets[] = $tweet;
    }
    $stmt->close();

    die(json_encode($tweets));