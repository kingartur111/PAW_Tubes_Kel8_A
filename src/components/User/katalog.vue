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
         flat
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
      <v-card v-for="data in books"
      :key="data"
      class="mx-auto"
      max-width="auto"
      flat
     style="margin-top: 10px;background: rgba(0, 0, 0, 0);"
      >
       <v-card
          width="50%"
          style="margin-start: 26%;"              
        >
              <v-layout row>
                <v-flex xs7>
                  <v-card-title primary-title>
                    <div>
                      <div class="headline">{{data.Judul}}</div>
                      <div>{{data.pengarang}}</div>
                      <div>{{data.tahun}}</div>
                    </div>
                  </v-card-title>
                </v-flex>
                <v-flex xs5>
                  <v-img
                    v-bind:src="'http://127.0.0.1:8000/' +data.image"
                    style="width:100px;height:100px;"
                    
                  ></v-img>
                </v-flex>
              </v-layout>
              <v-divider light></v-divider>
              <v-card-actions class="pa-3">
                Penerbit: {{data.penerbit}}
                <v-spacer></v-spacer>
                <v-btn color="brown" @click="pinjamBuku(data.id)">Pinjam</v-btn>
              </v-card-actions>
       </v-card>
      </v-card>
      </v-img>
</v-card>

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
      navbarBtn: 'katalog',
      items: ['Anak', 'Fantasi', 'Pendidikan', 'Novel'],
      books:[],
      pinjam:[],
      snackbar:false,
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
      readData() {
      var url = this.$api + "/buku";
      this.$http
        .get(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.books = response.data.data;
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
        });
    },
    pinjamBuku(id){
      
      

      this.$http.get(this.$api + '/buku/'+ id,{
         headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
      })
      .then((response) => {
          this.pinjam = response.data.data;
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
        });

        var currentDateWithFormat = new Date().toJSON().slice(0,10).replace(/-/g,'-');

            

        this.$http.post(this.$api+'/requestBuku',{
          'Judul': this.pinjam.Judul,
          'ISBN': this.pinjam.ISBN,
          'peminjam': localStorage.getItem("id"),
          'tgl_pinjam': currentDateWithFormat,

        },{
           headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        }).then((response) => {
          this.pinjam = response.data.data;
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
        });
    },
    
    },
    mounted(){
      this.readData()
    }
  }
</script>
