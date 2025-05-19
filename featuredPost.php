<?php
include './partials/header.php';
require 'config/database.php';

$postsPerPage = 5;

// Get the current page or set a default
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $postsPerPage;

// Fetch featured posts with pagination
$query = "SELECT * FROM posts WHERE isFeatured=1 ORDER BY date_time DESC LIMIT $postsPerPage OFFSET $offset";
$result = mysqli_query($dbConnection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($dbConnection));
}

$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch total number of featured posts
$totalPostsQuery = "SELECT COUNT(*) as total FROM posts WHERE isFeatured = 1";
$totalPostsResult = mysqli_query($dbConnection, $totalPostsQuery);

if (!$totalPostsResult) {
    die("Total posts query failed: " . mysqli_error($dbConnection));
}

$totalPosts = mysqli_fetch_assoc($totalPostsResult)['total'];
$totalPages = ceil($totalPosts / $postsPerPage);
?>

<section class="section feature" aria-label="feature" id="featured">
    <div class="container">
        <?php if (count($posts) > 0) : ?>
            <ul class="feature-list">
                <?php foreach ($posts as $post) : ?>
                    <li>
                        <div class="card feature-card">
                            <figure class="card-banner img-holder" style="--width: 1602; --height: 903;">
                                <img src="images/<?= $post['thumbnail'] ?>" width="1602" height="903" loading="lazy" alt="Post image" class="img-cover">
                            </figure>

                            <div class="card-content">
                                <div class="card-wrapper">
                                    <?php
                                    $categoryId = $post['categoryId'];
                                    $categoryQuery = "SELECT * FROM categories WHERE id=$categoryId";
                                    $categoryResult = mysqli_query($dbConnection, $categoryQuery);
                                    if ($categoryResult) {
                                        $category = mysqli_fetch_assoc($categoryResult);
                                    }
                                    ?>
                                    <div class="card-tag">
                                        <?php if ($category) : ?>
                                            <a href="#" class="span hover-2">#<?= $category['title'] ?></a>
                                        <?php endif; ?>
                                        <?php if (!empty($post['badge'])) : ?>
                                            <a href="#" class="span hover-2">#<?= $post['badge'] ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h3 class="headline headline-3">
                                    <a href="post.php?id=<?= $post['id'] ?>&categoryId=<?= $post['categoryId'] ?>" class="card-title hover-2"><?= $post['title'] ?></a>
                                </h3>

                                <div class="card-wrapper">
                                    <?php
                                    $userId = $post['userId'];
                                    $userQuery = "SELECT * FROM account WHERE id = $userId";
                                    $userQueryResult = mysqli_query($dbConnection, $userQuery);

                                    if ($userQueryResult) {
                                        $user = mysqli_fetch_assoc($userQueryResult);
                                    }
                                    ?>
                                    <div class="profile-card">
                                        <?php if ($user) : ?>
                                            <img src="images/<?= $user['avatar'] ?>" width="48" height="48" loading="lazy" class="profile-banner">
                                            <div>
                                                <p class="card-title"><?= $user['username'] ?></p>
                                                <p class="card-subtitle"><?= $post['date_time'] ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <a href="post.php?id=<?= $post['id'] ?>&categoryId=<?= $post['categoryId'] ?>" class="card-btn">Read more</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="pagination">

                <?php if ($currentPage < $totalPages) : ?>
                    <a href="featuredPost.php?page=<?= $currentPage + 1 ?>" class="btn btn-secondary">
                        <span class="span">Show More Posts</span>
                        <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                    </a>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="alert-message error"><?= "No more posts found" ?></div>
        <?php endif; ?>
    </div>

    <img src="images/shadow-3.svg" width="500" height="1500" loading="lazy" alt="" class="feature-bg">
</section>

<?php
include './partials/footer.php';
?>