<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Product;
use Source\Models\Sale;

class Web {

    private $view;

    public function __construct($router){
        $this->view = new Engine(__DIR__ . "/../../theme", "phtml");
        
        $this->view->addData(["router" => $router]);
    }

    public function home(){
        $productsCount = (new Product())->getData(true);
        $salesCount = (new Sale())->getDataCount();

        echo $this->view->render("home",[
            "productsCount" => $productsCount,
            "salesCount" => $salesCount
        ]);
    }

    public function product(){
        $products = (new Product())->getData();
        
        echo $this->view->render("produtos", [
            "products" => $products
        ]);
    }
    
    public function productEdit($data){
        if(!empty($data["filter"])){
            $product = (new Product())->getDataEdit($data["filter"]);
            
            echo $this->view->render("form-produto-edit", [
                "product" => $product
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
    
    public function productAdd(){
        echo $this->view->render("form-produto", []);
        
    }
    
    public function productAddPost($data){
        if(!empty($data)){
            $new = (new Product())->addData($data);
            
            if($new){
                echo 'Adicionado com sucesso';
            }
        }
    }
    
    public function saleView(){
        $listagemProducts = (new Product())->getData();
        $listagemSales = (new Sale())->getData();
        
        echo $this->view->render("form-venda", [
            "listagemProducts" => $listagemProducts,
            "listagemSales" => $listagemSales
        ]);
    }
    
    public function saleAdd($data){
        $newSale = (new Sale())->setSale($data);
        
        if($newSale){
            echo 'Adicionado com sucesso';
        }
        else{
            echo 'Não possui estoque suficiente';
        }
    }
    
    public function excluidosView(){
        $listagemExcluidos = (new Product())->excluidosView();
        
        echo $this->view->render("produtos-excluidos", [
            "listagemExcluidos" => $listagemExcluidos
        ]);
    }
    
    public function excluidosDelete($data){
        if(empty($data["id"])){
            return;
        }
        
        $id = $data["id"];
        $callback = (new Product())->delete($id);
        echo json_encode($callback);
    }
    
    public function excluidosRestore($data){
        if(empty($data["id"])){
            return;
        }
        
        $id = $data["id"];
        $callback = (new Product())->restore($id);
        echo json_encode($callback);
    }
}