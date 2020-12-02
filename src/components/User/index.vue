<template>
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
      <v-btn-toggle
        v-model="navbarBtn"
        tile
        color="white accent-3"
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
        <v-btn value="profil" @click="pindahPage(5)">
          <span class="whiteText">
            Find Us
          </span>
        </v-btn>
      </v-btn-toggle>
      <V-Spacer />
      <v-btn v-if="!login" rounded @click="pindahPage(4)">Login/Register</v-btn>
       <v-btn v-else rounded color="error" @click="accLogout()">Logout</v-btn>
    </v-app-bar>

    <v-card>
      <v-img
        src="https://wallpapercave.com/wp/IlpLRYK.jpg"
        gradient="to top right, rgba(0, 0, 0, 0.70), rgba(0, 0, 0, 0.70)"
      >
        <v-card
          class="mx-auto"
          max-width="auto"
          style="margin-top: 10%; background: rgba(0, 0, 0, 0)"
        >
          <v-toolbar dense width="40%" style="margin-start: 32%">
            <v-text-field
              hide-details
              label="Cari Buku"
              single-line
            ></v-text-field>

            <v-btn icon>
              <v-icon>mdi-magnify</v-icon>
            </v-btn>
          </v-toolbar>

          <v-card-text
            style="
              margin-top: 10%;
              background: rgba(0, 0, 0, 0);
              color: white;
              font-size: 30px;
              text-align: center;
              font-family: Redressed;
              font-style: normal;
              font-weight: normal;
            "
            >"I have always imagined that Paradise will be a kind of a
            Library."</v-card-text
          >

          <v-card-text
            style="
              background: rgba(0, 0, 0, 0);
              color: white;
              font-size: 20px;
              text-align: center;
            "
            >Jorge Luis Borges</v-card-text
          >
          <v-card-text
            style="
              background: rgba(0, 0, 0, 0);
              color: white;
              font-size: 15px;
              text-align: center;
            "
            >(1899-1986. Argentine writer)</v-card-text
          >
        </v-card>
      </v-img>
    </v-card>
  </div>
</template>

<style>
.whiteText {
  color: whitesmoke;
}
</style>


<script>
export default {
  name: "index",
  data() {
    return {
      navbarBtn: "home",
      sticky: false,
      login:false,
      user:[]
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
      } else if (nomor == 3) {
        this.$router.push({
          name: "profil",
        });
      }else if(nomor == 5){
        this.$router.push({
          name:'geo'
        })
      }
       else {
        this.$router.push({
          name: "login",
        });
      }
    },
    accLogout(){
      localStorage.removeItem("token");
      console.log(localStorage.getItem("token"));
      delete this.$http.defaults.headers.common["Authorization"];
      console.log(this.$http.defaults.headers.common["Authorization"]);
      this.$router.push({
        path: "/login",
       });
      }
  },
  mounted(){
    this.$http.get(this.$api + '/user',
        {headers: {
                    "Authorization" : `Bearer ${localStorage.getItem("token")}`
                }})
          .then(response=>{
           this.login = true;
           this.user=response
          })
  }
};
</script>
