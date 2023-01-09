import Vue from 'vue'
const apiPrefix = "/api/badaso-api/v1";


import QueryString from "./query-string";

export default {
    facture(data = {}) {
        const ep = apiPrefix + '/avenue/facture';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);
    },
    getFactureByClientId(data = {}) {
        const ep = apiPrefix + '/factures/client';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);
    },
    setConsommation(data = {}) {
        const ep = apiPrefix + '/factures/set-consommation';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);
    }
    ,
    setPayement(data = {}) {
        const ep = apiPrefix + '/factures/set-payement';
        const qs = QueryString(data);
        const url = ep + qs;
        return Vue.prototype.$resource.get(url);
    }
}