<?php 
    include('conn.php');
    session_start();

    if (isset($_SESSION['admin'])) {
        
        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
            $stmt->execute(['id'=>$_SESSION['admin']]);
            $user = $stmt->fetch();
        } 
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

        $pdo->close();
        
    }
