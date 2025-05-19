<?php
include './partials/header.php';
require 'config/database.php';
if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postQuery = "SELECT * FROM posts WHERE id=$postId";
    $postQueryResult = mysqli_query($dbConnection, $postQuery);
    $result = mysqli_fetch_assoc($postQueryResult);
} else {
    header('Location: ' . ROOT_URL . 'index.php');
    die();
}
if (isset($_GET['categoryId'])) {
    $categoryId = $_GET['categoryId'];
    $sql = "UPDATE categories SET view = view + 1 WHERE id = $categoryId";
    $sqlResult = mysqli_query($dbConnection, $sql);
}

?>

<section class="single-post">
    <div class="container single-post-container">

        <?php if (mysqli_num_rows($postQueryResult) == 1) : ?>
            <h2>
                <?= $result['title'] ?>
            </h2>
            <div class="card-wrapper">

                <div class="profile-card">
                    <?php
                    $userId = $result['userId'];
                    $userQuery = "SELECT * FROM account WHERE id = $userId";
                    $userQueryResult = mysqli_query($dbConnection, $userQuery);
                    $user = mysqli_fetch_assoc($userQueryResult);
                    ?>
                    <img src="images/<?= $user['avatar'] ?>" width="48" height="48" loading="lazy" alt="Joseph" class="profile-banner">

                    <div>
                        <p class="card-title"><?= $user['username'] ?></p>

                        <p class="card-subtitle"><?= $result['date_time'] ?></p>
                    </div>
                </div>

            </div>
            <figure class="card-banner img-holder" style="--width: 1602; --height: 903;">
                <img src="images/<?= $result['thumbnail'] ?>" width="1602" height="903" loading="lazy" alt="Self-observation is the first step of inner unfolding" class="img-cover">
            </figure>
            <p>
                <?= nl2br($result['body']) ?>


            </p>

        <?php endif; ?>
    </div>
</section>

<?php
include './partials/footer.php';
?>