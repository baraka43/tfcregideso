<template lang="html">
    <div>
        <vs-row>
            <vs-card>
                <div slot="header">
                    <h3>
                        Toutes les communes
                    </h3>
                </div>
            </vs-card>

            <vs-card>
                <vs-table search :data="communes" stripe>
                    <template slot="header">
                        <h3>
                            Communes
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
                                <vs-button @click="quartier(tr)" type="filled">Quartiers</vs-button>
                                <!-- <vs-button type="filled">Avenues</vs-button>
                                <vs-button type="filled">Factures</vs-button> -->

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
        users: [
            {
                "id": 1,
                "name": "Leanne Graham",
                "username": "Bret",
                "email": "Sincere@april.biz",
                "website": "hildegard.org",
            },
            {
                "id": 2,
                "name": "Ervin Howell",
                "username": "Antonette",
                "email": "Shanna@melissa.tv",
                "website": "anastasia.net",
            },
            {
                "id": 3,
                "name": "Clementine Bauch",
                "username": "Samantha",
                "email": "Nathan@yesenia.net",
                "website": "ramiro.info",
            },
            {
                "id": 4,
                "name": "Patricia Lebsack",
                "username": "Karianne",
                "email": "Julianne.OConner@kory.org",
                "website": "kale.biz",
            },
            {
                "id": 5,
                "name": "Chelsey Dietrich",
                "username": "Kamren",
                "email": "Lucio_Hettinger@annie.ca",
                "website": "demarco.info",
            },
            {
                "id": 6,
                "name": "Mrs. Dennis Schulist",
                "username": "Leopoldo_Corkery",
                "email": "Karley_Dach@jasper.info",
                "website": "ola.org",
            },
            {
                "id": 7,
                "name": "Kurtis Weissnat",
                "username": "Elwyn.Skiles",
                "email": "Telly.Hoeger@billy.biz",
                "website": "elvis.io",
            },
            {
                "id": 8,
                "name": "Nicholas Runolfsdottir V",
                "username": "Maxime_Nienow",
                "email": "Sherwood@rosamond.me",
                "website": "jacynthe.com",
            },
            {
                "id": 9,
                "name": "Glenna Reichert",
                "username": "Delphine",
                "email": "Chaim_McDermott@dana.io",
                "website": "conrad.com",
            },
            {
                "id": 10,
                "name": "Clementina DuBuque",
                "username": "Moriah.Stanton",
                "email": "Rey.Padberg@karina.biz",
                "website": "ambrose.net",
            }
        ],
        communes: [],
    }),
    mounted() {
        this.getCommune()
    },
    methods: {
        async getCommune() {
            this.$openLoader();
            try {
                this.$api.commune.get().then((response) => {
                    this.communes = response.data;
                    this.$closeLoader();
                })
            } catch (error) {
                if (error.status == 503) {
                    this.showMaintenancePage = true;
                }
                this.$closeLoader();
                this.$vs.notify({
                    title: this.$t("alert.danger"),
                    text: error.message,
                    color: "danger",
                });
            }
        },
        quartier(commune) {
            this.$router.push({ name: 'factureCommuneQuartier', params: { idCommune: commune.id,  commune: commune.designation}});
        }
    },
}
</script>