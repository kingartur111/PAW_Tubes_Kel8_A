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
        <v-card
          class="mx-auto"
          max-width="auto"
          flat
          style="margin-top: 10%; background: rgba(0, 0, 0, 0)"
        >
          <v-toolbar dense width="50%" style="margin-start: 26%">
            <v-text-field
              hide-details
              label="Cari Buku"
              single-line
              v-model="search"
            ></v-text-field>

            <v-btn icon>
              <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <v-select
              :items="items"
              v-model="filter"
              hide-details
              label="Filled style"
              style="width: 0.5%"
              single-line
            ></v-select>
          </v-toolbar>
          <v-data-table
            :headers="headers"
            :items="tableItems"
            :search="search"
            dense
            width="50%"
            style="margin-start: 26%; margin-end: 24%"
          >
            <template v-slot:[`item.actions`]="{ item }">
              <v-btn
                small
                color="brown"
                class="mr-2"
                @click="pinjamBuku(item.id)"
              >
                Pinjam
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-img>
    </v-card>

    <v-snackbar v-model="snackbar" :color="color" timeout="20000" bottom>
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
    navbarBtn: "katalog",
    items: ["Anak", "Fantasi", "Pendidikan", "Novel"],
    books: [],
    pinjam: [],
    tgl_pinjam: "",
    peminjam: "",
    snackbar: false,
    error_message: "",
    search: "",
    color: "",
    login: false,
    user: [],
    filter: "",
    headers: [
      {
        text: "ISBN",
        align: "start",
        sortable: true,
        value: "ISBN",
      },
      { text: "Judul Buku", value: "Judul" },
      { text: "Pengarang", value: "pengarang" },
      { text: "Kategori", value: "kategori" },
      { text: "Tahun Terbit", value: "tahun" },
      { text: "Actions", value: "actions" },
    ],
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
          console.log(this.books);
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
        });
    },
    pinjamBuku(id) {
      this.$http
        .get(this.$api + "/buku/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.error_message = response.data.message;
          this.color = "green";
          this.snackbar = true;
          this.pinjam = response.data.data;
        });

      var currentDateWithFormat = new Date()
        .toJSON()
        .slice(0, 10)
        .replace(/-/g, "-");

      this.$http
        .post(
          this.$api + "/requestBuku",
          {
            Judul: this.pinjam.Judul,
            ISBN: this.pinjam.ISBN,
            peminjam: localStorage.getItem("id"),
            tgl_pinjam: currentDateWithFormat,
          },
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        )
        .then((response) => {
          this.pinjam = response.data.data;
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          this.load = false;
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
  computed: {
    filteredItems() {
      return this.books.filter((i) => {
        return !this.filter || i.kategori === this.filter;
      });
    },
    tableItems() {
      if (!this.filter) {
        return this.books;
      }

      return this.books.filter(
        (item) => item.kategori.indexOf(this.filter) > -1
      );
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
    this.readData();
  },
};
</script>
