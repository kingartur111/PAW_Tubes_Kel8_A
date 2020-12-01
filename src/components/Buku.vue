<template>
  <v-main class="list">
    <div class="d-flex justify-end mb-6">
      <v-btn color="brown" dark @click="dialog = true"> Tambah Buku</v-btn>
    </div>
    <!-- Data Table -->
    <v-card>
      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
      </v-card-title>
      <v-data-table :headers="headers" :items="books" :search="search">
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn small class="mr-2" @click="detailHandler(item)">
            Detail
          </v-btn>
          <v-btn small class="mr-2" @click="editHandler(item)"> edit </v-btn>
          <v-btn small @click="deleteHandler(item)"> delete </v-btn>
        </template>
      </v-data-table>
    </v-card>

    <!-- Dialog  Detail-->
    <v-dialog v-model="dialogDetail" persistent max-width="700px">
      <v-card>
        <v-card-title>
          <span class="headline">Detail Buku</span>
          <v-spacer></v-spacer>
          <v-icon class="mx-6 my-3" @click="close">mdi-close</v-icon>
        </v-card-title>
        <div class="d-flex pb-3">
          <v-img
            max-height="250"
            max-width="150"
            class="mx-6"
            :src="'http://127.0.0.1:8000/' + books.image"
          ></v-img>
          <v-card-text class="my-2 pt-0">
            <div>
              <tr>
                <td>ISBN</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.ISBN }}</td>
              </tr>
              <tr>
                <td>Judul</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.Judul }}</td>
              </tr>
              <tr>
                <td>Pengarang</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.pengarang }}</td>
              </tr>
              <tr>
                <td>Penerbit</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.penerbit }}</td>
              </tr>
              <tr>
                <td>Kategori</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.kategori }}</td>
              </tr>
              <tr>
                <td>Bahasa</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.bahasa }}</td>
              </tr>
              <tr>
                <td>Tahun</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.tahun }}</td>
              </tr>
              <tr>
                <td>Created</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.created_at }}</td>
              </tr>
              <tr>
                <td>Updated</td>
                <td class="px-3 pb-1">:</td>
                <td>{{ form.updated_at }}</td>
              </tr>
            </div>
          </v-card-text>
        </div>
      </v-card>
    </v-dialog>

    <!-- Dialog Tambah & Edit -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title class="d-flex justify-space-between">
          <span class="headline">{{ formTitle }} Buku</span>
          <v-icon @click="close">mdi-close</v-icon>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text-field v-model="form.ISBN" label="ISBN" required>
            </v-text-field>
            <v-text-field v-model="form.Judul" label="Judul" required>
            </v-text-field>
            <v-text-field v-model="form.pengarang" label="Pengarang" required>
            </v-text-field>
            <v-text-field v-model="form.penerbit" label="Penerbit" required>
            </v-text-field>
            <v-text-field v-model="form.kategori" label="Kategori" required>
            </v-text-field>
            <v-text-field v-model="form.bahasa" label="Bahasa" required>
            </v-text-field>
            <v-row>
              <v-col
                ><v-text-field v-model="form.tahun" label="Tahun" required>
                </v-text-field
              ></v-col>
              <v-col><input type="file" @change="imageChanged" /></v-col>
            </v-row>
          </v-container>
          <v-card-actions class="d-flex justify-end">
            <v-btn @click="setForm">Save</v-btn>
          </v-card-actions>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Dialoh Delete -->
    <v-dialog v-model="dialogConfirm" persistent max-width="400px">
      <v-card>
        <v-card-title>
          <span class="headline">warning!</span>
        </v-card-title>
        <v-card-text> Anda yakin ingin menghapus produk ini? </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialogConfirm = false">
            Cancel
          </v-btn>
          <v-btn color="blue darken-1" text @click="deleteData"> Delete </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
      {{ error_message }}
    </v-snackbar>
  </v-main>
</template>


