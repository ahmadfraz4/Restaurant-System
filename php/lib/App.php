<?php

require "../config/config.php"; ?>
<?php

class App
{
    public $host = HOST;
    public $dbname = DB_NAME;
    public $user = USER;
    public $password = PASS;

    public $link; // connection name

    // construct runs automatically when class is used
    public function __construct()
    {
        $this->connect();
    }
    // connecting to server
    public function connect()
    {
        $this->link = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->link->connect_error) {
            die("Error:" . $this->link->connect_error);
        }
    }

    // Advanced Crud Operation 
    // ==================================================================================
    // ==================================================================================

    // Read :- select data 
    public function selectData($table, $conditions=array())
    {
        $query = "SELECT * FROM $table ";
        $types = array();
        $condition = '';
        $result = array();


        if(!empty($conditions) && is_array($conditions)){
            // constructing query
            $query .= "WHERE ";
            $conditions_count = count($conditions);
            $i = 0;
            foreach ($conditions as $key => $val) {
                $query .= "$key=?";
                $i++;
                if ($i < $conditions_count) {
                    $query .= " AND ";
                }
            }
            // filtering types for bind_params
            $types = $this->filterTypes($conditions);
            
            $query = rtrim($query, ","); 
            $stmt = $this->link->prepare($query) or die("Error: " . $this->link->error);
            
            $stmt->bind_param(implode("", $types), ...array_values($conditions));
            $stmt->execute();
            $result = $stmt->get_result();
        }else{
           $result = $this->link->query($query);
        }

        if($result->num_rows > 0){
            $rows = array();
            foreach($result as $key => $val){
                $rows[$key] =  $val;
            }
            return $rows;
        }else{
            return "No data found";
        }
        
    }
    
    // Add :- insert data ======= both file data and simple data
    public function insertData($table, $params = array())
    {
        if ($this->isTableExist($table)) {

            foreach ($params as &$file) { // & is creating reference to the file This means that any changes made to $value inside the loop will directly affect the corresponding element in the $values array.
                if (is_array($file) && isset($file['tmp_name'])  && $file['error'] == 0) {
                   $fileName = $this->fileHandling($file);
                   $file = $fileName;
                }
            }
            foreach($params as $key => &$val){
                if(strtolower($key) == "password"){
                    $val = md5($val);
                }
            }


            $key = implode(",", array_keys($params));
            $placeholders = rtrim(str_repeat('?,', count($params)), ','); // it will remove last comma

          
            $query = "INSERT into $table ($key) values ($placeholders)";
            $stmt  = $this->link->prepare($query);

            $types = array();
            if ($stmt) {
                foreach ($params as $datatype) {
                    if (is_string($datatype)) {
                        $types[] = 's';
                    } elseif (is_int($datatype)) {
                        $types[] = 'i';
                    } elseif (is_float($datatype)) {
                        $types[] = 'd';
                    }
                }


                $stmt->bind_param(implode("", $types), ...array_values($params));

                if ($stmt->execute()) {
                    echo "Data inserted successfully.";
                } else {
                    echo "Failed to insert data.";
                }
            } else {
                echo "Failed to prepare statement.";
            }
        } else {
            echo "Table not exist";
        }
    }

    // Update :- update data ====== both file data and simple data
    public function updateData($table, $params = array(), $conditions = array())
    {
        if ($this->isTableExist($table)) {
         
            $file_name_container = array();
            
            $paramValues = $this->binding($params);
            $condition_values = $this->binding($conditions);

            foreach ($params as $key => &$file) { // & is creating reference to the file This means that any changes made to $value inside the loop will directly affect the corresponding element in the $values array.
                if (is_array($file) && isset($file['tmp_name'])  && $file['error'] == 0) {
                   $fileName = $this->fileHandling($file);
                   $file = $fileName;
                   $file_name_container[$key] = $fileName;


                   $prev_record =  $this->selectData($table, $conditions);
                   foreach($prev_record[0] as $key => $val){
                        foreach($file_name_container as $key2 => $val2){
                            if($key == $key2){
                                if(file_exists('../uploads/'.$val)){
                                    unlink('../uploads/'.$val);
                                }
                            }
                        }
                    }
                    // but if user dont upload file then it should retain previous images
                }elseif(is_array($file) && isset($file['tmp_name'])  && $file['error'] > 0){
                    $prev_record =  $this->selectData($table, $conditions);
                    
                    $file_name_container[$key] = $key;

                    foreach($prev_record[0] as $key => $val){
                         foreach($file_name_container as $key2 => $val2){
                             if($key == $key2){
                                 $file = $val;
                             }
                         }
                     }
                }
            }

            $query = "UPDATE $table SET $paramValues WHERE $condition_values";
            $stmt = $this->link->prepare($query);

            $types = array();

            $types = array_merge($this->filterTypes($params), $this->filterTypes($conditions));
            $allArrays = array_merge($params, $conditions);
            $stmt->bind_param(implode("", $types), ...array_values($allArrays));

            if ($stmt->execute()) {
                echo "Data updated successfully.";
            } else {
                echo "Failed to insert data.";
            }
        }
    }

    // Delete :- delete data ====== both file data and simple data

    public function deleteData($table, $conditions){
        if($this->isTableExist($table)){
            $condition = '';
            $types = array();

            $types = $this->filterTypes($conditions);
            $condition =  $this->binding($conditions);

            $record = $this->selectData($table, ["id"=>$conditions['id']])[0];

            if (is_array($record)) {
                foreach ($record as $key => $val) {
                    if (file_exists('../uploads/' . $val)) {
                        unlink('../uploads/' . $val);
                    }
                }
            } else {
                echo "No files to delete.";
            }
            

            $query = "DELETE from $table where $condition";
            $stmt = $this->link->prepare($query);

            $stmt->bind_param(implode("",$types), ...array_values($conditions));
            $stmt->execute();
        }
    }

    // login for user 
    public function login($email, $password,$path){
        $query1 = "SELECT * from sample where email = '$email'";
        $stmt =  $this->link->prepare($query1);   
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            
            $password = md5($password);
            
            $row = $result->fetch_assoc();
            if($password == $row['password']){
                print_r($row);
                header("location: $path");
            }else{
                echo 'invalid';
            }
        }else{
            echo 'User not exist';
        }

    }
    // validate session
    public function validateSession($path){
        if(isset($_SESSION['id'])){
            header("location: $path");
        }
    }

    // private functions
    // =============================================================================

    // check if the table exist
    private function isTableExist($table)
    {
        $query = "SHOW TABLES from $this->dbname like '$table' ";
        $result = $this->link->query($query);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    // handling files if they exist
    private function fileHandling($file)
    {
        $timestamp = time();
        $filename = $timestamp.'-'.$file['name'];
        $full_path = $file['full_path'];
        $tmp_name = $file['tmp_name'];
        $size = $file['size'];
        $type = (explode('/', $file['type']))[0];
        
        if ($type != 'image') {
            die('File must be image');
        }

        if ($size > 1024  * 1024 * 5) {
            die('File must be less than 10 mb');
        }

        $i = 1;
        $newName = $filename;
        

        while (file_exists('../uploads/' . $newName)) {
            $file_break = pathinfo($filename);

            $name_of_file = $file_break['filename'];
            $extenstion_of_file = $file_break['extension'];

            $newName =  $name_of_file . '(' . $i++ . ').' . $extenstion_of_file;
        }
        // move_uploaded_file($tmp_name, '../uploads/'.$newName);

        if (move_uploaded_file($tmp_name, '../uploads/'.$newName)) {
            // print_r($file);
            return $newName;
        }

    }

    // including ? mark instead of values and making string for binding
    private function binding($array = array()){
        $string = "";
        foreach ($array as $key => $value) {
            $string .= $key . '=' . '?,';
        }
        return rtrim($string, ',');
    }

    // filtering types
    private function filterTypes($array = array()){
        $types = array();
        foreach($array as $key=>$val){
            if (is_string($val)) {
                $types[] = 's';
            } elseif (is_int($val)) {
                $types[] = 'i';
            } elseif (is_float($val)) {
                $types[] = 'd';
            }
        }
        return $types;
    }

    // ================================================================================
   
}

