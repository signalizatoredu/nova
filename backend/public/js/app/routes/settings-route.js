App.SettingsRoute = Ember.Route.extend({
    model: function() {
        return this.store.find("directory");
    }
});
