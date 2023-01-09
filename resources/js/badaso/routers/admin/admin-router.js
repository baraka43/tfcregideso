import Commune from '../../pages/factures/commune.vue';
import quartier from '../../pages/factures/quartier.vue';
import avenue from '../../pages/factures/avenue.vue';
import facture from '../../pages/factures/facture.vue';

const prefix = process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  ? "/" + process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  : "/badaso-dashboard";

export default [
  {
    path: prefix + "/facture-commune",
    name: "factureCommune",
    component: Commune,
    meta: {
      title: "Commune",
    },

  }, {
    path: prefix + "/facture-commune-quartier/:idCommune/:commune",
    name: "factureCommuneQuartier",
    component: quartier,
    props: true,
    meta: {
      title: "Quartier",
    },
  }, 
  {
    path: prefix + "/facture-quartier-avenue/:idQuartier/:quartier",
    name: "factureQuartierAvenue",
    component: avenue,
    props: true,
    meta: {
      title: "Avenue",
    },
  }, 
  {
    path: prefix + "/facture-avenue/:idAvenue/:avenue",
    name: "factureAvenue",
    component: facture,
    props: true,
    meta: {
      title: "Facture",
    },
  }
];
