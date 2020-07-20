<?php

namespace Source\Models;

/**
 * Description of Sale
 *
 * @author GABRIEL
 */
class Sale extends Connection 
{
    private $conexao;
    public function __construct()
    { 
       $this->conexao = parent::__construct();
    }
    
    public function getData(){
        
        $sql = "SELECT *, sales.valor_unitario as valor_unitario_venda, (sales.quantidade * sales.valor_unitario) as valor_total FROM sales "
                . "JOIN products ON products.id = sales.id_product";
        $data = $this->conexao->query($sql);
        
        return $data->fetchAll();
        
    }
    
    public function getDataCount(){
        $sql = "SELECT count(*) as salesCount FROM sales";
        $data = $this->conexao->query($sql);
        
        return $data->fetchAll();
    }

    public function setSale($data){
        //deveria haver validação de estoque, usaria algo como getEstoque() se meu model estivesse de acordo com o desejado
        $sql = "INSERT INTO sales ( "
                . "id_product, "
                . "quantidade,"
                . "valor_unitario ) VALUES ("
                . ":id_product,"
                . ":quantidade,"
                . ":valor_unitario) ";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id_product', $data["product"]);
        $stmt->bindParam(':quantidade', $data["quantidade"]);
        $stmt->bindParam(':valor_unitario', $data["valor_unitario"]);

        $sql_update = "UPDATE products SET data_ultima_venda = NOW() WHERE id = :id_product";
        $stmt2 = $this->conexao->prepare($sql_update);
        $stmt2->bindParam(':id_product', $data["product"]);
        $stmt2->execute();

        if($data["atualiza_valor"] == "true"){
            $sql_update = "UPDATE products SET valor_unitario = :valor_unitario WHERE id = :id_product";
            $stmt2 = $this->conexao->prepare($sql_update);
            $stmt2->bindParam(':valor_unitario', $data["valor_unitario"]);
            $stmt2->bindParam(':id_product', $data["product"]);
            $stmt2->execute();
        }

        return $stmt->execute();
        
    }
}
