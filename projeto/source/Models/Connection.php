<?php
namespace Source\Models;

use PDO;

/**
 * Description of Connection
 *
 * @author GABRIEL
 */
class Connection {
    public function __construct()
    { 
       return new PDO('mysql:host=localhost;dbname=avaliacaogabriel', 'root', '');
    }
}
