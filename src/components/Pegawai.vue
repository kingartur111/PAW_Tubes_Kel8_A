<template>
  <v-main class="list">
    <div class="d-flex justify-end mb-6">
      <v-btn color="brown" dark @click="dialog = true"> Tambah Pegawai</v-btn>
    </div>

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
      <v-data-table :headers="headers" :items="products" :search="search">
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn small class="mr-2" @click="detailHandler(item)">
            Detail
          </v-btn>
          <v-btn small class="mr-2" @click="editHandler(item)"> edit </v-btn>
          <v-btn small @click="deleteHandler(item.id)"> delete </v-btn>
        </template>
      </v-data-table>
    </v-card>

    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }} Produk</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text-field
              v-model="form.nama_produk"
              label="Nama Produk"
              required
            >
            </v-text-field>

            <v-text-field v-model="form.satuan" label="Satuan" required>
            </v-text-field>

            <v-text-field v-model="form.harga_jual" label="Harga Jual" required>
            </v-text-field>

            <v-text-field v-model="form.stok" label="Stok" required>
            </v-text-field>
          </v-container>
        </v-card-text>
        <v-card-action>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
          <v-btn color="blue darken-1" text @click="setForm"> Save </v-btn>
        </v-card-action>
      </v-card>
    </v-dialog>

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
      navbarBtn: 'home',
      load: false,
      snackbar: false,
      error_message: "",
      color: "",
      search: null,
      dialog: false,
      dialogConfirm: false,
      headers: [
        {
          text: "ID Pegawai",
          align: "start",
          sortable: true,
          value: "id",
        },
        { text: "Nama", value: "nama" },
        { text: "Nomor Telp", value: "notelp" },
        { text: "Jabatan", value: "jabatan" },
        { text: "Actions", value: "actions" },
      ],
      product: new FormData(),
      products: [
        {
          id: "185266115849",
          nama: "Calvin",
          notelp: "021-1515-11",
          jabatan: "Calvin OOOO",
        },
      ],
      form: {
        nama_produk: null,
        satuan: null,
        harga_jual: null,
        stok: null,
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
    //read data product
    readData() {
      var url = this.$api + "/product";
      this.$http
        .get(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.products = response.data.data;
          console.log(response.data.data);
          console.log(this.products);
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
      this.product.append("nama_produk", this.form.nama_produk);
      this.product.append("satuan", this.form.satuan);
      this.product.append("harga_jual", this.form.harga_jual);
      this.product.append("stok", this.form.stok);

      var url = this.$api + "/product/";
      this.load = true;
      this.$http
        .post(url, this.product, {
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
      var url = this.$api + "/product/" + this.editId;
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
      var url = this.$api + "/product/" + this.deleteId;
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