<template>
  <v-main>
    <div class="d-flex justify-end mb-6 mx-5">
      <v-btn color="brown" dark @click="dialog = true"> Print Pdf</v-btn>
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
        console.log(this.des);
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
  },
  mounted() {
    this.readData();
  },
};
</script>