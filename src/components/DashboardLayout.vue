<template>
  <div class="dashboard">
    <v-navigation-drawer class="fullheight" width="256" app color="brown">
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title white--text font-weight-bold text-h5">
            TADIKA MESRA
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider class="mt-6" color="white"></v-divider>

      <v-list dense nav class="mt-6">
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          tag="router-link"
          :to="item.to"
        >
          <v-list-item-icon>
            <v-icon class="white--text">{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="white--text">{{
              item.title
            }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar app fixed height="75px">
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <h1 id="judul">Dashboard</h1>
      <VSpacer />

      <v-toolbar-items>
        <v-btn router @click="logout()">
          <v-icon>mdi-power</v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>
    <div class="grey lighten-4 fullheight pa-5">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
export default {
  name: "Dashboard",
  data() {
    return {
      items: [
        { title: "Dashboard", to: "/dashboard", icon: "mdi-view-dashboard" },
        { title: "Peminjaman", to: "/peminjaman", icon: "mdi-basket-fill" },
        { title: "Buku", to: "/buku", icon: "mdi-book-open-page-variant" },
        { title: "Pegawai", to: "/pegawai", icon: "mdi-account-settings" },
        {
          title: "Manajemen Anggota",
          to: "/manajemen",
          icon: "mdi-account-switch",
        },
      ],
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      localStorage.removeItem("id");
      console.log(localStorage.getItem("token"));
      delete this.$http.defaults.headers.common["Authorization"];
      console.log(this.$http.defaults.headers.common["Authorization"]);
      this.$router.push({
        path: "/login",
      });
    },
  },
};
</script>

<style scoped>
.fullheight {
  min-height: 100vh !important;
}
.router {
  text-decoration: none;
  color: black;
}
</style>
