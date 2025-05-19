<?php
include 'partials/header.php';
require 'config/database.php';

$hotTopicQuery = "SELECT * FROM categories ORDER BY view DESC LIMIT 6";
$hotTopicResult = mysqli_query($dbConnection, $hotTopicQuery);
$hotTopics = mysqli_fetch_all($hotTopicResult, MYSQLI_ASSOC);


$categoryQuery = "SELECT * FROM categories";
$categoryResult  = mysqli_query($dbConnection, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);



$FeaturePostsPerPage = 5;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
  $currentFeaturedPage = (int) $_GET['page'];
} else {
  $currentFeaturedPage = 1;
}

$featuredOffset = ($currentFeaturedPage - 1) * $FeaturePostsPerPage;

$featuredQuery = "SELECT * FROM posts WHERE isFeatured=1 ORDER BY date_time DESC LIMIT $FeaturePostsPerPage OFFSET $featuredOffset";
$featuredQueryResult = mysqli_query($dbConnection, $featuredQuery);
$featuredResults = mysqli_fetch_all($featuredQueryResult, MYSQLI_ASSOC);

$totalFeaturePostsQuery = "SELECT COUNT(*) as total FROM posts";
$totalFeaturedPostsResult = mysqli_query($dbConnection, $totalFeaturePostsQuery);
$totalFeaturedPosts = mysqli_fetch_assoc($totalFeaturedPostsResult)['total'];
$totalFeaturedPages = ceil($totalFeaturedPosts / $FeaturePostsPerPage);





$postsPerPage = 10;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
  $currentPage = (int) $_GET['page'];
} else {
  $currentPage = 1;
}

$offset = ($currentPage - 1) * $postsPerPage;

$recentPostQuery = "SELECT * FROM posts ORDER BY date_time DESC LIMIT $postsPerPage OFFSET $offset";
$recentPostResult = mysqli_query($dbConnection, $recentPostQuery);
$recentPosts = mysqli_fetch_all($recentPostResult, MYSQLI_ASSOC);

$totalPostsQuery = "SELECT COUNT(*) as total FROM posts";
$totalPostsResult = mysqli_query($dbConnection, $totalPostsQuery);
$totalPosts = mysqli_fetch_assoc($totalPostsResult)['total'];
$totalPages = ceil($totalPosts / $postsPerPage);