<script>
export default {
  name: "List",
  data() {
    return {
      inputType: "Tambah",
      load: false,
      snackbar: false,
      error_message: "",
      color: "",
      search: null,
      dialog: false,
      dialogConfirm: false,
      dialogDetail: false,
      headers: [
        {
          text: "ISBN",
          align: "start",
          sortable: true,
          value: "ISBN",
        },
        { text: "Judul Buku", value: "Judul" },
        { text: "Pengarang", value: "pengarang" },
        { text: "Actions", value: "actions" },
      ],
      book: new FormData(),
      books: [],
      form: {
        ISBN: null,
        Judul: null,
        pengarang: null,
        penerbit: null,
        kategori: null,
        tahun: null,
        bahasa: null,
        image: null,
        created_at: null,
        updated_at: null,
      },
      deleteId: "",
      editId: "",
      image: "",
    };
  },
  methods: {
    setForm() {
      if (this.inputType === "Tambah") {
        this.save();
      } else {
        this.update();
      }
    },
    //read data book
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
    //simpan data produk
    imageChanged(e) {
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);

      fileReader.onload = (e) => {
        this.image = e.target.result;
      };
    },

    save() {
      this.book.append("ISBN", this.form.ISBN);
      this.book.append("Judul", this.form.Judul);
      this.book.append("pengarang", this.form.pengarang);
      this.book.append("penerbit", this.form.penerbit);
      this.book.append("kategori", this.form.kategori);
      this.book.append("tahun", this.form.tahun);
      this.book.append("bahasa", this.form.bahasa);
      this.book.append("image", this.image);
      this.book.append("penerbit", this.form.penerbit);

      var url = this.$api + "/buku/";
      this.load = true;
      this.$http
        .post(url, this.book, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.error_message = response.data.message;
          this.color = "green";
          this.snackbar = true;
          this.load = false;
          this.close();
          this.readData(); //mengambil data
          this.resetForm();
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        });
    },
    //ubah data produk
    update() {
      let newData = {
        ISBN: this.form.ISBN,
        Judul: this.form.Judul,
        pengarang: this.form.pengarang,
        penerbit: this.form.penerbit,
        kategori: this.form.kategori,
        tahun: this.form.tahun,
        bahasa: this.form.bahasa,
        image: this.image,
      };
      var url = this.$api + "/buku/" + this.editId;
      this.load = true;
      this.$http
        .put(url, newData, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.error_message = response.data.message;
          this.color = "green";
          this.snackbar = true;
          this.load = false;
          this.close();
          this.readData(); //mengambil data
          this.resetForm();
          this.inputType = "Tambah";
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        });
    },
    //hapus data produk
    deleteData() {
      //mengahapus data
      var url = this.$api + "/buku/" + this.deleteId;
      //data dihapus berdasarkan id
      this.$http
        .delete(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.error_message = response.data.message;
          this.color = "green";
          this.dialogConfirm = false;
          this.snackbar = true;
          this.load = false;
          this.close();
          this.readData(); //mengambil data
          this.resetForm();
          this.inputType = "Tambah";
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        });
    },
    getBukuByID(id) {
      var url = this.$api + "/buku/" + id;
      this.$http
        .get(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.books = response.data.data;
          console.log(response.data);
          console.log(this.books.image);
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          console.log(error.response);
        });
    },
    detailHandler(item) {
      this.getBukuByID(item.id);
      this.form.ISBN = item.ISBN;
      this.form.Judul = item.Judul;
      this.form.pengarang = item.pengarang;
      this.form.penerbit = item.penerbit;
      this.form.kategori = item.kategori;
      this.form.tahun = item.tahun;
      this.form.image = item.image;
      this.form.bahasa = item.bahasa;
      this.form.created_at = item.created_at;
      this.form.updated_at = item.updated_at;
      this.dialogDetail = true;
    },

    editHandler(item) {
      this.inputType = "Ubah";
      this.editId = item.id;
      this.form.ISBN = item.ISBN;
      this.form.Judul = item.Judul;
      this.form.pengarang = item.pengarang;
      this.form.penerbit = item.penerbit;
      this.form.kategori = item.kategori;
      this.form.tahun = item.tahun;
      this.form.image = item.image;
      this.form.bahasa = item.bahasa;
      this.form.created_at = item.created_at;
      this.form.updated_at = item.updated_at;
      this.dialog = true;
    },
    deleteHandler(item) {
      this.deleteId = item.id;
      this.dialogConfirm = true;
    },
    close() {
      this.resetForm();
      this.dialog = false;
      this.dialogDetail = false;
      this.inputType = "Tambah";
    },
    cancel() {
      this.resetForm();
      this.readData();
      this.dialog = false;
      this.inputType = "Tambah";
    },
    resetForm() {
      this.form = {
        ISBN: null,
        Judul: null,
        pengarang: null,
        penerbit: null,
        tahun: null,
        bahasa: null,
        kategori: null,
      };
    },
  },
  computed: {
    formTitle() {
      return this.inputType;
    },
  },
  mounted() {
    this.readData();
  },
};
</script>