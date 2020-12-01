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
        <v-avatar color="primary" size="40" tile></v-avatar>
        <h3 style="color: white">Perpustakaan Tadika Mesra</h3>
        <V-Spacer />
        <v-btn-toggle tile color="white accent-3" rounded group>
          <v-btn value="home">
            <span class="whiteText"> Home </span>
          </v-btn>

          <v-btn value="katalog">
            <span class="whiteText"> Katalog </span>
          </v-btn>

          <v-btn value="profil">
            <span class="whiteText"> Profil </span>
          </v-btn>
        </v-btn-toggle>
        <V-Spacer />

        <v-btn rounded>Login/Register</v-btn>
      </v-app-bar>

      <v-card>
        <v-img
          src="https://wallpapercave.com/wp/IlpLRYK.jpg"
          gradient="to top right, rgba(0, 0, 0, 0.70), rgba(0, 0, 0, 0.70)"
        >
        </v-img>

        <v-container fluid fill-height class="posisinya">
          <v-layout flex align-center justify-center>
            <v-flex xs12 sm6 elevation-6>
              <v-card color="white" outlined>
                <v-row>
                  <v-col>
                    <v-card-title v-if="toogleLogin">Login Page</v-card-title>
                    <v-card-text v-if="toogleLogin" class="sizeCardView">
                      <div>
                        <v-form v-model="valid" ref="formlogin">
                          <v-text-field
                            label="E-mail"
                            v-model="email"
                            :rules="emailRules"
                            required
                          ></v-text-field>
                          <v-text-field
                            label="Password"
                            v-model="password"
                            type="password"
                            min="8"
                            :rules="passwordRules"
                            counter
                            required
                          ></v-text-field>
                          <v-card-subtitle
                            >Belum Punya Akun?
                            <button
                              @click="toogleLogin = false"
                              style="color: blue"
                            >
                              Register
                            </button></v-card-subtitle
                          >
                          <v-layout justify-end>
                            <v-btn
                              color="brown"
                              class="mr-2"
                              @click="submit"
                              :class="{
                                'brown darken-1 white--text': valid,
                                disabled: !valid,
                              }"
                              >Login
                            </v-btn>
                          </v-layout>
                        </v-form>
                      </div>
                    </v-card-text>
                  </v-col>

                  <v-col>
                    <v-card-title v-if="!toogleLogin"
                      >Register Page</v-card-title
                    >
                    <v-card-text v-if="!toogleLogin">
                      <div>
                        <v-form v-model="valid" ref="formReg">
                          <v-text-field
                            label="Nama Lengkap"
                            v-model="regisData.nama"
                            :rules="namaRules"
                            required
                          ></v-text-field>
                          <v-text-field
                            label="E-mail"
                            v-model="regisData.email"
                            :rules="emailRules"
                            type="email"
                            required
                          ></v-text-field>
                          <v-text-field
                            label="Password"
                            v-model="regisData.pass"
                            type="password"
                            min="8"
                            :rules="passwordRules"
                            counter
                            required
                          ></v-text-field>

                          <v-text-field
                            label="Confirm Password"
                            v-model="regisData.conPass"
                            type="password"
                            min="8"
                            :rules="passwordRules"
                            required
                          ></v-text-field>
                          <v-card-subtitle
                            >Sudah Punya Akun?
                            <button
                              @click="toogleLogin = true"
                              style="color: blue"
                            >
                              Login
                            </button></v-card-subtitle
                          >
                          <v-layout justify-end>
                            <v-btn
                              color="brown"
                              class="mr-2"
                              @click="submitReg"
                              :class="{
                                'brown darken-1 white--text': valid,
                                disabled: !valid,
                              }"
                              >Register
                            </v-btn>
                          </v-layout>
                        </v-form>
                      </div>
                    </v-card-text>
                  </v-col>
                </v-row>

                <v-card-text class="pt-4"> </v-card-text>
              </v-card>
              <v-snackbar
                v-model="snackbar"
                :color="color"
                timeout="2000"
                bottom
              >
                {{ error_message }}
              </v-snackbar>
            </v-flex>
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
      load: false,
      snackbar: false,
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
            if(response.data.user.status == "admin"){
              this.$router.push({
              path: "/dashboard",
            });
            }else{
              this.$router.push({
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

              console.log(error.response);
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


