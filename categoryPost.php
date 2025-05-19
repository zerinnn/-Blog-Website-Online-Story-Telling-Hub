<?php
include './partials/header.php';
require 'config/database.php';

$postsPerPage = 20;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}

$offset = ($currentPage - 1) * $postsPerPage;

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM posts WHERE categoryId = $id LIMIT $postsPerPage OFFSET $offset";
    $result = mysqli_query($dbConnection, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $totalPostsQuery = "SELECT COUNT(*) as total FROM posts WHERE categoryId = $id";
    $totalPostsResult = mysqli_query($dbConnection, $totalPostsQuery);
    $totalPosts = mysqli_fetch_assoc($totalPostsResult)['total'];
    $totalPages = ceil($totalPosts / $postsPerPage);
} else {
    header('Location: ' . ROOT_URL . 'index.php');
    die();
}

$categoryQuery = "SELECT * FROM categories WHERE id = $id";
$categoryResult = mysqli_query($dbConnection, $categoryQuery);
$name = mysqli_fetch_assoc($categoryResult);
?>

<section class="section feature" aria-label="feature" id="featured">
    <div class="container">

        <h2 class="headline headline-2 section-title">
            <span class="span"><?= $name['title'] ?></span>
        </h2>

        <p class="section-text">
            <?= nl2br($name['description']) ?>
        </p>
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <ul class="feature-list">
                <?php foreach ($posts as $post) : ?>
                    <li>
                        <div class="card feature-card">
                            <figure class="card-banner img-holder" style="--width: 1602; --height: 903;">
                                <img src="images/<?= $post['thumbnail'] ?>" width="1602" height="903" loading="lazy" alt="Self-observation is the first step of inner unfolding" class="img-cover">
                            </figure>

                            <div class="card-content">
                                <div class="card-wrapper">


                                    <div class="card-tag">
                                        <a href="categoryPost.php?id=<?= $name['id'] ?>" class="span hover-2"># <?= $name['title'] ?></a>

                                        <?php if (!empty($post['badge'])) : ?>
                                            <a href="#" class="span hover-2"># <?= $post['badge'] ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h3 class="headline headline-3">
                                    <a href="post.php?id=<?= $post['id'] ?>" class="card-title hover-2"><?= $post['title'] ?></a>
                                </h3>

                                <div class="card-wrapper">
                                    <?php
                                    $userId = $post['userId'];
                                    $userQuery = "SELECT * FROM account WHERE id = $userId";
                                    $userQueryResult = mysqli_query($dbConnection, $userQuery);
                                    $user = mysqli_fetch_assoc($userQueryResult);
                                    ?>
                                    <div class="profile-card">
                                        <img src="images/<?= $user['avatar'] ?>" width="48" height="48" loading="lazy" class="profile-banner">
                                        <div>
                                            <p class="card-title"><?= $user['username'] ?></p>
                                            <p class="card-subtitle"><?= $post['date_time'] ?></p>
                                        </div>
                                    </div>

                                    <a href="post.php?id=<?= $post['id'] ?>" class="card-btn">Read more</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <div class="alert-message error"><?= "No posts found" ?></div>
        <?php endif; ?>
        <div class="pagination">
            <?php if ($currentPage > 1) : ?>
                <a href="?id=<?= $id ?>&page=<?= $currentPage - 1 ?>" class="btn btn-secondary">
                    <span class="span">Previous</span>
                    <ion-icon name="arrow-back" aria-hidden="true"></ion-icon>
                </a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <a href="?id=<?= $id ?>&page=<?= $currentPage + 1 ?>" class="btn btn-secondary">
                    <span class="span">Show More Posts</span>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                </a>
            <?php endif; ?>
        </div>

    </div>

    <img src="images/shadow-3.svg" width="500" height="1500" loading="lazy" alt="" class="feature-bg">
</section>

<?php
include './partials/footer.php';
?>