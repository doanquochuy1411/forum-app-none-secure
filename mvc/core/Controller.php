<?php

require __DIR__ . '/../../vendor/autoload.php';

// $config = HTMLPurifier_Config::createDefault();
// $purifier = new HTMLPurifier($config);


class Controller
{
     protected $purifier;

     public function __construct()
     {
          $config = HTMLPurifier_Config::createDefault();
          $config->set('HTML.Allowed', 'p,b,strong,i,em,u,a[href],ul,ol,li,img[src|alt|width|height],br');
          $this->purifier = new HTMLPurifier($config);
     }

     protected function model($model)
     {
          require_once "./mvc/models/" . $model . ".php";
          return new $model;
     }

     protected function view($view, $data = [])
     {
          extract($data);
          require_once "./mvc/views/" . $view . ".php";
     }

     protected function response($layout, $page, $title, $data)
     {
          $this->view($layout, [
               "Page" => $page,
               "title" => $title,
               "data" => $data
          ]);
     }
}

?>