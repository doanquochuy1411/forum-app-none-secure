<?php
class Errors extends Controller
{
    function Index()
    {
        $this->view("404");
    }

    function Unauthorized()
    {
        $this->view("401");
    }
}
?>