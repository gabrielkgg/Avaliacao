<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Product;

class Web {

    private $view;

    public function __construct(){
        $this->view = new Engine(__DIR__ . "/../../theme", "phtml");
    }

    public function home($data){
        $productsCount = (new Product())->getData(true);

        echo $this->view->render("home",[
            "productsCount" => $productsCount
        ]);
    }

    public function product(){
        $products = (new Product())->getData();
        $url = ROOT;
        
        echo $this->view->render("produtos", [
            "url" => $url,
            "products" => $products
        ]);
    }
    
    public function productEdit($data){
        if(!empty($data["filter"])){
            $product = (new Product())->getDataEdit($data["filter"]);
            
            $url = ROOT;
            
            echo $this->view->render("form-produto-edit", [
                "product" => $product,
                "url" => $url
            ]);
        }
    }
    
    public function productEditPost($data){
        if(!empty($data)){
            $edit = (new Product())->putData($data);
            
            if($edit){
                echo 'Alterado com sucesso';
            }
        }
    }
    
    public function productAdd($data){
        $url = ROOT;
        echo $this->view->render("form-produto", [
            "url" => $url
        ]);
        
    }
    
    public function productAddPost($data){
        if(!empty($data)){
            $new = (new Product())->addData($data);
            var_dump($new);
            if($new){
                echo 'Adicionado com sucesso';
            }
        }
    }
}