<?php
include './partials/header.php';
require 'config/database.php';

$postsPerPage = 10;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int) $_GET['page'];
} else {
    $currentPage = 1;
}

$offset = ($currentPage - 1) * $postsPerPage;

// Check database connection
if (!$dbConnection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$recentPostQuery = "SELECT * FROM posts ORDER BY date_time DESC LIMIT $postsPerPage OFFSET $offset";
$recentPostResult = mysqli_query($dbConnection, $recentPostQuery);

// Check if the query was successful
if (!$recentPostResult) {
    die("Query failed: " . mysqli_error($dbConnection));
}

$recentPosts = mysqli_fetch_all($recentPostResult, MYSQLI_ASSOC);

// Count total posts to determine if there are more posts
$totalPostsQuery = "SELECT COUNT(*) as total FROM posts";
$totalPostsResult = mysqli_query($dbConnection, $totalPostsQuery);

// Check if the query was successful
if (!$totalPostsResult) {
    die("Total posts query failed: " . mysqli_error($dbConnection));
}

$totalPosts = mysqli_fetch_assoc($totalPostsResult)['total'];
$totalPages = ceil($totalPosts / $postsPerPage);

?>
<section class="section recent-post" id="recent" aria-labelledby="recent-label">
    <div class="container">
        <div class="post-main">
            <h2 class="headline headline-2 section-title">
                <span class="span">Recent posts</span>
            </h2>
            <p class="section-text">Don't miss the latest trends</p>
            <?php if (mysqli_num_rows($recentPostResult) > 0) : ?>
                <ul class="grid-list">
                    <?php foreach ($recentPosts as $recentPost) : ?>
                        <li>
                            <div class="recent-post-card">
                                <figure class="card-banner img-holder" style="--width: 271; --height: 258;">
                                    <img src="images/<?= $recentPost['thumbnail'] ?>" width="271" height="258" loading="lazy" class="img-cover">
                                </figure>
                                <div class="card-content">
                                    <?php if (!empty($recentPost['badge'])) : ?>
                                        <a href="#" class="card-badge"><?= $recentPost['badge'] ?></a>
                                    <?php endif; ?>
                                    <h3 class="headline headline-3 card-title">
                                        <a href="post.php?id=<?= $recentPost['id'] ?>&categoryId=<?= $recentPost['categoryId'] ?>" class="link hover-2"><?= $recentPost['title'] ?></a>
                                    </h3>
                                    <p class="card-text">
                                        <?= substr($recentPost['body'], 0, 200) ?>......
                                    </p>
                                    <div class="card-wrapper">
                                        <div class="card-tag">
                                            <?php
                                            $recentPostCategoryId = $recentPost['categoryId'];
                                            $recentCategory = "SELECT * FROM categories WHERE id=$recentPostCategoryId";
                                            $recentCategoryQueryResult = mysqli_query($dbConnection, $recentCategory);

                                            // Check if the query was successful
                                            if (!$recentCategoryQueryResult) {
                                                die("Category query failed: " . mysqli_error($dbConnection));
                                            }

                                            $recentCategoryResult = mysqli_fetch_assoc($recentCategoryQueryResult);
                                            ?>
                                            <a href="#" class="span hover-2"># <?= $recentCategoryResult['title'] ?></a>
                                            <?php if (!empty($recentPost['badge'])) : ?>
                                                <a href="#" class="span hover-2"># <?= $recentPost['badge'] ?></a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="wrapper">
                                            <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
                                            <span class="span"><?= $recentPost['date_time'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No recent posts available.</p>
            <?php endif; ?>
            <?php if ($currentPage < $totalPages) : ?>
                <a href="morePost.php?page=<?= $currentPage + 1 ?>" class="btn btn-secondary">
                    <span class="span">Show More Posts</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
include './partials/footer.php';
?>