<template>
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
        <v-container class="d-flex justify-center">
          <div style="background: rgba(61, 30, 26, 0.4)">
            <v-row align="center">
              <v-col align-self="end" class="pa-0" cols="12"> </v-col>
              <v-col class="p-0">
                <v-list-item color="rgba(0, 0, 0, .4)" dark>
                  <v-list-item-content>
                    <v-list-item-title class="title"> </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-col>
            </v-row>
            <v-card width="800px" class="mt-12">
              <v-tabs class="pa-4" v-model="tab" align-with-title>
                <v-tabs-slider color="brown"></v-tabs-slider>

                <v-tab v-for="item in items" :key="item">
                  {{ item }}
                </v-tab>
                <v-tabs-items v-model="tab">
                  <v-tab-item v-for="item in items" :key="item">
                    <div v-if="tab == 0" class="ma-3">
                      <v-row class="pl-4">
                        <v-avatar
                          class="profile"
                          color="grey"
                          size="170"
                          tile
                          rounded
                        >
                          <v-img
                            v-bind:src="'http://127.0.0.1:8000/' + user.image"
                          ></v-img>
                        </v-avatar>
                        <v-col>
                          <v-row v-for="i in 4" :key="i">
                            <v-col v-for="k in 2" :key="k">
                              <span v-if="k == 1">
                                {{ profile[i] }}
                              </span>
                              <span v-else>
                                {{ show[i] }}
                              </span>
                            </v-col>
                          </v-row>
                        </v-col> </v-row
                      ><v-row class="pa-3 pb-4">
                        <input id="file" type="file" @change="getImg($event)" />
                        <v-spacer></v-spacer>
                        <v-btn color="brown" @click="updateProfil"
                          >Update Profile</v-btn
                        >
                      </v-row>
                    </div>
                    <v-card v-if="tab == 1" flat>
                      <v-text-field
                        v-model="user.name"
                        :value="user.name"
                        label="Nama"
                        filled
                        shaped
                      ></v-text-field>

                      <div class="text-center">
                        <v-btn rounded color="brown" dark @click="update">
                          Ubah Profil
                        </v-btn>
                      </div>
                    </v-card>

                    <v-card v-if="tab == 2" flat>
                      <v-container class="grey lighten-5">
                        <v-text-field
                          v-model="passwordOld"
                          label="Password Lama"
                          type="password"
                          filled
                          shaped
                        ></v-text-field>

                        <v-text-field
                          v-model="passwordNew"
                          label="Password Baru"
                          type="password"
                          filled
                          shaped
                        ></v-text-field>
                        <v-text-field
                          v-model="confirmPass"
                          label="Konfirmasi Password"
                          type="password"
                          filled
                          shaped
                        ></v-text-field>

                        <div class="text-center">
                          <v-btn rounded color="brown" dark @click="update">
                            Ubah Password
                          </v-btn>
                        </div>
                      </v-container>
                    </v-card>
                  </v-tab-item>
                </v-tabs-items>
              </v-tabs>
            </v-card>
          </div>
        </v-container>
      </v-img>
    </v-card>
    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
      {{ error_message }}
    </v-snackbar>
  </div>
</template>

<style>
.whiteText {
  color: whitesmoke;
}
</style>

<script>
export default {
  data: () => ({
    sticky: false,
    tab: 0,
    navbarBtn: "profil",
    passwordOld: "",
    passwordNew: "",
    confirmPass: "",
    snackbar: false,
    error_message: "",
    color: "",
    name: "",
    image: null,
    items: ["User Detail", "Edit Profile", "Ubah Password"],
    profile: ["", "ID Anggota", "Nama", "Email"],
    text:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
    user: [],
    show: [],
  }),

  methods: {
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
      } else if (nomor == 5) {
        this.$router.push({
          name: "geo",
        });
      } else {
        this.$router.push({
          name: "login",
        });
      }
    },
    update() {
      if (this.tab == 1) {
        this.$http
          .put(
            this.$api + "/user/" + this.user.id,
            {
              name: this.user.name,
            },
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`,
              },
            }
          )
          .then((response) => {
            this.error_message = response.message;
            this.color = "green";
            this.snackbar = true;
            this.user = response.data.data;
            window.location.reload();
          })
          .catch((error) => {
            this.error_message = error.message;
            this.color = "red";
            this.snackbar = true;
          });
      } else if (this.tab == 2) {
        if (this.confirmPass == this.passwordNew) {
          this.$http
            .put(
              this.$api + "/user/" + this.user.id,
              {
                passwordOld: this.passwordOld,
                password: this.passwordNew,
              },
              {
                headers: {
                  Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
              }
            )
            .then((response) => {
              this.error_message = response.data.message;
              this.color = "green";
              this.snackbar = true;
              this.user = response.data.data;
              window.location.reload();
            })
            .catch((error) => {
              this.error_message = error.message;
              this.color = "red";
              this.snackbar = true;
            });
        } else {
          this.error_message = "password Tidak sama";
          this.color = "red";
          this.snackbar = true;
        }
      }
    },
    getImg(event) {
      // const image = event.target.files[0];
      // this.imgURL = image;
      // this.data.append('image', this.imgURL);
      // FB.api('/' + id + '/picture?redirect=false&height=120&width=120',
      // 'GET', {}, response => {
      // console.log(this.getDataUri(response.data.url));

      var reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = (e) => {
        console.log(reader.result);
        this.image = e.target.result;
      };
    },
    updateProfil() {
      var url = this.$api + "/user/" + localStorage.getItem("id");
      this.$http
        .put(
          url,
          {
            image: this.image,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((response) => {
          this.error_message = response.data.message;
          this.img = response.data.data.image;
          this.color = "green";
          this.snackbar = true;
          this.user = response.data;
          window.location.reload();
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
        });
    },
    cekUser() {
      this.$http
        .get(this.$api + "/user", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((response) => {
          this.user = response.data;
          this.show = ["", this.user.id, this.user.name, this.user.email];
        })
        .catch((error) => {
          this.error_message = error.message;
          this.color = "red";
          this.snackbar = true;
          this.$router.push({
            name: "login",
          });
        });
    },

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
  },
  mounted() {
    this.cekUser();
  },
};
</script>
