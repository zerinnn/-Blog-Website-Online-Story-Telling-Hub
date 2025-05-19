<?php
// session_start();
require 'config/database.php';
include 'partials/header.php';

$query = "SELECT * FROM categories ORDER BY title ASC";
$categories = mysqli_query($dbConnection, $query);

if (!$categories) {
    echo "Error executing query: " . mysqli_error($dbConnection);
    exit();
}


if (isset($_SESSION['editCategorySuccess'])) {
    $message = $_SESSION['editCategorySuccess'];
    $messageClass = "success";
    unset($_SESSION['editCategorySuccess']);
}
if (isset($_SESSION['editCategory'])) {
    $message = $_SESSION['editCategory'];
    $messageClass = "error";
    unset($_SESSION['editCategory']);
}

if (isset($_SESSION['deleteCategorySuccess'])) {
    $message = $_SESSION['deleteCategorySuccess'];
    $messageClass = "success";
    unset($_SESSION['deleteCategorySuccess']);
}
if (isset($_SESSION['deleteCategory'])) {
    $message = $_SESSION['deleteCategory'];
    $messageClass = "error";
    unset($_SESSION['deleteCategory']);
}
?>

<section class="dashboard">

    <?php if (isset($message)) : ?>
        <div class="alert-message <?= $messageClass ?> container"><?= $message ?></div>
    <?php endif; ?>

    <div class="container dashboardContainer">
        <button id="show_sidebar_btn" class="slidebar_toggle">
            <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
        </button>
        <button id="hide_sidebar_btn" class="slidebar_toggle">
            <ion-icon name="arrow-back" aria-hidden="true"></ion-icon>
        </button>
        <aside>
            <ul>
                <li><a href="addPost.php"><ion-icon name="create-outline" aria-hidden="true"></ion-icon>
                        <h5>Add Post</h5>
                    </a></li>
                <li><a href="index.php"><ion-icon name="newspaper-outline" aria-hidden="true"></ion-icon>
                        <h5>Manage Post</h5>
                    </a></li>
                <li><a href="addCategory.php"><ion-icon name="pencil-outline" aria-hidden="true"></ion-icon>
                        <h5>Add Category</h5>
                    </a></li>
                <li><a href="manageCategory.php" class="active"><ion-icon name="list-sharp" aria-hidden="true"></ion-icon>
                        <h5>Manage Categories</h5>
                    </a></li>
                <li><a href="manageUser.php"><ion-icon name="people-outline" aria-hidden="true"></ion-icon>
                        <h5>Manage User</h5>
                    </a></li>
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
            <?php if (mysqli_num_rows($categories) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data for testing -->
                        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                            <tr>
                                <td><?= $category['title'] ?></td>

                                <td><a href="<?= ROOT_URL ?>admin/editCategory.php?id=<?= $category['id'] ?>" class="btn btn-primary">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/deleteCategory.php?id=<?= $category['id'] ?>" class="btn btn-primary danger">Delete</a></td>
                            </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert-message error"><?= "No categories found" ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>


<?php
include 'partials/footer.php'
?>