<h1>Congratulations!</h1>

<p>You're now showing a single movie!</p>

<h3>{{ movie.title }}</h3>
<ul>
{% for genre in movie.genres %}
    <li>{{ genre }}</li>
{% endfor %}
</ul>
