export default DS.Model.extend({
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
