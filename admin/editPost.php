<?php
require 'config/database.php';
include 'partials/header.php';


$categoryQuery = "SELECT * FROM categories ";
$categoryResult = mysqli_query($dbConnection, $categoryQuery);


//fetch data from database if id is exists

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($dbConnection, $query);

    $post = mysqli_fetch_assoc($result);
} else {
    header('Location: ' . ROOT_URL . 'admin/index.php');
    die();
}

if (isset($_SESSION['editPost'])) {
    $message = $_SESSION['editPost'];
    $messageClass = "error";
    unset($_SESSION['editPost']);
} else if (isset($_SESSION['editPostSuccess'])) {
    $message = $_SESSION['editPostSuccess'];
    $messageClass = "success";
    unset($_SESSION['editPostSuccess']);
}

?>

<section class="section form_section">
    <div class="container form_sectionContainer">
        <h2>Edit Post</h2>
        <?php if (isset($message)) : ?>
            <div class="alert-message <?= $messageClass ?>"><?= $message ?></div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>admin/editPostLogic.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previousThumbnailName" value="<?= $post['thumbnail'] ?>">
            <input type="text" value="<?= $post['title'] ?>" name="title" id="title" placeholder="Title">
            <input type="text" value="<?= $post['badge'] ?>" name="badge" id="title" placeholder="e.g. Working Tips, Health Tips">
            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($categoryResult)) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile; ?>
            </select>

            <textarea rows="15" name="body" placeholder="Article"><?= $post['body'] ?>"</textarea>

            <div class="control">
                <input type="checkbox" value="1" name="isFeatured" id="isFeatured" class="check_box" checked>
                <label for="isFeatured">Featured</label>
            </div>
            <div class="form_control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" value="<?= $post['thumbnail'] ?>" id="thumbnail">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update Post</button>
        </form>
    </div>
</section>

</body>

</html>