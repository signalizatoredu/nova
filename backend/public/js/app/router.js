App.Router.map(function() {
    this.resource("settings");
    this.resource("movies", function() {
        this.resource("movie", { path: "/:movie_id" });
    });
});
