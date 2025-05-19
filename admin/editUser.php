<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/database.php';
include 'partials/header.php';

$user = null;
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM account WHERE id=$id";
    $result = mysqli_query($dbConnection, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($dbConnection));
    }
    $user = mysqli_fetch_assoc($result);
} else {
    header('Location: ' . ROOT_URL . 'admin/manageUser.php');
}
?>

<section class="section form_section">
    <div class="container form_sectionContainer">
        <h2>Edit User</h2>
        <form action="<?= ROOT_URL ?>admin/editUserLogic.php" enctype="multipart/form-data" method="POST">

            <input type="hidden" value="<?= $user['id'] ?>" name="id" id="id" placeholder="First name">
            <input type="text" value="<?= $user['firstName'] ?>" name="fname" id="fname" placeholder="First name">
            <input type="text" name="lname" value="<?= $user['lastName'] ?>" id="lname" placeholder="Last name">
            <select name="userrole" id="">
                <option value="0">User</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" class="btn btn-primary" name="submit">Update User</button>
        </form>
    </div>
</section>

<?php
include 'partials/footer.php';
?>