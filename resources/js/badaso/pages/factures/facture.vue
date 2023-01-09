<template >
    <div>
        <vs-row>
            <vs-card>
                <div slot="header">
                    <h3>
                        les factures de l'avenue {{ avenue }}
                    </h3>
                    <br>
                    <vs-col col="6">
                        <badaso-select size="6" v-model="selectedMode" label="Mode" :items="mode"> </badaso-select>
                    </vs-col>

                </div>
            </vs-card>

            <vs-card>
                <vs-table search :data="selectedMode !== 'dossier' ? getFactureByMode : clients" stripe>
                    <template slot="header">
                        <h3>
                            Avenue
                        </h3>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            N°
                        </vs-th>
                        <vs-th sort-key="nom">
                            Client
                        </vs-th>

                        <vs-th sort-key="moi">
                            Categorie
                        </vs-th>

                        <vs-th sort-key="moi" v-if="selectedMode !== 'dossier'">
                            prix par metrè cube
                        </vs-th>

                        <vs-th sort-key="moi" v-if="selectedMode !== 'dossier'">
                            prix par metrè cube
                        </vs-th>

                        <vs-th sort-key="moi" v-if="selectedMode !== 'dossier'">
                            Mois
                        </vs-th>
                        <vs-th v-if="selectedMode == 'recouvrement'">
                            Consommation
                        </vs-th>
                        <vs-th v-if="selectedMode == 'recouvrement'">
                            Montant
                        </vs-th>

                        <vs-th align="end">

                        </vs-th>

                    </template>

                    <template slot-scope="{data}">
                        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                            <vs-td>
                                {{ indextr + 1}}
                            </vs-td>

                            <vs-td
                                :data="data[indextr].nom + ' ' + data[indextr].post_nom + ' ' + data[indextr].prenom">
                                {{ data[indextr].nom }}
                                {{ data[indextr].post_nom }}
                                {{ data[indextr].prenom }}
                            </vs-td>
                            <vs-td :data="data[indextr].categorie">
                                {{ data[indextr].categorie }}
                            </vs-td>

                            <vs-td v-if="selectedMode !== 'dossier'">
                                {{ data[indextr].prix }} FC
                            </vs-td>

                            <vs-td v-if="selectedMode !== 'dossier'"
                                :data="data[indextr].mois + '/' + data[indextr].annee">
                                {{ data[indextr].mois }} / {{ data[indextr].annee }}
                            </vs-td>
                            <vs-td v-if="selectedMode == 'recouvrement'">
                                {{ data[indextr].consommation_mensuelle }} m<sup>3</sup>
                            </vs-td>
                            <vs-td v-if="selectedMode == 'recouvrement'">
                                {{ + (data[indextr].prix * data[indextr].consommation_mensuelle)}} Fc
                            </vs-td>
                            <vs-td align="end">
                                <vs-button v-if="selectedMode == 'Completion'" @click="openPromps(data[indextr])"
                                    type="filled">Completer</vs-button>
                                <vs-button v-if="selectedMode == 'recouvrement'" @click="payer(data[indextr])"
                                    type="filled">payer</vs-button>

                                <vs-button v-if="selectedMode == 'dossier'" @click="getCleintByFacture(data[indextr].client_id)"
                                    type="filled">Fatures</vs-button>
                            </vs-td>


                        </vs-tr>
                    </template>
                </vs-table>
            </vs-card>

            <invoice-pos :info="selectedClient"></invoice-pos>

            <vs-prompt @cancel="annulerConsommation()" @accept="setConsommetion()" @close="annulerConsommation()"
                :active.sync="activePrompt">
                <div class="con-exemple-prompt">
                    <p>Le prix par metrè cube est <strong> {{ selectedClient?.prix }}</strong> pour la categorie {{
                        selectedClient?.categorie
                    }}</p> <br>
                    <p>Le coût total est <strong> {{ + selectedClient?.prix }} x {{ + tmpConsomation }} = {{
                    + (tmpConsomation * selectedClient?.prix)}} Fc</strong> </p> <br>

                    <badaso-number label="Conosommation en metrè cube" placeholder="Entrer la consommation mensuelle"
                        v-model="tmpConsomation" size="12">
                    </badaso-number>

                </div>
            </vs-prompt>


            <vs-prompt  @close="annulerConsommation()" :active.sync="activePromptFactueres">
                <div class="con-exemple-prompt">

                    <vs-table stripe :data="client_factures">
                        <template slot="header">
                            <h3>
                                Factures
                            </h3>
                        </template>
                        <template slot="thead">
                            <vs-th>
                                Mois
                            </vs-th>
                            <vs-th>
                                Montant
                            </vs-th>
                            <vs-th>
                                Etat
                            </vs-th>

                        </template>

                        <template slot-scope="{data}">
                            <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                                <vs-td>
                                    {{ data[indextr].mois }} / {{ data[indextr].annee }}
                                </vs-td>
                                <vs-td>
                                    {{ data[indextr].prix }}Fc
                                </vs-td>
                                <vs-td>
                                    {{ data[indextr].consommation_mensuelle }} m <sup>3</sup>
                                </vs-td>
                                <vs-td>
                                    {{ data[indextr].montant }} Fc
                                </vs-td>
                            </vs-tr>
                        </template>
                    </vs-table>
                </div>
            </vs-prompt>

        </vs-row>
    </div>
