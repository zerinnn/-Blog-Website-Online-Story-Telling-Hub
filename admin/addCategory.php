<?php
require '../config/database.php';
include './partials/header.php';

if (isset($_SESSION['addCategorySuccess'])) {
    $message = $_SESSION['addCategorySuccess'];
    $messageClass = "success";
    unset($_SESSION['addCategorySuccess']);
}
if (isset($_SESSION['addCategory'])) {
    $message = $_SESSION['addCategory'];
    $messageClass = "error";
    unset($_SESSION['addCategory']);
}
?>

<section class="section form_section">
    <div class="container form_sectionContainer">
        <h2>Add Category</h2>

        <?php if (isset($message)) : ?>
            <div class="alert-message <?= $messageClass ?>"><?= $message ?></div>
        <?php endif; ?>

        <form action="<?= ROOT_URL ?>admin/addCategoryLogic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" id="title" placeholder="Title">
            <label for="description"></label>
            <textarea rows="4" name="description" id="description" placeholder="description"></textarea>
            <script>
                CKEDITOR.replace('description');
            </script>
            <div class="form_control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>
</section>

<?php include '../partials/footer.php' ?>