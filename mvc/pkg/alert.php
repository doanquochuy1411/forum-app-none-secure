<?php


function response_success($title, $message = "")
{
    $_SESSION['action_status'] = 'success';
    $_SESSION['title_message'] = $title;
    $_SESSION['message'] = $message;
}

function response_error($title, $message = "")
{
    $_SESSION['action_status'] = 'error';
    $_SESSION['title_message'] = $title;
    $_SESSION['message'] = $message;
}

function response_warning($title, $message = "")
{
    $_SESSION['action_status'] = 'warning';
    $_SESSION['title_message'] = $title;
    $_SESSION['message'] = $message;
}
function response_info($title, $message = "")
{
    $_SESSION['action_status'] = 'info';
    $_SESSION['title_message'] = $title;
    $_SESSION['message'] = $message;
}
?>