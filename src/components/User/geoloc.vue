<!-- @format -->
<template>
  <main>
    <div>
      <v-app-bar
        app
        absolute
        height="75px"
        style="background: rgba(61, 30, 26, 0.8)"
      >
        <h3 style="color: white">Perpustakaan Tadika Mesra</h3>

        <v-flex>
          <v-btn-toggle
            tile
            color="white accent-3"
            class="d-flex justify-center"
            align="center"
            justify="center"
            style="margin-left: -50px"
            rounded
            group
          >
            <v-btn value="home" @click="pindahPage(1)">
              <span class="whiteText"> Home </span>
            </v-btn>

            <v-btn value="katalog" @click="pindahPage(2)">
              <span class="whiteText"> Katalog </span>
            </v-btn>

            <v-btn value="profil" @click="pindahPage(3)">
              <span class="whiteText"> Profil </span>
            </v-btn>

            <v-btn value="geo" @click="pindahPage(5)">
              <span class="whiteText"> Find Us </span>
            </v-btn>
          </v-btn-toggle>
        </v-flex>
        <v-btn router-link to="/login">Login/Register</v-btn>
      </v-app-bar>

      <v-card>
        <v-img
          src="https://wallpapercave.com/wp/IlpLRYK.jpg"
          gradient="to top right, rgba(0, 0, 0, 0.70), rgba(0, 0, 0, 0.70)"
        >
        </v-img>

        <v-container fluid fill-height class="posisinya">
          <v-layout flex align-center justify-center>
            <v-card color="white" outlined>
              <v-card-title>Find Us</v-card-title>
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d988.2720997795809!2d110.41464273254333!3d-7.780451600446361!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59f1d2361f71%3A0x4a2ce83adbcfd5aa!2sPerpustakaan%20Universitas%20Atma%20Jaya%20Yogyakarta!5e0!3m2!1sid!2sid!4v1606842050184!5m2!1sid!2sid"
                width="780"
                height="520"
                frameborder="0"
                style="border: 0"
                allowfullscreen=""
                aria-hidden="false"
                tabindex="0"
              ></iframe>
              <v-card-text class="pt-4"> </v-card-text>
            </v-card>
            <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
              {{ error_message }}
            </v-snackbar>
          </v-layout>
        </v-container>
      </v-card>
    </div>
  </main>
</template>

<style>
@import url("https://fonts.googleapis.com/css?family=Jolly%20Lodger");

.whiteText {
  color: whitesmoke;
}

.grey--text {
  font-family: "Jolly Lodger";
}

.posisinya {
  position: absolute;
  top: 0px;
  left: 0px;
  right: 0px;
}

.sizeCardView {
  height: auto;
}
</style>

<script>
export default {
  name: "Login",
  data() {
    return {
      navbarBtn: "geo",
      sticky: false,
      login: "",
      user: [],
    };
  },
  methods: {
    accLogout() {
      localStorage.removeItem("token");
      localStorage.removeItem("id");
      console.log(localStorage.getItem("token"));
      delete this.$http.defaults.headers.common["Authorization"];
      console.log(this.$http.defaults.headers.common["Authorization"]);
      this.$router.push({
        path: "/login",
      });
    },
    pindahPage(nomor) {
      if (nomor == 1) {
        this.$router.push({
          name: "index",
        });
      } else if (nomor == 2) {
        this.$router.push({
          name: "katalog",
        });
      } else if (nomor == 3) {
        this.$router.push({
          name: "profil",
        });
      } else if (nomor == 4) {
        this.$router.push({
          name: "geoloc",
        });
      } else {
        this.$router.push({
          name: "login",
        });
      }
    },
  },
  mounted() {
    this.$http
      .get(this.$api + "/user", {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
      .then((response) => {
        this.login = true;
        this.user = response;
      });
  },
};
</script>


