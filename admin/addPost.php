<?php
require 'config/database.php';
include 'partials/header.php';

$query = "SELECT * FROM categories";
$categories = mysqli_query($dbConnection, $query);

if (isset($_SESSION['addPost'])) {
    $message = $_SESSION['addPost'];
    $messageClass = "error";
    unset($_SESSION['addPost']);
} else if (isset($_SESSION['addPostSuccess'])) {
    $message = $_SESSION['addPostSuccess'];
    $messageClass = "success";
    unset($_SESSION['addPostSuccess']);
}
?>

<section class="section form_section">
    <div class="container form_sectionContainer">
        <h2>Add Post</h2>
        <?php if (isset($message)) : ?>
            <div class="alert-message <?= $messageClass ?>"><?= $message ?></div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>admin/addPostLogic.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" id="title" placeholder="Title">
            <input type="text" name="badge" id="badge" placeholder="e.g. Working Tips, Health Tips">
            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="article"></label>
            <textarea rows="10" name="article" id="article" placeholder="Article"></textarea>

            <script>
                CKEDITOR.replace('article');
            </script>


            <?php if ($_SESSION['userIsAdmin'] == true) : ?>
                <div class="control">

                    <input type="checkbox" name="isFeatured" value="1" id="isFeatured" class="check_box" checked>
                    <label for="isFeatured">Featured</label>
                </div>
            <?php endif; ?>

            <div class="form_control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Add Post</button>
        </form>
    </div>
</section>

</body>

</html>