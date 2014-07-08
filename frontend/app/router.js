import Ember from "ember";

var Router = Ember.Router.extend({
    location: NovaENV.locationType
});

Router.map(function() {
    this.resource("settings");
    this.resource("movies", function() {
        this.resource("movie", { path: "/:movie_id" });
    });
    this.route("login");
});

export default Router;
