<template>
  <v-app>
    <router-view></router-view>
  </v-app>
</template>

<script>
export default {
  name: "App",
  data() {},
  mounted() {
    // window.onbeforeunload = function () {
    //   var storage = window.localStorage;
    //   storage.clear();
    // };
  },
};
</script>
