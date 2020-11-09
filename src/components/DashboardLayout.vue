<template>
  <div class="dashboard">
    <v-navigation-drawer class="fullheight" width="256" permanent app fixed>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title"> Calvindo Aldi </v-list-item-title>
          <v-list-item-subtitle> 180709771 </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          tag="router-link"
          :to="item.to"
        >
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
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
        { title: "Dashboard", to: "/" },
        { title: "GD", to: "/gd" },
        { title: "UGD", to: "/UGD" },
        { title: "Tugas", to: "/Tugas" },
      ],
    };
  },
};
</script>

<style scoped>
.fullheight {
  min-height: 100vh !important;
}
</style>