$obj = new App;

// endpoints --------

//  $a = $obj->selectData("sample",["id"=>3]);
//  echo "<pre>";
//  print_r($a);
//  echo "</pre>";
//  $obj->insertData("sample",["name"=>"kaka", "age"=>19, "password" => "pakistan1", "email" => "abc@gmail.com"]);
//  $obj->insertData("user",["name"=>"kaka"]);
// $obj->insertData("register", ["name" => $name, "age" => $age, "file" => $file]);
// $obj->updateData("sample", ["name"=>"glery", "age"=>22] ,["id"=>1]);
$obj->deleteData('user', ["id"=>33]);
// $obj->login("abc@gmail.com","pakistan1",'');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>op</title>
</head>

<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="name">
        <input type="number" name="age">
        <input type="file" name="img">
        <input type="submit" value="submit" name="sub">
    </form>
    <?php if (isset($_POST['sub'])) {

        $name = $_POST['name'];
        $age = $_POST['age'];
        $file = $_FILES['img'];
        
        // $obj->updateData("register", ["name" => $name, "age" => $age], ["id"=>2]);
        // $obj->insertData("register", ["name" => $name, "age" => $age, "file" => $file]);
        // $obj->updateData("register", ["name" => $name, "age" => $age, "file" => $file], ["id"=>3]);

    } ?>
</body>

</html>