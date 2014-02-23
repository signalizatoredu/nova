window.App = Ember.Application.create();

App.PosterImageComponent = Ember.Component.extend({
    height: 200,
    width: 133,
    poster: null,

    loader: function() {
        var width = this.get("width"),
            height = this.get("height"),
            poster = this.get("poster");

        var img = this.$("img:first");
        var loader = this.$(".loader:first");

        var realUrl = "movies/" + poster + "/poster/" + width + "/" + height;

        var self = this;

        img.load(function() {
            loader.fadeOut("slow", function() {
            });
        }.bind(this));

        img.attr("src", realUrl);
    }.on('didInsertElement'),

    url: "",

    posterurl: function() {
        var url = this.get("url");

        return url;
    }.property("url"),

    style: function() {
        var width = this.get("width");
        var height = this.get("height");
        return "height:" + height + "px;width:" + width + "px;";
    }.property("height")
});

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

App.SettingsController = Ember.ArrayController.extend({
    sortProperties: ["path"],
    sortAscending: true,
    selectedDirectoryType: null,

    directoriesCount: function() {
        return this.get("model.length");
    }.property("@each"),

    directoryTypes: function() {
        return this.store.find("directoryType");
    }.property(),

    actions: {
        createDirectory: function() {
            var path = this.get("path");
            var type = this.get("selectedDirectoryType");

            console.log(path, type);
            if (!path.trim()) { return; }

            var record = this.store.createRecord("directory", {
                path: path,
                directoryType: type
            });

            record.save();

            this.set("path", "");
        },
        delete: function(directory) {
            directory.deleteRecord();
            directory.save();
        }
    }
});

App.Directory = DS.Model.extend({
    path: DS.attr("string"),

    directoryType: DS.belongsTo("directoryType"),
    movies: DS.hasMany("movie")
});

App.DirectoryType = DS.Model.extend({
    type: DS.attr("string"),

    directories: DS.hasMany("directory")
});

App.Movie = DS.Model.extend({
    // Properties
    title: DS.attr("string"),
    originalTitle: DS.attr("string"),
    sortTitle: DS.attr("string"),
    collection: DS.attr("string"),
    rating: DS.attr("number"),
    year: DS.attr("number"),
    outline: DS.attr("string"),
    plot: DS.attr("string"),
    tagline: DS.attr("string"),
    runtime: DS.attr("number"),
    certification: DS.attr("string"),
    imdbId: DS.attr("string"),
    tmdbId: DS.attr("number"),
    trailer: DS.attr("string"),
    genres: DS.attr(),
    studios: DS.attr(),
    countries: DS.attr(),
    credits: DS.attr(),
    directors: DS.attr(),
    actors: DS.attr(),
    backdrop: DS.attr("string"),
    poster: DS.attr("string"),

    // Relations
    directory: DS.belongsTo("directory")
});

App.Router.map(function() {
    this.resource("settings");
    this.resource("movies", function() {
        this.resource("movie", { path: "/:movie_id" });
    });
});

App.MovieRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find("movie", params.movie_id);
    },

    renderTemplate: function() {
        this.render("movies/movie", {
            into: "movies"
        });
    }
});

App.MoviesRoute = Ember.Route.extend({
    model: function() {
        return this.store.find("movie");
    }
});

App.SettingsRoute = Ember.Route.extend({
    model: function() {
        return this.store.find("directory");
    }
});

App.ApplicationAdapter = DS.ActiveModelAdapter;

App.MoviesIndexView = Ember.View.extend({
    keyPress: function(e) {
        this.get("controller").send("updateKey", e.keyCode);
    }
});
