<?php

namespace Source\Models;

class Product extends Connection
{
    
    private $conexao;
    public function __construct()
    { 
       $this->conexao = parent::__construct();
    }
    
    public function getData($count = false){
        if($count){
            $sql = "SELECT count(*) as productsCount FROM products WHERE status != 2";
        }
        else{
            $sql = "SELECT * FROM products WHERE status != 2";
        }
        $data = $this->conexao->query($sql);
        
        return $data->fetchAll();
    }
    
    public function getDataEdit($id){
        $sql = "SELECT * FROM products WHERE id = :id AND status != 2";
        $data = $this->conexao->prepare($sql);
        $data->bindParam(':id', $id);
        $data->execute();
        
        return $data->fetch();
    }
    
    public function putData($data){
        $sql = "UPDATE products SET "
                . "descricao = :descricao, "
                . "valor_unitario = :valor_unitario, "
                . "estoque = :estoque, "
                . "codigo_barras = :codigo_barras "
                . "WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $data["id"]);
        $stmt->bindParam(':descricao', $data["descricao"]);
        $stmt->bindParam(':valor_unitario', $data["valor_unitario"]);
        $stmt->bindParam(':estoque', $data["estoque"]);
        $stmt->bindParam(':codigo_barras', $data["codigo_barras"]);
        $stmt->execute();
        
        return true;
    }
    
    public function addData($data){
        
        $sql = "INSERT INTO products ( "
                . "descricao, "
                . "valor_unitario, "
                . "estoque, "
                . "codigo_barras) VALUES ("
                . ":descricao,:valor_unitario,:estoque,:codigo_barras) ";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':descricao', $data["descricao"]);
        $stmt->bindParam(':valor_unitario', $data["valor_unitario"]);
        $stmt->bindParam(':estoque', $data["estoque"]);
        $stmt->bindParam(':codigo_barras', $data["codigo_barras"]);
        
        return $stmt->execute();
    }
}