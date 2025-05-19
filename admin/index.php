<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/database.php';
include 'partials/header.php';

$isAdmin = $_SESSION['userIsAdmin'];

$userId = $_SESSION['userId'];
$query = "SELECT posts.id, posts.title, posts.categoryId FROM posts JOIN account ON posts.userId = account.id WHERE posts.userId = $userId  ORDER BY posts.id DESC";

$posts = mysqli_query($dbConnection, $query);

if (isset($_SESSION['deletePost'])) {
    $message = $_SESSION['deletePost'];
    $messageClass = "error";
    unset($_SESSION['deletePost']);
} else if (isset($_SESSION['deletePostSuccess'])) {
    $message = $_SESSION['deletePostSuccess'];
    $messageClass = "success";
    unset($_SESSION['deletePostSuccess']);
}

?>

<section class="section dashboard">
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
        <aside data-aside>
            <ul>
                <li>
                    <a href="addPost.php">
                        <ion-icon name="create-outline" aria-hidden="true"></ion-icon>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <ion-icon name="newspaper-outline" aria-hidden="true"></ion-icon>

                        <h5>Manage Post</h5>
                    </a>
                </li>
                <?php if ($isAdmin) : ?>
                    <li>
                        <a href="addCategory.php">
                            <ion-icon name="pencil-outline" aria-hidden="true"></ion-icon>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manageCategory.php" class="active"><ion-icon name="list-sharp" aria-hidden="true"></ion-icon>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manageUser.php">
                            <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/editPost.php?id=<?= $post['id'] ?>" class="btn btn-primary">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/deletePost.php?id=<?= $post['id'] ?>" class="btn btn-primary danger">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert-message error"><?= "No posts found" ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>

<?php
include 'partials/footer.php'
?>