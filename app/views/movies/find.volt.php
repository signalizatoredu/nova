<h1>Congratulations!</h1>

<p>You're now showing a single movie!</p>

<h3><?php echo $movie->title; ?></h3>
<ul>
<?php foreach ($movie->genres as $genre) { ?>
    <li><?php echo $genre; ?></li>
<?php } ?>
</ul>
