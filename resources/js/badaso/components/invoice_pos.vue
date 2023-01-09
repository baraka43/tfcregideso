<template>

    <div>
        <div id="invoice-POS">

            <center id="top">
                <div class="logo">
                    <img class="logo" :src="getLogo" alt="">
                </div>
                <div class="info">
                    <h2>Regideso</h2>
                </div><!--End Info-->
            </center><!--End InvoiceTop-->

            <div id="mid">
                <div class="info">
                    <h2> Info</h2>
                    <p>
                        Address : place de l'independance</br>
                        Email : regideso@mail.com  </br>
                        Téléphone : 0977601591 </br>
                        N°: {{ info?.facture_id }} </br>
                    </p>
                </div>
            </div><!--End Invoice Mid-->

            <br>

            <div id="bot">

                <div id="table">
                    <table>
                        <tr class="tabletitle">
                          <th></th>
                          <th></th>
                        </tr>
                        <tr  class="service">
                            <td class="tableitem">
                                <p class="itemtext"> Responsable
                                </p>
                            </td>

                            <td class="tableitem amount">
                                <p class="itemtext">{{ info?.nom }} {{ info?.post_nom }} {{ info?.prenom }}</p>
                            </td>
                        </tr>

                        <tr  class="service">
                            <td class="tableitem">
                                <p class="itemtext">Categorie
                                    <br />
                                </p>
                            </td>

                            <td class="tableitem amount">
                                <p class="itemtext">{{ info?.categorie }}</p>
                            </td>
                        </tr>

                        <tr  class="service">
                            <td class="tableitem">
                                <p class="itemtext">
                                    Mois
                                </p>
                            </td>

                            <td class="tableitem amount">
                                <p class="itemtext">{{ info?.mois }} / {{ info?.annee }}</p>
                            </td>
                        </tr>

                        <tr  class="service">
                            <td class="tableitem">
                                <p class="itemtext">
                                    Consommation
                                </p>
                            </td>

                            <td class="tableitem amount">
                                <p class="itemtext">{{ info?.consommation_mensuelle }} m<sup>3</sup></p>
                            </td>
                        </tr>

                        <tr  class="service">
                            <td class="tableitem">
                                <p class="itemtext">
                                    Prix par m<sup>3</sup>
                                </p>
                            </td>

                            <td class="tableitem amount">
                                <p class="itemtext">{{ info?.prix }} Fc</p>
                            </td>
                        </tr>

                        <tr class="tabletitle">
                            <td class="Rate">
                                <h2>Total</h2>
                            </td>
                            <td class="payment amount">
                                <h2>{{ info?.consommation_mensuelle * info?.prix}} Fc</h2> 
                            </td>
                        </tr>

                    </table>
                </div><!--End Table-->

                <div id="legalcopy">
                    <p class="legal"><strong></strong> 
                    </p>
                </div>

            </div><!--End InvoiceBot-->

        </div>
        
    </div>
</template>

<script>
export default {
    props: ['info'],
    computed: {
       
        getLogo() {
            const url = this.$store.getters["badaso/getConfig"].adminPanelLogo
            return url;
        },
       
    }
}
</script>

<style >
#invoice-POS {
    /* box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); */
    padding: 2mm;
    margin: 0 auto;
    width: 58mm;
    background: #fff;

    display: none;
}

#invoice-POS ::selection {
    background: #f31544;
    color: #fff;
}

#invoice-POS ::moz-selection {
    background: #f31544;
    color: #fff;
}

#invoice-POS h1 {
    font-size: 1.5em;
    color: #222;
}

#invoice-POS h2 {
    font-size: 1.2em;
}

#invoice-POS h3 {
    font-size: 1.4em;
    font-weight: 300;
    line-height: 2em;
}

#invoice-POS p {
    font-size: 1.2em;
    color: rgb(0, 0, 0);
    line-height: 1.2em;
}

#invoice-POS #top,
#invoice-POS #mid,
#invoice-POS #bot {
    /* Targets all id with 'col-' */
    border-bottom: 1px solid #eee;
}

#invoice-POS #top {
    min-height: 100px;
}

#invoice-POS #mid {
    min-height: 80px;
}

#invoice-POS #bot {
    min-height: 50px;
}

#invoice-POS #top .logo {
    height: 60px;
    width: 60px;
    background-size: 60px 60px;
}

#invoice-POS .clientlogo {
    float: left;
    height: 60px;
    width: 60px;
    background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
    background-size: 60px 60px;
    border-radius: 50px;
}

#invoice-POS .info {
    display: block;
    margin-left: 0;
}

#invoice-POS .title {
    float: right;
}

#invoice-POS .title p {
    text-align: right;
}

#invoice-POS table {
    width: 100%;
    border-collapse: collapse;
}

#invoice-POS .tabletitle {
    font-size: 0.9em;
    background: #eee;
}

#invoice-POS .service {
    border-bottom: 1px solid #eee;
}

#invoice-POS .item {
    width: 24mm;
}

#invoice-POS .itemtext {
    font-size: 0.9em;
}

#invoice-POS #legalcopy {
    margin-top: 5mm;
}

#invoice-POS .amount {
    text-align: right;
    padding-right: 10px;
}

@media print {
    body * {
        visibility: hidden;
    }

    #invoice-POS,
    #invoice-POS * {
        visibility: visible;
        opacity: 1;

    }

    #invoice-POS {
        display: inline-block;
        border: 0;
        padding: 2mm;
        margin: 0 0;
        width: 80mm;
        background: #fff;
        position: absolute;
        top: 0;
        left: 0;
        height: 4cm;
    }
}
</style>