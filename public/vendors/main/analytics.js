"use strict";

function analyticsTraking(title, obj) {
    analytics.track(title, obj);
    mixpanel.track(title, obj);
}
function addDataLayer($event, $data = {}) {
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({'event': $event, 'data': $data});
}
