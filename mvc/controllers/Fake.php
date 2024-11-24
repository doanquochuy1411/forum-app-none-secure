<?php
class Fake extends Controller
{
    protected $PostModel;


    public function __construct()
    {
        $this->PostModel = $this->model("Post");
    }

    function Index()
    {
        $this->PostModel->generate_fake_likes();
        echo "hihihi";
        exit();
    }
}
?>