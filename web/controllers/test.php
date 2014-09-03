<?php

class Test extends Controller
{
    public function index()
    {
        $model = $this->loadModel('TestModel');
        $tables = $model->showTables();

        require "./views/_templates/header.php";
        require "./views/test/index.php";
        require "./views/_templates/footer.php";
    }
}
