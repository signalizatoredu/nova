import DS from 'ember-data';

export default DS.Model.extend({
    path: DS.attr('string'),

    directoryType: DS.belongsTo('directoryType'),
    movies: DS.hasMany('movie')
});
