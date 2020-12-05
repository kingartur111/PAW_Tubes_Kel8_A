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
        <v-btn rounded>Login/Register</v-btn>
      </v-app-bar>

      <v-card>
        <v-img
          src="https://wallpapercave.com/wp/IlpLRYK.jpg"
          gradient="to top right, rgba(0, 0, 0, 0.70), rgba(0, 0, 0, 0.70)"
        >
        </v-img>

        <v-container fluid fill-height class="posisinya d-flex justify-center">
          <v-card class="elevation-12" width="400px">
            <v-stepper v-model="e1">
              <v-stepper-items>
                <v-stepper-content step="1">
                  <v-row>
                    <v-col class="ma-6">
                      <v-card-text>
                        <div class="d-flex justify-center">
                          <v-icon size="100px" color="brown"
                            >mdi-account-circle</v-icon
                          >
                        </div>
                        <h1 class="text-center display-3 brown--text">Login</h1>
                        <div class="text-center" mt-4></div>
                        <v-form ref="formlogin">
                          <v-text-field
                            label="E-mail"
                            v-model="email"
                            :rules="emailRules"
                            required
                          />
                          <v-text-field
                            label="Password"
                            v-model="password"
                            type="password"
                            min="8"
                            :rules="passwordRules"
                            counter
                            required
                          />
                        </v-form>
                        <a color="primary" @click="e1 = 2"> Register </a>
                      </v-card-text>
                      <div class="text-center mt-3">
                        <v-btn
                          rounded
                          color="brown accent-3"
                          @click="submit"
                          dark
                          >Login</v-btn
                        >
                      </div>
                    </v-col>
                  </v-row>
                </v-stepper-content>

                <v-stepper-content step="2">
                  <v-row>
                    <v-col class="ma-6">
                      <v-card-text>
                        <div class="d-flex justify-center">
                          <v-icon size="100px" color="brown"
                            >mdi-account-circle</v-icon
                          >
                        </div>
                        <h1 class="text-center display-3 brown--text">
                          Register
                        </h1>
                        <div class="text-center" mt-4></div>
                        <v-form ref="formReg">
                          <v-text-field
                            label="Nama Lengkap"
                            v-model="regisData.nama"
                            :rules="namaRules"
                            required
                          />
                          <v-text-field
                            label="E-mail"
                            v-model="regisData.email"
                            :rules="emailRules"
                            type="email"
                            required
                          />
                          <v-text-field
                            label="Password"
                            v-model="regisData.pass"
                            type="password"
                            min="8"
                            :rules="passwordRules"
                            counter
                            required
                          />
                          <v-text-field
                            label="Confirm Password"
                            v-model="regisData.conPass"
                            type="password"
                            min="8"
                            :rules="passwordRules"
                            required
                          />
                        </v-form>
                        <a color="primary" @click="e1 = 1"> Login </a>
                      </v-card-text>
                      <div class="text-center mt-3">
                        <v-btn
                          rounded
                          color="brown accent-3"
                          dark
                          @click="submitReg"
                          >Register</v-btn
                        >
                      </div>
                    </v-col>
                  </v-row>
                </v-stepper-content>
              </v-stepper-items>
            </v-stepper>
          </v-card>
          <v-snackbar v-model="snackbar" :color="color" timeout="20000" bottom>
            {{ error_message }}
          </v-snackbar>
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
      load: false,
      snackbar: false,
      e1: 1,
      error_message: "",
      toogleLogin: true,
      color: "",
      valid: false,
      password: "",
      email: "",
      namaRules: [(v) => !!v || "Nama tidak boleh kosong "],
      passwordRules: [(v) => !!v || "Password tidak boleh kosong "],
      emailRules: [(v) => !!v || "E-mail tidak boleh kosong"],
      regisData: {
        nama: "",
        email: "",
        pass: "",

        conPass: "",
      },
    };
  },
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
      } else if (nomor == 3 && localStorage.getItem("id")) {
        this.$router.push({
          name: "profil",
        });
      } else if (nomor == 4) {
        this.$router.push({
          name: "geo",
        });
      } else {
        this.$router.push({
          name: "login",
        });
      }
    },
    submit() {
      if (this.$refs.formlogin.validate()) {
        //cek apakah data yang akan dikirim sudah valid;
        this.load = true;
        this.$http
          .post(this.$api + "/login", {
            email: this.email,
            password: this.password,
          })
          .then((response) => {
            localStorage.setItem("id", response.data.user.id); //menyimpan id user yang sedang login
            localStorage.setItem("token", response.data.access_token);
            //menyimpan auth token
            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = false;
            this.clear();
            if (response.data.user.status == "admin") {
              this.$router.replace({
                path: "/dashboard",
              });
            } else {
              this.$router.replace({
                path: "/index",
              });
            }

            console.log("test");
          })
          .catch((error) => {
            this.error_message = error.response;
            this.color = "red";
            this.snackbar = true;
            localStorage.removeItem("token");
            this.load = false;
            console.log(error.response);
          });
      }
    },
    submitReg() {
      if (this.$refs.formReg.validate()) {
        if (this.regisData.pass == this.regisData.conPass) {
          this.load = true;
          this.$http
            .post(this.$api + "/register", {
              name: this.regisData.nama,
              email: this.regisData.email,
              password: this.regisData.pass,
            })
            .then((response) => {
              this.error_message = response.data.message;
              this.color = "green";
              this.snackbar = true;
              this.load = false;
              this.toogleLogin = true;
              console.log(this.email);
              console.log("test");
            })
            .catch((error) => {
              this.error_message = error.response;
              this.color = "red";
              this.snackbar = true;
              this.load = false;

              console.log(error.response.message);
            });
        } else {
          this.error_message = "Password Tidak Sama";
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        }
      }
    },
    clear() {
      this.$refs.formlogin.reset(); //Clear form login
    },
    clearRegForm() {
      this.regisData.nama = "";
      this.regisData.email = "";
      this.regisData.pass = "";
      this.regisData.conPass = "";
    },
  },
};
</script>


