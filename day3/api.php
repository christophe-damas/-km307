<?php
// $feld1 = "gfd";
// $id = 0;
// /* echo $feld1;
// echo $id; */
// print_r($_POST);
// print_r($_GET);
// $requestMethod = $_SERVER["REQUEST_METHOD"];
// echo $requestMethod;
//POST = insert oder update
// id==0, dann insert, else update
// GET = Daten JSON holen
// id==0, dann alle Datensätze, else nur ein Datensatz
// DELETE (id mitgeben)
// TANKEN (id mitgeben)
define('DB_NAME', 'M307_Test');
define('DB_USER', 'root');
define('DB_PSWD', '');
define('DB_HOST', '127.0.0.1');
define('DB_TABLE', 'autos');

$neuesAuto = new auto();

class auto{
    private $requestMethod = "GET";
    private $array = array();
    private $conn = null;
    
    public function __construct()
    {
        $this->checkdb();

        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        // echo $this->requestMethod;
        $this->{$this->requestMethod}();

        echo json_encode($this->array);
    }

    function checkdb(){
        // echo 'checkk...';
        if($this->conn = new mysqli(DB_HOST, DB_USER, DB_PSWD)){
            if(!$this->conn->select_db(DB_NAME)){
                $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " DEFAULT CHARACTER SET utf8";
                $this->conn->query($sql);
                $this->conn->select_db(DB_NAME);
    
                $sql = "CREATE TABLE IF NOT EXISTS autos (
                    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    name VARCHAR(255) NOT NULL,
                    kraftstoff VARCHAR(255) NOT NULL,
                    farbe VARCHAR(255) NOT NULL,
                    bauart VARCHAR(255) NOT NULL,
                    betankungen INTEGER NOT NULL DEFAULT 0
                )";
                $this->conn->query($sql);
    
                $sql = "INSERT INTO autos (name, kraftstoff, farbe, bauart) 
                VALUES ('Passat', 'Diesel', '#000000', 'Limousine'),
                ('Scross 4x4', 'Benzin', '#006666', 'SUV'),
                ('Vito 119CDI', 'Diesel', '#008888', 'Limousine');";
                $this->conn->query($sql);
            }
        }
    }


    function GET(){
        // echo "-get-";
        if(isset($_GET['id']) AND $_GET['id'] > 0){
            // echo "-get Daten - id=" . $_GET['id'] . "-";
            $sql = "SELECT * FROM autos WHERE id = " .$_GET['id'];
        }else{
            // echo "-get - alle Daten -";
            $sql = "SELECT * FROM autos";
        }
        $this->array['data'] = array();
        $results = $this->conn->query($sql);
        $i=0;
        while($datensatz = mysqli_fetch_array($results)){
            foreach($datensatz as $key => $value){
                $this->array['data'][$i][$key] = $value;
            }
            $i++;
        }

        $this->array['sql'] = $sql;
        $this->array['success'] = "Liste Erfolgreich geladen";
        $this->array['error'] = "fehlermeldung";
    }
    function TANKEN(){
        // echo "-tanken-";
        if(isset($_GET['id']) AND $_GET['id'] > 0){
            // echo "-id=" . $_GET['id'] . "-";

            $sql = " UPDATE autos SET tank = tank+1 WHERE id = " .$_GET['id'];
            $this->array['sql'] = $sql;
        }else{
            // echo "-id=fehlt-";
        }
    }
    function DELETE(){
        // echo "-delete-";
        if(isset($_GET['id']) AND $_GET['id'] > 0){
            // echo "-delete - id=" . $_GET['id'] . "-";
            $sql = " DELETE FROM autos WHERE id = " .$_GET['id'];
            $this->array['sql'] = $sql;
        }else{
            // echo "-delete - id=fehlt-";
        }
    }
    function POST(){
        // echo "-post-";
        if(isset($_GET['id']) AND $_GET['id'] > 0){
            // echo "-update - id=" . $_GET['id'] . "-";
        }else{
            // echo "-insert - id=fehlt-";
        }
    }
   
    public function __destruct()
    {
        // echo 'destruct';
        $this->conn->close();
    }
}