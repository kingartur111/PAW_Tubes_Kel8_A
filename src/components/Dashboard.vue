<template>
  <v-main>
    <v-row no-gutters>
      <v-col v-for="item in card" :key="item.title" class="mx-5">
        <v-card class="px-3 my-2">
          <v-row>
            <v-col>
              <v-card-title> {{ item.title }} </v-card-title>
              <v-card-text> {{ item.text }} </v-card-text>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
    <v-row no-gutters class="d-flex justify-center">
      <v-col>
        <v-card class="ma-5" height="500px">
          <v-card-title> Grafik Pengiriman </v-card-title>
          <v-card-text> </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-main>
</template>

<script>
export default {
  data() {
    return {
      userAll: [],
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
          if (data == "user") this.card[0].text = this.totalUser;
          else if (data == "buku") this.card[1].text = this.totalUser;
          else this.card[2].text = this.totalUser;
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