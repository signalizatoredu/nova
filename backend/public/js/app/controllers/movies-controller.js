App.MoviesIndexController = Ember.ArrayController.extend({
    realQuery: "",
    query: "",

    updateKey: function(code) {
        if (code === 13)
            this.set("realQuery", this.get("query"));
    },

    filteredContent: function() {
        var query = this.get("query").toLowerCase();
        var content = this.get("content");

        if (!(query && query.trim()))
            return content;

        return content.filter(function(item) {
            var title = item.get("title").toLowerCase();
            return title.search(query) != -1;
        });

    }.property("realQuery", "content")
});
