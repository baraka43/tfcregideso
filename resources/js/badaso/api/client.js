import Vue from 'vue'
const apiPrefix = "/api/badaso-api/v1";


import QueryString from "./query-string";

export default {
    getClient(data = {}) {
        const ep = apiPrefix + '/client';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);
    },

}