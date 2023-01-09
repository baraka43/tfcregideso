<template lang="html">
    <div>
        <vs-row>
            <vs-card>
                <div slot="header">
                    <h3>
                        les avanue du quartier : {{ quartier }}
                    </h3>
                </div>
            </vs-card>

            <vs-card>
                <vs-table search :data="quartiers" stripe>
                    <template slot="header">
                        <h3>
                            Avenue
                        </h3>
                    </template>
                    <template slot="thead">
                        <vs-th>
                            N°
                        </vs-th>
                        <vs-th sort-key="designation">
                            Designation
                        </vs-th>
                        <vs-th align="end">

                        </vs-th>

                    </template>

                    <template slot-scope="{data}">
                        <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                            <vs-td>
                                {{ indextr + 1}}
                            </vs-td>

                            <vs-td :data="data[indextr].designation">
                                {{ data[indextr].designation }}
                            </vs-td>

                            <vs-td align="end">
                                <vs-button @click="factures(data[indextr])" type="filled">Factures</vs-button>
                            </vs-td>


                        </vs-tr>
                    </template>


                </vs-table>
            </vs-card>


        </vs-row>
    </div>
</template>

<script>
export default {
    data: () => ({
        quartiers: [],
    }),
    props: {
        idQuartier: 0,
        quartier: ''
    },
    mounted() {
        this.getQuartiers()
    },
    methods: {
        async getQuartiers() {
            this.$openLoader();
            try {
                this.$api.commune.avenuByaQuartierId({ idQuartier: this.idQuartier }).then((response) => {
                    this.quartiers = response.data;
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
        factures(avenue) {
            this.$router.push({
                name: 'factureAvenue', params: {
                    idAvenue: avenue.id,
                    avenue: avenue.designation
                }
            });
        }
    },
}
</script>
