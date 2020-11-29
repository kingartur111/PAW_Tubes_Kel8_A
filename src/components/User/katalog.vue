<template>
  <div> 

    <v-app-bar app absolute height="75px" style="background: rgba(61, 30, 26, 0.8);">
      

    <v-avatar
      color="primary"
      size="40"
      tile
    ></v-avatar>
      <h3 style="color:white;">   Perpustakaan Tadika Mesra</h3>
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

      <v-btn rounded @click="pindahPage(4)">Login/Register</v-btn>

    </v-app-bar>

  <v-card>
      <v-img 
        src="https://wallpapercave.com/wp/IlpLRYK.jpg"
        gradient="to top right, rgba(0, 0, 0, 0.70), rgba(0, 0, 0, 0.70)">
        <v-card
          class="mx-auto"
          max-width="auto"
         
          style="margin-top: 10%;background: rgba(0, 0, 0, 0);"
          
        >
            <v-toolbar
              dense
              width="50%"
              style="margin-start: 26%;"
              
            >
              <v-text-field
                hide-details
                label="Cari Buku"
                single-line
              ></v-text-field>

              <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
              </v-btn>

              <v-select
                :items="items"
                hide-details
                label="Filled style"
                style="width:0.5%;"
                single-line
                ></v-select>

            </v-toolbar>

            
        </v-card>

      </v-img>
</v-card>


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
      navbarBtn: 'katalog',
      items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
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
      }
    }
  }
</script>
