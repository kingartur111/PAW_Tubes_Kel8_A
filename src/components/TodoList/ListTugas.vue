<template>
  <v-main class="list">
    <h3 class="text-h3 font-weight-medium mb-5">To Do List Tugas</h3>

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
        <v-select
          :items="filter"
          v-model="selected"
          label="Priority"
          required
        ></v-select>
        <v-btn color="success" dark @click="dialog = true"> Tambah </v-btn>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="todos"
        :search="search || selected"
      >
        <template v-slot:[`item.actions`]="{ item }">
          <v-btn
            small
            class="mr-2"
            @click="
              editItem(item),
                (dialog = true),
                (isEdited = true),
                (tambah = false),
                (index = todos.indexOf(item))
            "
          >
            <v-icon color="primary"> edit </v-icon>
          </v-btn>
          <v-btn small @click="deleteItem(item), (isAlert = true)">
            <v-icon color="red"> delete </v-icon>
          </v-btn>
          <input
            type="checkbox"
            id="checkbox"
            v-model="item.hapus"
            @change="checked(item)"
          />
        </template>
      </v-data-table>
    </v-card>
    <v-card v-if="check.length != 0">
      <v-card-title>Hapus Semua</v-card-title>
      <ul>
        <li v-for="item in check" :key="item.task">{{ item.task }}</li>
      </ul>
      <v-btn class="ma-4 white--text" @click="hapusSemua" color="red"
        >Hapus</v-btn
      >
    </v-card>

    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Form Todo</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text-field
              v-model="formTodo.task"
              label="Task"
              required
            ></v-text-field>

            <v-select
              v-model="formTodo.priority"
              :items="['Penting', 'Biasa', 'Tidak penting']"
              label="Priority"
              required
            ></v-select>

            <v-textarea
              v-model="formTodo.note"
              label="Note"
              required
            ></v-textarea>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
          <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-main>
</template>
<script>
export default {
  name: "List",
  data() {
    return {
      search: null,
      dialog: false,
      isAlert: false,
      index: null,
      isEdited: false,
      tambah: true,
      check: [],
      filter: ["Penting", "Biasa", "Tidak penting"],
      selected: "",
      headers: [
        {
          text: "Task",
          align: "start",
          sortable: true,
          value: "task",
        },
        { text: "Priority", value: "priority" },
        { text: "Note", value: "note" },
        { text: "Actions", value: "actions" },
        { text: "", value: "" },
      ],
      todos: [
        {
          task: "bernafas",
          priority: "Penting",
          note: "huffttt",
          hapus: false,
        },
        {
          task: "nongkrong",
          priority: "Tidak penting",
          note: "bersama tman2",
          hapus: false,
        },
        {
          task: "masak",
          priority: "Biasa",
          note: "masak air 500ml",
          hapus: false,
        },
      ],
      formTodo: {
        task: null,
        priority: null,
        note: null,
      },
    };
  },

  computed: {
    filteredPriority: function () {
      return this.todos.filter((todo) => {
        return todo.priority.toLowerCase().match(this.selected.toLowerCase());
      });
    },
  },
  methods: {
    save() {
      if (this.isEdited == false || this.tambah == true) {
        this.todos.push(this.formTodo);
        this.resetForm();
        this.dialog = false;
      } else {
        (this.todos[this.index].task = this.formTodo.task),
          (this.todos[this.index].priority = this.formTodo.priority),
          (this.todos[this.index].note = this.formTodo.note);
        this.resetForm();
        this.dialog = false;
      }
    },
    cancel() {
      this.resetForm();
      this.dialog = false;
    },
    resetForm() {
      this.formTodo = {
        task: null,
        priority: null,
        note: null,
      };
    },
    editItem(item) {
      this.formTodo = {
        task: item.task,
        priority: item.priority,
        note: item.note,
      };
    },
    deleteItem(item) {
      this.todos.splice(this.todos.indexOf(item), 1);
    },
    filterByPriority(selected) {
      return this.todos.indexOf(selected);
    },
    checked(item) {
      if (item.hapus) {
        this.check.push(item);
      } else {
        let index = this.check.findIndex((todo) => todo.task === item.task);
        this.check.splice(index, 1);
      }
      console.log(this.check);
    },
    hapusSemua() {
      for (let i = 0; i < this.check.length; i++) {
        let findIndex = this.todos.indexOf(this.check[i]);
        this.todos.splice(findIndex, 1);
      }
      this.check = [];
    },
  },
};
</script>
