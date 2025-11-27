<?php
header('Content-Type: application/json');
include('db.php');

$id = $_POST['id'] ?? '';
$title = $_POST['title'];
$description = $_POST['description'];
$due_date = $_POST['due_date'];
$customer_name = $_POST['customer_name'] ?? '';
$customer_email = $_POST['customer_email'] ?? '';
$customer_phone = $_POST['customer_phone'] ?? '';
$customer_notes = $_POST['customer_notes'] ?? '';

if($id){
    $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, due_date=?, customer_name=?, customer_email=?, customer_phone=?, customer_notes=? WHERE id=?");
    $stmt->bind_param("sssssssi",$title,$description,$due_date,$customer_name,$customer_email,$customer_phone,$customer_notes,$id);
    $stmt->execute();
    echo json_encode(['success'=>true]);
}else{
    $stmt = $conn->prepare("INSERT INTO projects (title, description, due_date, customer_name, customer_email, customer_phone, customer_notes) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss",$title,$description,$due_date,$customer_name,$customer_email,$customer_phone,$customer_notes);
    $stmt->execute();
    echo json_encode(['success'=>true,'customer'=>['name'=>$customer_name,'email'=>$customer_email,'phone'=>$customer_phone,'notes'=>$customer_notes]]);
}
?>
