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
        <v-btn rounded><router-link to="index">Home</router-link></v-btn>
        <v-btn rounded>Katalog</v-btn>
        <v-btn rounded>Profil</v-btn>
      <V-Spacer />

          <v-btn rounded>Logout</v-btn>
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
        <v-card flat>
          <v-card-text v-text="text"></v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>

</div>


</template>

<script>
  export default {
    data: () => ({
      sticky: false,
       tab: null,
        items: [
          'User Detail', 'Edit Profile', 'Ubah Password'
        ],
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    }),
  }
</script>