</template>

<script>
export default {
    data: () => ({
        factures: [],
        clients: [],
        client_factures: [],
        mode: [
            {
                label: "Recouvrement",
                value: 'recouvrement'
            },
            {
                label: "Completion de la consommation mensuelle",
                value: 'Completion'
            },
            {
                label: "Dossier",
                value: 'dossier'
            }
        ],
        selectedMode: 'recouvrement',
        activePrompt: false,
        selectedClient: {},
        tmpConsomation: '',
        activePromptFactueres:false
    }),
    props: {
        idAvenue: 0,
        avenue: ''
    },
    mounted() {
        this.getfactures();
        this.getClients();

    },
    methods: {
        async getfactures() {
            this.$openLoader();
            try {
                this.$api.facture.facture({ idAvenue: this.idAvenue }).then((response) => {
                    this.factures = response.data;
                    this.$closeLoader();
                })
            } catch (error) {
                if (error.status == 503) {
                    this.showMaintenancePage = true;
                }
                this.$closeLoader();
                this.$vs.notify({
                    title: "alert.danger",
                    text: error.message,
                    color: "danger",
                });
            }
        },
        async getClients() {
            this.$openLoader();
            try {
                this.$api.client.getClient({ avenue_id: this.idAvenue }).then((response) => {
                    this.clients = response.data;
                    this.$closeLoader();
                })
            } catch (error) {
                if (error.status == 503) {
                    this.showMaintenancePage = true;
                }
                this.$closeLoader();
                this.$vs.notify({
                    title: "alert.danger",
                    text: error.message,
                    color: "danger",
                });
            }
        },
        async getCleintByFacture(id) {
            this.$openLoader();
            try {
                this.$api.facture.getFactureByClientId({ client_id: id }).then((response) => {
                    this.client_factures = response.data;
                    this.$closeLoader();
                    this.activePromptFactueres = true
                })
            } catch (error) {
                if (error.status == 503) {
                    this.showMaintenancePage = true;
                }
                this.$closeLoader();
                this.$vs.notify({
                    title: "alert.danger",
                    text: error.message,
                    color: "danger",
                });
            }
        },
        openPromps(client_data) {
            this.activePrompt = true;
            this.selectedClient = client_data
        },
        factures_x(avenue) {
            this.$router.push({
                name: 'factureAvenue', params: {
                    idAvenue: avenue.id,
                    avenue: avenue.designation
                }
            });
        },
        setConsommetion() {
            this.$openLoader();
            this.$api.facture.setConsommation({
                consommation: this.tmpConsomation,
                idFacture: this.selectedClient.facture_id
            }).then((response) => {
                this.$vs.notify({
                    title: 'message',
                    color: 'success',
                    text: 'La consommation est enregistrée'
                });
                this.getfactures();
                this.$closeLoader();
                this.factures.splice(this.factures.indexOf(this.selectedClient), 1);
            })
        },
        annulerConsommation() {
            return 0;
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        payer(client_data) {
            this.$openLoader();
            this.selectedClient = client_data
            this.$api.facture.setPayement({ facture_id: client_data.facture_id }).then(() => {
                this.sleep(200).then(() => {
                    this.$closeLoader();
                    window.print();
                    this.getfactures();
                    this.factures.splice(this.factures.indexOf(this.selectedClient), 1);
                });
            }).catch(() => {
                this.$closeLoader();
            })
        },
        getDossierClient() {

        }
    },


    computed: {
        getFactureByMode() {


            if (this.selectedMode === 'recouvrement') {
                return this.factures.filter(f => f.etat == 'non_payé')
            } else if (this.selectedMode === 'Completion') {
                return this.factures.filter(f => f.etat == 'initial')
            } else if (this.selectedMode === 'dossier') {
                return this.factures.filter(f => f.etat == 'initial')
            }
            return this.factures;
        }
    }
}
</script>
