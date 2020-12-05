<template>
  <v-main>
    <div class="d-flex justify-end mb-6 mx-5">
      <v-btn color="brown" dark @click="download"> Print Pdf</v-btn>
    </div>
    <v-row no-gutters>
      <v-col v-for="item in card" :key="item.title" class="mx-5">
        <v-card class="my-2">
          <v-row>
            <v-col>
              <v-card-title> {{ item.title }} </v-card-title>
              <v-card-text> {{ item.text }} </v-card-text>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
    <v-row no-gutters class="d-flex justify-center" height="500px">
      <v-col>
        <v-card class="ma-5">
          <v-card-title> Pertumbuhan User </v-card-title>
          <v-card-text>
            <line-chart
              :data="[
                ['Jan', jan],
                ['Feb', feb],
                ['Mar', mar],
                ['Apr', apr],
                ['Mei', mei],
                ['Jun', jun],
                ['Jul', jul],
                ['Aug', aug],
                ['Sep', sep],
                ['Oct', oct],
                ['Nov', nov],
                ['Des', des],
              ]"
            ></line-chart>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-main>
</template>

<script>
import { jsPDF } from "jspdf";
import { autoTable } from "jspdf-autotable";
// import VueHtml2pdf from "vue-html2pdf";

export default {
  data() {
    return {
      jan: 0,
      feb: 0,
      mar: 0,
      apr: 0,
      mei: 0,
      jun: 0,
      jul: 0,
      aug: 0,
      sep: 0,
      oct: 0,
      nov: 0,
      des: 0,
      userAll: [],
      month: [],
      totalUser: "",
      card: [
        {
          title: "Total User",
          text: "0",
        },
        {
          title: "Total Buku",
          text: "0",
        },
        {
          title: "Total Peminjaman",
          text: "0",
        },
      ],
      items: [],
      itemtotal: [],
      // title: this.$router.title,
    };
  },
  methods: {
    readData() {
      this.user();
      this.buku();
      this.peminjaman();
    },
    jumlahUser(arr) {
      (this.jan = arr.jan),
        (this.feb = arr.feb),
        (this.mar = arr.mar),
        (this.apr = arr.apr),
        (this.mei = arr.mei),
        (this.jun = arr.jun),
        (this.jul = arr.jul),
        (this.aug = arr.aug),
        (this.sep = arr.sep),
        (this.oct = arr.oct),
        (this.nov = arr.nov),
        (this.des = arr.des),
        this.pushItem();
    },
    get(url, data) {
      this.$http
        .get(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.userAll = response.data.data;
          this.totalUser = this.userAll.length;
          if (data == "user") {
            this.card[0].text = this.totalUser;
            this.month = response.data.month;
            this.jumlahUser(this.month);
            console.log(response.data.month);
          } else if (data == "buku") {
            this.card[1].text = this.totalUser;
          } else this.card[2].text = this.totalUser;
          // console.log(response);
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
        });
    },
    user() {
      var url = this.$api + "/userall";
      this.get(url, "user");
    },
    buku() {
      var url = this.$api + "/buku";
      this.get(url, "buku");
    },
    peminjaman() {
      var url = this.$api + "/peminjaman";
      this.get(url, "peminjaman");
    },
    pushItem() {
      this.items.push({ title: "Januari", body: this.jan });
      this.items.push({ title: "Februari", body: this.feb });
      this.items.push({ title: "Maret", body: this.mar });
      this.items.push({ title: "April", body: this.apr });
      this.items.push({ title: "Mei", body: this.mei });
      this.items.push({ title: "Juni", body: this.jun });
      this.items.push({ title: "July", body: this.jul });
      this.items.push({ title: "Agustus", body: this.aug });
      this.items.push({ title: "September", body: this.sep });
      this.items.push({ title: "Oktober", body: this.oct });
      this.items.push({ title: "November", body: this.nov });
      this.items.push({ title: "Desember", body: this.des });

      // this.itemtotal.push({ title: "Total User", body: this.card[0].text})
      // this.itemtotal.push({ title: "Total Buku", body: this.card[1].text})
      // this.itemtotal.push({ title: "Total Peminjaman", body: this.card[2].text})
    },
    download() {
      const columns = [
        { title: "Bulan", dataKey: "title" },
        { title: "Jumlah User", dataKey: "body" },
      ];
      const doc = new jsPDF({
        orientation: "portrait",
        unit: "in",
        format: "letter",
      });
      console.log(columns);
      doc.setFontSize(16).text("Perpus Tadika Mesra", 0.5, 1.0);
      doc.setLineWidth(0.01).line(0.5, 1.1, 8.0, 1.1);

      doc
        .setFontSize(12)
        .text("A. Data Pertambahan User di tahun 2020", 0.5, 1.5);

      console.log(autoTable);
      doc.autoTable({
        columns,
        body: this.items,
        margin: { left: 0.5, top: 1.75 },
      });
      // doc.setFontSize(12).text("B. Data Keseluruhan Perusahaan", 0.5, 8.0);
      // doc.autoTable({
      //   columns,
      //   body: this.itemtotal,
      //   margin: { left: 0.5, top: 8.75 },
      // });
      doc.save("Laporan.pdf");
    },
  },
  mounted() {
    this.readData();
  },
};
</script>