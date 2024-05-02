<?php
session_start();

//This is my CONTROLLER!


// Error Reporting
ini_set('display_errors',1);
error_reporting(E_ALL);



// Require the Autoload File
require_once ('vendor/autoload.php');

//instantiate the F3 Base Class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {


    $view = new Template();
    echo $view->render('views/homepage.html');

});

$f3->route('GET|POST /survey', function($f3) {

    global $mood;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //setting the survey answers to variables
        $name = $_POST["name"];
        $mood = $_POST["mood"];


        //assigning the vars to the session vars.
        $f3->set('SESSION.name', $name);
        $f3->set('SESSION.mood', $mood);


        $f3->reroute('summary');
    }
    else {
        $view = new Template();
        echo $view->render('views/survey.html');
    }

});

$f3->route('GET|POST /summary', function($f3) {
global $reply;

        if ($_SESSION['mood'] == "happy") {
            $reply = "I am happy that you selected 'happy'. Thank you for sharing.";
        } else if ($_SESSION['mood'] == "sad") {
            $reply = "I am sad that you selected 'sad'. Hope you feel better soon. Thank you for sharing.";
        } else if ($_SESSION['mood'] == "angry") {
            $reply = "Forgiveness is the answer. Thank you for sharing.";
        } else if ($_SESSION['mood'] == "excited") {
            $reply = "Do share what you are excited about. Thank you for using this form.";
        } else {
            $reply = "Thank you for sharing your name.";
        }

//    var_dump($_SESSION);

        $f3->set('SESSION.reply', $reply);


        $view = new Template();
        echo $view->render('views/summary.html');

});


//Run Fat-Free - invoking a method!
$f3->run();
