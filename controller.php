<?php

class controller extends database {
    private $connect;

    //get connection value
    function __construct($con){
        $this->connect = $con;
	}

    function getAll($title = null, $status = null){
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
        //if where condition is exist
        $sql = '';
        if($where){
            $sql = "SELECT * FROM tasks $where";
            $query = $this->connect->prepare($sql);
            $query->execute($param);
            $query->setFetchMode(PDO::FETCH_ASSOC);

            $result = $query->fetchAll();
        }else{
            $sql = "SELECT * FROM tasks";
            $query = $this->connect->prepare($sql);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_ASSOC);

            $result = $query->fetchAll();
        }
        
        return $result;
	}

    function create($title, $description){
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
	}

    function update($id){
        date_default_timezone_set('Asia/Jakarta');
        $updated_at = date("Y-m-d H:i:s");
        $status = $_POST['status'];
        $sql = "UPDATE tasks SET status=:status, updated_at=:updated_at WHERE id=:id";
        $query = $this->connect->prepare($sql);
        $query->execute(['id' => $id, 'status' => $status, 'updated_at' => $updated_at]);
	}

    function delete($id){
        $sql = "DELETE from tasks WHERE id=:id";
        $query = $this->connect->prepare($sql);
        $query->execute(['id' => $id]);

		$this->redirectToIndex();
	}

    //redirect to index
    function redirectToIndex(){
        header("location:index.php");
    }
}

?>