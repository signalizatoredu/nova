<h1>Congratulations!</h1>

<p>You're now flying with Phalcon.</p>

<h3>Movies</h3>
<ul>
<?php foreach ($movies as $movie) { ?>
    <li><h4><?php echo $movie->title; ?></h4><?php echo $this->partial('partials/genres'); ?></li>
<?php } ?>
</ul>
