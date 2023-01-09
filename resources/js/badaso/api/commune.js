import Vue from 'vue'
const apiPrefix = "/api/badaso-api/v1";


import QueryString from "./query-string";

export default {
    get(data = {}) {
        const ep = apiPrefix + '/commune';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);
    },
    quartier(data = {}) {
        const ep = apiPrefix + '/quartier/commune';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);

    },
    avenuByaQuartierId(data = {}) {
        const ep = apiPrefix + '/quartier/avenue';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);
        
    },
}