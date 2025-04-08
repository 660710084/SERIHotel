<?php
session_start();
include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $email=$_POST['email'];
    $rawPassword=$_POST['password'];
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows>0){
        echo "Email Address Already Exists!";
    }else{
        $stmt = $conn->prepare("INSERT INTO user (FirstName, LastName, email, Password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
        if($stmt->execute()){
            header("location: Login.php");
            exit();
        }else{
            echo "Error:".$stmt->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows>0){
        $row=$result->fetch_assoc();

        echo "<pre>";
        echo "password ที่ใช้กรอก : ";
        var_dump($password);
        echo "password in DB : ";
        var_dump($row['Password']);
        echo "password verify : ";
        var_dump(password_verify($password, $row['Password']));
        echo "</pre>";
        
        if (password_verify($password, $row['Password'])) {
            session_start();
            $_SESSION['email']=$row['email'];
            $_SESSION['fName']=$row['FirstName'];
            $_SESSION['lName']=$row['LastName'];
            header("Location: index.php");
            exit();
        }else{
            echo "Incorrect Email or Password.";
        }
    }else{
        echo "Not Found Account in this System!";
    }
}
?>