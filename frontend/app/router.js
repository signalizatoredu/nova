var Router = Ember.Router.extend({
  location: ENV.locationType
});

Router.map(function() {
    this.resource("settings");
    this.resource("movies", function() {
        this.resource("movie", { path: "/:movie_id" });
    });
});

export default Router;
