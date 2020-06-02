(function ($) {

    var Field = acf.models.RelationshipField.extend({
        type: 'bidirectional',
    });

    acf.registerFieldType(Field);


})(jQuery);
