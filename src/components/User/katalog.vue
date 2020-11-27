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
        <v-btn rounded>Home</v-btn>
        <v-btn rounded>Katalog</v-btn>
        <v-btn rounded>Profil</v-btn>
      <V-Spacer />

          <v-btn rounded>Logout</v-btn>
          <v-btn rounded>Register</v-btn>

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

<script>
  export default {
    data: () => ({
      sticky: false,
      items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
    }),
  }
</script>
