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
          <v-btn small @click="deleteHandler(item.id)"> delete </v-btn>
        </template>
      </v-data-table>
    </v-card>

    <!-- Dialog  Detail-->
    <v-dialog v-model="dialogDetail" persistent max-width="700px">
      <v-card>
        <v-card-title>
          <span class="headline">Detail Buku</span>
        </v-card-title>
        <div class="d-flex">
          <v-img
            lazy-src="https://picsum.photos/id/11/10/6"
            max-height="250"
            max-width="150"
            class="ma-6"
            src="https://cdn.discordapp.com/attachments/699241908043513877/782531390180818964/canva-starry-night-illustration-book-cover-MACAg6OlqBM.png"
          ></v-img>
          <v-card-text class="my-2">
            <div>
              <tr>
                <td>ISBN</td>
                <td class="px-3">:</td>
                <td>{{ form.ISBN }}</td>
              </tr>
              <tr>
                <td>Judul</td>
                <td class="px-3">:</td>
                <td>{{ form.Judul }}</td>
              </tr>
              <tr>
                <td>Pengarang</td>
                <td class="px-3">:</td>
                <td>{{ form.pengarang }}</td>
              </tr>
              <tr>
                <td>Penerbit</td>
                <td class="px-3">:</td>
                <td>{{ form.penerbit }}</td>
              </tr>
              <tr>
                <td>Kategori</td>
                <td class="px-3">:</td>
                <td>{{ form.kategori }}</td>
              </tr>
              <tr>
                <td>Bahasa</td>
                <td class="px-3">:</td>
                <td>{{ form.bahasa }}</td>
              </tr>
              <tr>
                <td>Tahun</td>
                <td class="px-3">:</td>
                <td>{{ form.tahun }}</td>
              </tr>
              <tr>
                <td>Created</td>
                <td class="px-3">:</td>
                <td>{{ form.created_at }}</td>
              </tr>
              <tr>
                <td>Updated</td>
                <td class="px-3">:</td>
                <td>{{ form.updated_at }}</td>
              </tr>
            </div>
          </v-card-text>
        </div>
        <v-card-action>
          <v-btn class="ma-3" @click="close">Close</v-btn>
        </v-card-action>
      </v-card>
    </v-dialog>

    <!-- Dialog Tambah & Edit -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }} Buku</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text v-model="form.Judul"> </v-text>

            <v-text-field v-model="form.satuan" label="Satuan" required>
            </v-text-field>

            <v-text-field v-model="form.harga_jual" label="Harga Jual" required>
            </v-text-field>

            <v-text-field v-model="form.stok" label="Stok" required>
            </v-text-field>
          </v-container>
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
          console.log(response.data.data);
          console.log(this.books[0].Judul);
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          console.log(error.response);
        });
    },
    //simpan data produk
    save() {
      this.book.append("nama_produk", this.form.nama_produk);
      this.book.append("satuan", this.form.satuan);
      this.book.append("harga_jual", this.form.harga_jual);
      this.book.append("stok", this.form.stok);

      var url = this.$api + "/book/";
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
        nama_produk: this.form.nama_produk,
        satuan: this.form.satuan,
        harga_jual: this.form.harga_jual,
        stok: this.form.stok,
      };
      var url = this.$api + "/book/" + this.editId;
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
      var url = this.$api + "/book/" + this.deleteId;
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
    detailHandler(item) {
      this.dialogDetail = true;
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
    },

    editHandler(item) {
      this.inputType = "Ubah";
      this.editId = item.id;
      this.form.nama_produk = item.nama_produk;
      this.form.satuan = item.satuan;
      this.form.stok = item.stok;
      this.form.harga_jual = item.harga_jual;
      this.dialog = true;
    },
    deleteHandler(id) {
      this.deleteId = id;
      this.dialogConfirm = true;
    },
    close() {
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
        nama_produk: null,
        satuan: null,
        harga_jual: null,
        stok: null,
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