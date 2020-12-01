<template>
  <v-main class="list">
    <div class="d-flex justify-space-between mb-6">
      <v-btn color="brown" dark @click="dialogRequest">
        Request Peminjaman
      </v-btn>
      <v-btn color="brown" dark @click="dialog = true">
        Tambah Peminjaman</v-btn
      >
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
      <v-data-table :headers="headers" :items="peminjamans" :search="search">
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn small class="mr-2" @click="editHandler(item)"> edit </v-btn>
          <v-btn small @click="deleteHandler(item.id)"> delete </v-btn>
        </template>
      </v-data-table>
    </v-card>

    <!-- Dialog Tambah -->
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }} Peminjaman</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text-field
              type="number"
              v-model="form.ISBN"
              label="ISBN"
              required
            >
            </v-text-field>

            <v-text-field v-model="form.peminjam" label="Peminjam" required>
            </v-text-field>

            <v-menu
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              :return-value.sync="dates"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-combobox
                  v-model="dates"
                  chips
                  small-chips
                  label="Tanggal Peminjaman"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-combobox>
              </template>
              <v-date-picker v-model="dates" no-title scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="menu = false">
                  Cancel
                </v-btn>
                <v-btn text color="primary" @click="$refs.menu.save(dates)">
                  OK
                </v-btn>
              </v-date-picker>
            </v-menu>

            <v-text-field v-model="form.status" label="Status" required>
            </v-text-field>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="setForm"> Save </v-btn>
            </v-card-actions>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Dialog Edit  -->
    <v-dialog v-model="dialogEdit" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }} Peminjaman</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text-field v-model="form.status" label="Status" required>
            </v-text-field>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="setForm"> Save </v-btn>
            </v-card-actions>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Dialog Delete -->
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
      menu: false,
      dates: "",
      inputType: "Tambah",
      load: false,
      snackbar: false,
      error_message: "",
      color: "",
      search: null,
      dialog: false,
      dialogConfirm: false,
      dialogEdit: false,
      headers: [
        {
          text: "ID Peminjaman",
          align: "start",
          sortable: true,
          value: "id",
        },
        { text: "ISBN", value: "ISBN" },
        { text: "Peminjam", value: "peminjam" },
        { text: "Tanggal Peminjaman", value: "tgl_pinjam" },
        { text: "Status", value: "status" },
        { text: "Actions", value: "actions" },
      ],
      peminjaman: new FormData(),
      peminjamans: [
        {
          id: "1",
          peminjam: "Adasdasd",
          tanggal: "10 November 2020",
          status: "asds",
        },
      ],
      form: {
        ISBN: null,
        peminjam: null,
        tgl_pinjam: null,
        status: null,
      },
      deleteId: "",
      editId: "",
      item: [],
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
    //read data peminjaman
    readData() {
      this.getPeminjaman();
    },

    getPeminjaman() {
      var url = this.$api + "/peminjaman";
      this.$http
        .get(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.peminjamans = response.data.data;
          console.log(response.data.data);
          console.log(this.peminjamans);
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
      let id = "PG" + Math.floor(Math.random() * 10000);
      this.peminjaman.append("id_peminjaman", id);
      this.peminjaman.append("ISBN", this.form.ISBN);
      this.peminjaman.append("peminjam", this.form.peminjam);
      this.peminjaman.append("tgl_pinjam", this.dates);
      this.peminjaman.append("status", this.form.status);

      var url = this.$api + "/peminjaman/";
      this.load = true;
      this.$http
        .post(url, this.peminjaman, {
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
        status: this.form.status,
      };
      var url = this.$api + "/peminjaman/" + this.editId;
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
          this.dialogEdit = false;
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
      var url = this.$api + "/peminjaman/" + this.deleteId;
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
    editHandler(item) {
      this.inputType = "Ubah";
      this.editId = item.id;
      this.form.nama_produk = item.nama_produk;
      this.form.satuan = item.satuan;
      this.form.stok = item.stok;
      this.form.harga_jual = item.harga_jual;
      this.dialogEdit = true;
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
      this.dialogEdit = false;
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