?>
<main>
  <article>
    <section class="hero" id="home" aria-label="home">
      <div class="container">
        <div class="hero-content">
          <p class="hero-subtitle">Hello <?= $_SESSION['fname'] ?>!</p>
          <h1 class="headline headline-1 section-title">
            <span class="span">We're Curious Chronicles</span>
          </h1>
          <p class="hero-text">
            "Welcome to Curious Chronicles! 🌟 Get ready to embark on a
            journey of wonder and discovery as we ignite curiosity through
            captivating stories. We're delighted to have you join our
            community. Let's explore the extraordinary together, one story
            at a time!"
          </p>
        </div>

        <div class="hero-banner">
          <img src="images/<?= $_SESSION['avatar'] ?> " style="margin-bottom: 10px;" width="327" height="490" alt="Profile Picture" class="w-100" />
        </div>
      </div>
    </section>

    <!-- topics -->
    <section class="topics" id="topics" aria-labelledby="topic-label">
      <div class="container">
        <div class="card topic-card">

          <div class="card-content">

            <h2 class="headline headline-2 section-title card-title" id="topic-label">
              Hot topics
            </h2>

            <p class="card-text">
              Stay updated with the latest news. Don't miss out!
            </p>

            <div class="btn-group">
              <button class="btn-icon" aria-label="previous" data-slider-prev>
                <ion-icon name="arrow-back" aria-hidden="true"></ion-icon>
              </button>

              <button class="btn-icon" aria-label="next" data-slider-next>
                <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
              </button>
            </div>

          </div>
          <?php if (mysqli_num_rows($hotTopicResult) > 0) : ?>
            <div class="slider" data-slider>
              <ul class="slider-list" data-slider-container>
                <?php foreach ($hotTopics as $hotTopic) : ?>
                  <li class="slider-item">
                    <a href="categoryPost.php?id=<?= $hotTopic['id'] ?>" class="slider-card">

                      <figure class="slider-banner img-holder" style="--width: 507; --height: 618;">
                        <img src="images/<?= $hotTopic['avatar'] ?>" width="507" height="618" loading="lazy" alt="Sport" class="img-cover">
                      </figure>

                      <div class="slider-content">
                        <span class="slider-title"><?= $hotTopic['title'] ?></span>
                        <?php

                        $hotTopicId = $hotTopic['id'];
                        $postCountQuery = "SELECT COUNT(*) AS post_count FROM posts WHERE categoryId = $hotTopicId";
                        $postCountResult = mysqli_query($dbConnection, $postCountQuery);
                        $postCountData = mysqli_fetch_assoc($postCountResult);


                        ?>
                        <p class="slider-subtitle"><?= $postCountData['post_count'] ?> Articles</p>
                      </div>

                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>


    <!-- Featured Articles -->
    <section class="section feature" aria-label="feature" id="featured">
      <div class="container">

        <h2 class="headline headline-2 section-title">
          <span class="span">Editor's picked</span>
        </h2>

        <p class="section-text">
          Featured and highly rated articles
        </p>
        <?php if (mysqli_num_rows($featuredQueryResult) > 0) : ?>
          <ul class="feature-list">
            <?php foreach ($featuredResults as $featuredResult) : ?>
              <li>
                <div class="card feature-card">

                  <figure class="card-banner img-holder" style="--width: 1602; --height: 903;">
                    <img src="images/<?= $featuredResult['thumbnail'] ?>" width="1602" height="903" loading="lazy" class="img-cover">
                  </figure>

                  <div class="card-content">

                    <div class="card-wrapper">
                      <div class="card-tag">
                        <?php
                        $featuredPostCategoryId = $featuredResult['categoryId'];
                        $featuredCategory = "SELECT * FROM categories WHERE id=$featuredPostCategoryId";
                        $featuredCategoryQueryResult = mysqli_query($dbConnection, $featuredCategory);
                        $featuredCategoryResult = mysqli_fetch_assoc($featuredCategoryQueryResult);
                        ?>

                        <a href="categoryPost.php?id=<?= $featuredCategoryResult['id'] ?>" class="span hover-2"># <?= $featuredCategoryResult['title'] ?></a>

                        <?php if (!empty($featuredCategoryResult['badge'])) : ?>
                          <a href="#" class="span hover-2"># <?= $featuredCategoryResult['badge'] ?></a>
                        <?php endif; ?>
                      </div>

                      <div class="wrapper">
                        <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                        <span class="span"><?= $featuredResult['date_time'] ?></span>
                      </div>
                    </div>

                    <h3 class="headline headline-3">
                      <a href="post.php?id=<?= $featuredResult['id'] ?>&categoryId=<?= $featuredResult['categoryId'] ?>" class="card-title hover-2">
                        <?= $featuredResult['title'] ?>
                      </a>
                    </h3>

                    <div class="card-wrapper">
                      <?php
                      $userId = $featuredResult['userId'];
                      $userQuery = "SELECT * FROM account WHERE id = $userId";
                      $userQueryResult = mysqli_query($dbConnection, $userQuery);
                      $user = mysqli_fetch_assoc($userQueryResult);
                      ?>
                      <div class="profile-card">
                        <img src="images/<?= $user['avatar'] ?>" width="48" height="48" loading="lazy" alt="Joseph" class="profile-banner">

                        <div>
                          <p class="card-title"><?= $user['username']  ?></p>

                          <p class="card-subtitle"><?= $featuredResult['date_time']  ?></p>
                        </div>
                      </div>

                      <a href="post.php?id=<?= $featuredResult['id'] ?>&categoryId=<?= $featuredResult['categoryId'] ?>" class="card-btn">Read more</a>

                    </div>

                  </div>

                </div>
              </li>
            <?php endforeach; ?>


          </ul>
        <?php endif; ?>
        <?php if ($currentFeaturedPage < $totalFeaturedPages) : ?>
          <a href="featuredPost.php?page=<?= $currentFeaturedPage + 1 ?>" class="btn btn-secondary">
            <span class="span">Show More Posts</span>
          </a>
        <?php endif; ?>

      </div>

      <img src="images/shadow-3.svg" width="500" height="1500" loading="lazy" alt="" class="feature-bg">

    </section>

    <!-- Category -->
    <section class="tags" aria-labelledby="tag-label">
      <div class="container">

        <h2 class="headline headline-2 section-title" id="tag-label">
          <span class="span">Category</span>
        </h2>

        <p class="section-text">
          Blog catergories
        </p>
        <?php if (mysqli_num_rows($categoryResult) > 0) : ?>
          <ul class="grid-list">
            <?php foreach ($categories as $category) : ?>
              <li>
                <button class="card tag-btn" onclick="window.location.href='categoryPost.php?id=<?= $category['id'] ?>'">
                  <img src="images/<?= $category['avatar'] ?>" width="32" height="32" style="border-radius: 50%;" loading="lazy">
                  <p class="btn-text"><?= $category['title'] ?></p>
                </button>
              </li>
            <?php endforeach; ?>

          </ul>
        <?php else : ?>
          <div class="alert-message error"><?= "No categories found" ?></div>
        <?php endif; ?>
      </div>
    </section>


    <!-- 
        - #RECENT POST
      -->

    <section class="section recent-post" id="recent" aria-labelledby="recent-label">
      <div class="container">

        <div class="post-main">

          <h2 class="headline headline-2 section-title">
            <span class="span">Recent posts</span>
          </h2>

          <p class="section-text">
            Don't miss the latest trends
          </p>
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
                          $recentCategoryResult = mysqli_fetch_assoc($recentCategoryQueryResult);
                          ?>

                          <a href="categoryPost.php?id=<?= $recentCategoryResult['id'] ?>" class="span hover-2"># <?= $recentCategoryResult['title'] ?></a>

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
          <?php endif; ?>
          <?php if ($currentPage < $totalPages) : ?>
            <a href="morePost.php?page=<?= $currentPage + 1 ?>" class="btn btn-secondary">
              <span class="span">Show More Posts</span>
            </a>
          <?php endif; ?>

        </div>




      </div>
    </section>

  </article>
</main>





<!-- 
    - #FOOTER
  -->
<?php
include 'partials/footer.php';
?>
<!-- 
    - #BACK TO TOP
  -->