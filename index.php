<?php

include("person.php");

$person = new Person();

$msg = "";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['action'])){
        $action = $_POST['action'];

        if($action == "create"){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $age = $_POST['age'];

            if($person->create($name,$email,$age)){
                $msg = "Person Created Successfully!!";
            }
            else{
                $msg = "Error";
            }
        }

        if($action == "update"){
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $age = $_POST['age'];

            if($person->update($id,$name,$email,$age)){
                $msg = "Person Updated Successfully!!";
            }
            else{
                $msg = "Error";
            }
        }

        if($action == "delete"){
            $id = $_POST['id'];

            if($person->delete($id)){
                $msg = "Person Deleted Successfully!!";
            }
            else{
                $msg = "Error";
            }
        }

    }
}

$persons = $person->read();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD By OOPs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f4f4;
    padding: 20px;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.form-section {
    margin-bottom: 30px;
}

label {
    display: block;
    margin-top: 10px;
}

input[type="text"], input[type="email"], input[type="number"], input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #28a745;
    color: white;
    cursor: pointer;
    border: none;
}

input[type="submit"]:hover {
    background-color: #218838;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ccc;
}

.updateIcon, .deleteIcon {
    cursor: pointer;
    padding: 5px;
    font-size: 20px;
}

.updateIcon {
    color: #007bff;
}

.updateIcon:hover {
    color: #0056b3;
}

.deleteIcon {
    color: #dc3545;
}

.deleteIcon:hover {
    color: #c82333;
}

.message {
    text-align: center;
    margin: 20px 0;
    color: green;
}

</style>

<body>

<div class="container">
        <h1>PHP OOP CRUD</h1>

        <?php if ($msg): ?>
            <p class="message"><?php echo $msg; ?></p>
        <?php endif; ?>

        <div class="form-section">
            <h2 id="formTitle">Create User</h2>
            <form id="userForm" method="POST" onsubmit="return validateForm()">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" id="personId" name="id">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required><br>
                <input type="submit" id="submitButton" value="Create">
            </form>
        </div>

        <h2>All Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
            <?php if (!empty($persons)): ?>
                <?php foreach ($persons as $person): ?>
                    <tr>
                        <td><?php echo $person['id']; ?></td>
                        <td><?php echo $person['name']; ?></td>
                        <td><?php echo $person['email']; ?></td>
                        <td><?php echo $person['age']; ?></td>
                        <td>
                            <i class="fas fa-edit updateIcon" 
                               data-id="<?php echo $person['id']; ?>" 
                               data-name="<?php echo $person['name']; ?>" 
                               data-email="<?php echo $person['email']; ?>" 
                               data-age="<?php echo $person['age']; ?>">
                            </i>
                            <form method="POST" class="deleteForm" onsubmit="return confirmDelete()">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $person['id']; ?>">
                                <i class="fas fa-trash deleteIcon" onclick="this.parentElement.submit()"></i>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    
    var updateIcons = document.querySelectorAll(".updateIcon");
    updateIcons.forEach(function(icon) {
        icon.addEventListener("click", function() {
            var id = this.getAttribute("data-id");
            var name = this.getAttribute("data-name");
            var email = this.getAttribute("data-email");
            var age = this.getAttribute("data-age");

            
            document.getElementById("personId").value = id;
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
            document.getElementById("age").value = age;

            
            document.getElementById("formTitle").textContent = "Update";
            document.getElementById("submitButton").value = "Update";
            document.getElementById("formAction").value = "update";
        });
    });
});


function confirmDelete() {
    return confirm("Are you sure you want to delete this user?");
}

    </script>

</body>
</html>