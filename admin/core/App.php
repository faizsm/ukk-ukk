<?php

class App{
    protected $controller = 'Portofolio'; //controler default
    protected $method = 'index'; //method default
    protected $params = []; //parameter jika ada

    public function __construct()
    {
        $url = $this->parseURL();

    //pemanggilan controller
    if (file_exists('../admin/controllers/'.$this->controller.'.php')){
        $this->controller = $url[0];
        unset($url[0]);
    }
    require_once '../admin/contoller/'.$this->controller.'.php';
    $this->method = new $this->controller;

    //pemanggilan method
    if(isset($url[1])){
        if(method_exists($this->contoller, $url[1])){
            $this->method = $url[1];
            unset($url[1]);
        }
    }

    //pamameters
    if (!empty($url)){
        $this->params = array_values($url);
    }

    //jalankan controler dan method, serta kirim parameter jika ada
    call_user_func_array([$this->controller,$this->method],$this->params);
    }

}

public function parseURL()
{
    if(isset($_GET['url'])){
        //menghilangkan karakter aneh atau karakter yang mungkin kita di hack
        $url = rtrim($_GET['url'],'/');

        //menghilangkan tanda garis miring (/) dan mengambil stingnya
        $url = explode('/',$url);
        return $url;
    }
}