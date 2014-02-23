<h1>Congratulations!</h1>

<p>You're now flying with Phalcon.</p>

<h3>Movies</h3>
<ul>
{% for movie in movies %}
    <li><h4>{{ movie.title }}</h4>{{ partial("partials/genres") }}</li>
{% endfor %}
</ul>
