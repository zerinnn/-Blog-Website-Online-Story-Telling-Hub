<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/database.php';
include 'partials/header.php';

$category = null;
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM categories WHERE id=$id";
    $categoryResult = mysqli_query($dbConnection, $query);
    if (!$categoryResult) {
        die("Query failed: " . mysqli_error($dbConnection));
    }
    $category = mysqli_fetch_assoc($categoryResult);
} else {
    header('Location: ' . ROOT_URL . 'admin/manageCategory.php');
}
?>
<section class="section form_section">
    <div class="container form_sectionContainer">
        <h2>Edit Category</h2>
        <form action="<?= ROOT_URL ?>admin/editCategoryLogic.php" method="post">
            <input type="hidden" value="<?= $category['id'] ?>" name="id" id="id">
            <input type="text" value="<?= $category['title'] ?>" name="title" id="title" placeholder="Title">
            <textarea rows="10" name="description" placeholder="description"><?= $category['description'] ?></textarea>
            <button type="submit" class="btn btn-primary" name="submit">Update Category</button>
        </form>
    </div>
</section>

</body>

</html>