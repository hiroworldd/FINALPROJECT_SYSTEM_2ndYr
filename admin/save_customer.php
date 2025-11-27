<?php
header('Content-Type: application/json');
include('db.php');

$id = $_POST['id'] ?? '';
$name = $_POST['name'];
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$notes = $_POST['notes'] ?? '';

if($id){
    $stmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone=?, notes=? WHERE id=?");
    $stmt->bind_param("ssssi",$name,$email,$phone,$notes,$id);
    $stmt->execute();
}else{
    $stmt = $conn->prepare("INSERT INTO customers (name,email,phone,notes) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$phone,$notes);
    $stmt->execute();
}
echo json_encode(['success'=>true]);
?>
