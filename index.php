<?php
include 'handler.php';
include 'render.php';

$isCorrectData = true;
$activeLetter = 'A';
$contacts = array();

$render = new rendering();
$handler = new handler();
$html = $render->login();
if(isset($_POST['LoginEmail']) && isset($_POST['LoginPassword'])
                && $_POST['LoginEmail'] !== "" && $_POST['LoginPassword'] !== "")
{
    $isCorrectData = $handler->handler_login($_POST['LoginEmail'], $_POST['LoginPassword']);
    if(!$isCorrectData) {
        $html = $render->login($isCorrectData);
    }
}
if(isset($_POST['ToSigninButton']))
{
   $html = $render->registration($isCorrectData);
}
if(isset($_POST['regName']) && isset($_POST['regEmail']) && isset($_POST['regPassword']))
{
    $isCorrectData = $handler->handler_registration($_POST['regEmail'], $_POST['regName'], $_POST['regPassword']);
    $html = $render->login();
    //if(!$isCorrectData) {
      //  $html = $render->login();
    //}
}
if(isset($_POST['exitButton']))
{
    $handler->handler_exit();
}
if(isset($_POST['letter']))
{
    $activeLetter = $_POST['letter'];
}
if(isset($_POST['addContact']))
{
    $activeLetter = $handler->handler_add_contact();
}
if(isset($_POST['corectContact']))
{
    $activeLetter = $handler->hendler_edit_contact();
}
if(isset($_POST['deleteContact']))
{
    $handler->handler_delete($_POST['deleteContact']);
}
if(isset($_SESSION['name']))
{
    $contacts = $handler->handler_tab($activeLetter);
    if(isset($_POST['find']))
    {
        if(isset($_POST['fio'])){
           $contacts = $handler->handler_find_on_fio();
        }
        if(isset($_POST['place_of_work'])){
           $contacts = $handler->handler_find_on_work();
        }
        if(isset($_POST['email'])){
            $contacts = $handler->handler_find_on_email();
        }
        $activeLetter = 1;
    }
    $html = $render->main_rendering($activeLetter,$contacts);
}
print $html;

