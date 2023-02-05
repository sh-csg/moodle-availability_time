// eslint-disable-next-line camelcase
M.availability_time = M.availability_time || {};

M.availability_time.form = Y.Object(M.core_availability.plugin);

M.availability_time.form.initInner = function(param) {
    this.params = param;
};

M.availability_time.form.getNode = function(json) {
    var node = Y.Node.create('<span>' + this.params + '</span>');
    if (json.from === undefined) {
        json.from = 0;
    }
    if (json.to === undefined) {
        json.to = 0;
    }
    var fromhour = ('' + parseInt(json.from / 3600)).padStart(2, 0);
    var fromminute = ('' + parseInt(json.from / 60 % 60)).padStart(2, 0);
    var tohour = ('' + parseInt(json.to / 3600)).padStart(2, 0);
    var tominute = ('' + parseInt(json.to / 60 % 60)).padStart(2, 0);

    var select = node.one('select[name=availability_time_from_hour]');
    select.set('value', fromhour);
    select = node.one('select[name=availability_time_from_minute]');
    select.set('value', fromminute);
    select = node.one('select[name=availability_time_to_hour]');
    select.set('value', tohour);
    select = node.one('select[name=availability_time_to_minute]');
    select.set('value', tominute);

    if (!M.availability_time.form.addedEvents) {
        M.availability_time.form.addedEvents = true;
        var root = Y.one('#fitem_id_availabilityconditionsjson');
        root.delegate('click', function() {
            M.core_availability.form.update();
        }, '.availability_time select');
    }

    return node;
};

M.availability_time.form.fillValue = function(value, node) {
    var fromhour = parseInt(node.one('select[name=availability_time_from_hour]').get('value'));
    var fromminute = parseInt(node.one('select[name=availability_time_from_minute]').get('value'));
    var tohour = parseInt(node.one('select[name=availability_time_to_hour]').get('value'));
    var tominute = parseInt(node.one('select[name=availability_time_to_minute]').get('value'));
    value.from = Date.UTC(1970, 0, 1, fromhour, fromminute, 0, 0) / 1000;
    value.to = Date.UTC(1970, 0, 1, tohour, tominute, 0, 0) / 1000;
};
