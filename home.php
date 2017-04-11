<?php
    session_start();
spl_autoload_register(function($class){
    include_once("classes/" . $class . ".php");
});
    //stuur de gebruiker weg als ze niet zijn ingelogd
    if( isset( $_SESSION['user'] ) ){
    }
    else {
        header('Location: signin.php');
    }


//TOPICS
try {
    //1. kijken of gebruiker nog geen topics heeft
    if (!isset($_SESSION['topics'])) {
        //2. indien JA: 5 topics die het meeste voorkomen in user_topics tabel uitlezen als object
        $topicArray = [];
        $conn = Db::getInstance();
        //normaal in 1 statement maar dit wordt niet ondersteund -> in 2 gesplitst
        $statement1 = $conn->prepare("SELECT topics_ID FROM `users_topics` GROUP BY topics_ID ORDER BY count(*) DESC LIMIT 5");
        $statement1->execute();
        while($res = $statement1->fetch(PDO::FETCH_ASSOC)){
            $id = $res['topics_ID'];
            $statement2 = $conn->prepare("SELECT * from `topics` where id = :id");
            $statement2->bindValue(":id", (int)$id);
            $statement2->execute();
            $topic = $statement2->fetch(PDO::FETCH_OBJ);
            //3. topics in array steken
            $topicArray[] = $topic;
        }

    }
//4. ZIE chooseTopics.php !!

//5. indien topics gekozen -> topics in databank steken
    if (isset($_POST['selectedTopics'])) {
        $selectedTopics = $_POST['selectedTopics'];
        for ($i = 0; $i <= count($selectedTopics); $i++) {
            $usertopic = new Topics();
            $usertopic->id = $selectedTopics[$i];
            $usertopic->saveUserTopic();
        }
        //6. alle topics van user in session steken
        $user = new User;
        $user->Email = $_SESSION['user'];
        $user->getUserTopics();
    }


//7. ZIE userHome.php !!
}
catch (Exception $e) {
    $error= $e->getMessage();
}


//indien de gebruiker nog geen topics heeft
/*if (!isset($_SESSION['topics'])) {
    $topicArray = [];

    // alle topics uit databank halen en in topicArray steken
    $conn = Db::getInstance();
    $statement = $conn->prepare("SELECT * FROM `topics`");
    $statement->execute();
    $res = $statement->rowCount();

    for ($i = 1; $i < $res; $i++) {
        $topic = $i;
        $topic = new Topics;
        $topic->getTopic($i);
        array_push($topicArray, $topic);
    }
}*/



//kijken of de gebruiker topics gekozen heeft
/*if (isset($_POST['selectedTopics'])) {
    $selectedTopics = $_POST['selectedTopics'];
    for ($i = 0; $i <= count($selectedTopics); $i++) {
        $usertopic = new Topics();
        $usertopic->name = $selectedTopics[$i];
        $usertopic->saveUserTopic();
        $_SESSION['topics'][] = $usertopic;
    }
}*/



//TODO: topics bijvoegen
// topic toevoegen = mee in databank steken + automatisch bij session invoegen
// -> 1 functie: array met gekozen topics -> in databank -> databank opnieuw uitlezen -> session refreshen => AJAX??
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/npm.js"></script>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/signup-style.css">
    <link rel="stylesheet" href="css/topics.css">

    <link href="https://fonts.googleapis.com/css?family=Nova+Oval" rel="stylesheet">

    <title>IMDterest | Home</title>
</head>
<body>

<?php include_once('header.inc.php'); ?>
<div class="container">
<?php if(isset($error)){
    echo $error;

}?>
    <?php

    if(isset($_SESSION['topics'])){
        include_once('userHome.php');
    }
    else{
        include_once('chooseTopics.php');
    }

    ?>

</div>

</body>
</html>