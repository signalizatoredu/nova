import Ember from 'ember';

export default Ember.Route.extend({
    model: function(params) {
        return this.store.find('movie', params.movie_id);
    },

    renderTemplate: function() {
        this.render('movies/movie', {
            into: 'movies'
        });
    }
});
