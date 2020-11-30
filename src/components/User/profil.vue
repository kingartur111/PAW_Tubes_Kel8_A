<template>
  <div> 

    <v-app-bar  height="75px" style="background: rgba(61, 30, 26, 0.9);">
    
    <v-avatar
      color="primary"
      size="40"
      tile
    ></v-avatar>
      <h3 style="color:white;">Perpustakaan Tadika Mesra</h3>
      <V-Spacer />
         <v-btn-toggle
        v-model="navbarBtn"
        tile
        color="white accent-3"
        rounded
        group

      >
       <v-btn value="home" @click="pindahPage(1)">
          <span class="whiteText">
            Home
          </span>
        </v-btn>


        <v-btn value="katalog" @click="pindahPage(2)">
          <span class="whiteText">
            Katalog
          </span>
        </v-btn>
    
        <v-btn value="profil" @click="pindahPage(3)">
          <span class="whiteText">
            Profil
          </span>
        </v-btn>

      </v-btn-toggle>
      <V-Spacer />

          <v-btn rounded color="error">Logout</v-btn>
    </v-app-bar>

  <v-card>
    <v-card
    class="mx-auto"
    max-width="auto"
    height="300px"
    tile
  >
    <div
      height="100%"
      style="background: rgba(61, 30, 26, 0.4);"
    >
      <v-row
        align="center"
        class="fill-height"
        
      >
        <v-col
          align-self="end"
          class="pa-0"
          cols="12"
          
        >
          <v-avatar
            class="profile"
            color="grey"
            size="250"
            tile
            rounded
            style="margin-start:46%;margin-top:20px;"
          >
            <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
          </v-avatar>
        </v-col>
        <v-col class="py-0">
          <v-list-item
            color="rgba(0, 0, 0, .4)"
            dark
          >
            <v-list-item-content style="margin-start:46%;">
              <v-list-item-title class="title">
                Marcus Obrien
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-col>
      </v-row>
    </div>
  </v-card>
  </v-card>
  <template >
        <v-tabs
          v-model="tab"
          align-with-title
        >
          <v-tabs-slider color="yellow"></v-tabs-slider>

          <v-tab
            v-for="item in items"
            :key="item"
          >
            {{ item }}
          </v-tab>
        </v-tabs>
  </template>
  <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="item in items"
        :key="item"
      >
        <v-card v-if="tab==0" flat>
          <v-container class="grey lighten-5">
            <v-row
              v-for="data in profile"
              :key="data"
              
            >
              <v-col
                v-for="k in 2"
                :key="k"
              >
                  <span v-if="k==1">
                  {{data}}
                  </span>
                  <span v-else>
                    {{user.nama}}
                  </span>

              </v-col>
            </v-row>
          </v-container>
        </v-card>
        <v-card v-if="tab==1" flat>
           <v-container class="grey lighten-5">
             <v-text-field
              v-model="user.nama"
              label="Nama"
              filled
              shaped
          ></v-text-field>

          <div class="text-center">
            <v-btn
              rounded
              color="brown"
              dark
            >
              Ubah Profil
            </v-btn>
          </div>

           </v-container>
        </v-card>
        <v-card v-if="tab==2" flat>
          <v-container class="grey lighten-5">
             <v-text-field
              v-model="passwordOld"
              label="Password Lama"
              filled
              shaped
          ></v-text-field>

          <v-text-field
              v-model="passwordNew"
              label="Password Baru"
              filled
              shaped
          ></v-text-field>
          <v-text-field
              v-model="confirmPass"
              label="Konfirmasi Password"
              filled
              shaped
          ></v-text-field>

          <div class="text-center">
            <v-btn
              rounded
              color="brown"
              dark
            >
              Ubah Password
            </v-btn>
          </div>
          </v-container>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
            {{ error_message }}
          </v-snackbar>
</div>


</template>

<style>

.whiteText{
   color: whitesmoke;
}


</style>

<script>
  export default {
    data: () => ({
      sticky: false,
       tab: 0,
       navbarBtn: 'profil',
       passwordOld:'',
       passwordNew:'',
       confirmPass:'',
       snackbar: false,
       error_message:'',
       color:'',
        items: [
          'User Detail', 'Edit Profile', 'Ubah Password'
        ],
        profile: [
          'ID Anggota', 'Nama', 'Nomor Telepon', 'Email', 
        ],
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        user: {
          nama:'nama',
          email:'A@gmail.com',
          idMember:'',  
        },
    }),

    methods:{
      pindahPage(nomor){
        if(nomor==1){
            this.$router.push({
              name: 'index'
            })
        }else if(nomor==2)
        {
              this.$router.push({
              name: 'katalog'
            })
        }else if(nomor==3){
              this.$router.push({
              name: 'profil'
            })
        }else{
              this.$router.push({
              name: 'login'
            })
        }
      },
      cekUser(){
        this.$http.get(this.$api + '/user/' + localStorage.getItem("id"),
        {headers: {
                    "Authorization" : `Bearer ${localStorage.getItem("token")}`
                }})
          .then(response=>{
            this.error_message = response.message
            this.color="green"
            this.snackbar= true
           
            this.user = response.data.user;
          }).catch(error=>{
            this.error_message = error.message
            this.color="red"
            this.snackbar= true
      //       this.$router.push({
      //       name: 'login'
      // })
          })
      }

    },
    mounted(){
      this.cekUser()

      
    }
  }
</script>
