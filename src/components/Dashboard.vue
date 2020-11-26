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
      card: [
        {
          title: "Total User",
          text: "19000",
        },
        {
          title: "Total Buku",
          text: "19000",
        },
        {
          title: "Total Peminjaman",
          text: "19000",
        },
      ],
      // title: this.$router.title,
    };
  },
};
</script>