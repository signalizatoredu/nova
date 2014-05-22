App.MoviesRoute = Ember.Route.extend({
    model: function() {
        return this.store.find("movie");
    }
});
