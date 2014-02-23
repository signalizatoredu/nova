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
