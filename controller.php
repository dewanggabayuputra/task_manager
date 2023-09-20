<?php

class controller extends database {
    private $connect;

    //get connection value
    function __construct($con){
        $this->connect = $con;
	}

    function getAll($title = null, $status = null){
        try {
            $where = '';
            $param = [];
            if($title && empty($status)){
                $where = "WHERE title = :title";
                $param = ['title' => $title];
            }else if($status && empty($title)){
                $where = "WHERE status = :status";
                $param = ['status' => $status];
            }else if($status && $title){
                $where = "WHERE title = :title AND status = :status";
                $param = ['title' => $title, 'status' => $status];
            }

            $result = [];
            $sql = '';
            $query = '';
            if($where){
                $sql = "SELECT * FROM tasks $where";
            }else{
                $sql = "SELECT * FROM tasks";
            }

            $query = $this->connect->prepare($sql);
            $query->execute($param);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $result = $query->fetchAll();
            
            return $result;
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
	}

    function create($title, $description){
        try {
            $validation_message = '';

            if(empty($title) || empty($description)){
                $validation_message = "the data entered is incomplete";
            }
            
            if($validation_message){
                return $validation_message;
            }else{
                $sql = "INSERT INTO tasks (title, description) VALUES (:title, :description)";
                $query = $this->connect->prepare($sql);
                $query->execute(['title' => $title, 'description' => $description]);

                $this->redirectToIndex();
            }
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
	}

    function update($id){
        try {
            date_default_timezone_set('Asia/Jakarta');
            $updated_at = date("Y-m-d H:i:s");
            $status = $_POST['status'];
            $sql = "UPDATE tasks SET status=:status, updated_at=:updated_at WHERE id=:id";
            $query = $this->connect->prepare($sql);
            $query->execute(['id' => $id, 'status' => $status, 'updated_at' => $updated_at]);
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
	}

    function delete($id){
        try {
            $sql = "DELETE from tasks WHERE id=:id";
            $query = $this->connect->prepare($sql);
            $query->execute(['id' => $id]);

            $this->redirectToIndex();
        }catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
	}

    //redirect to index
    function redirectToIndex(){
        header("location:index.php");
    }
}

?>