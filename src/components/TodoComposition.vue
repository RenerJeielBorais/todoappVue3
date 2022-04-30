<template>
  <body>
    <div>
      <div class="bg_move">
        <i class="fas fa-palette"></i>
        <h3>TODO APP</h3>
      </div>

      <div class="container">
        <div class="row g-2">
          <div class="col-md-12">
            <form class="aform">
              <div class="col-md-2">
                <div class="form">
                  <input
                    name="title"
                    type="text"
                    class="form-control"
                    id="floatingInput"
                    placeholder="Enter Title"
                    v-model="addTitle"
                  />
                </div>
              </div>
              <div class="col-md-5">
                <div class="form">
                  <input
                    type="text"
                    class="form-control"
                    id="floatingDescription"
                    placeholder="Enter Description"
                    v-model="addDescription"
                  />
                </div>
              </div>
              <div class="col-md-3">
                <div class="col-md">
                  <div class="form">
                    <select
                      class="form-control"
                      name="status"
                      id="status"
                      v-model="status"
                    >
                      <option selected value="" disabled>Select Status</option>
                      <option value="Active">Active</option>
                      <option value="In-Progress">In-Progress</option>
                      <option value="Done">Done</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <label for="checkbox">
                  <button
                    class="btn btn-primary"
                    type="submit"
                    @click="updateTodo"
                    v-if="update"
                  >
                    Edit
                  </button>
                  <button
                    class="btn btn-secondary"
                    type="button"
                    @click.prevent="onCancel"
                    v-if="update"
                  >
                    Cancel
                  </button>
                  <button
                    class="btn btn-success"
                    type="submit"
                    @click="addNewTodo"
                    v-if="!update"
                  >
                    Add Task
                  </button>
                </label>
              </div>
            </form>
          </div>
        </div>
        <hr />
        <h3 class="text-start">Todos</h3>
        <!-- TABLE -->
        <div class="row">
          <div class="col-md">
            <table class="table table-striped">
              <thead class="header-background">
                <tr>
                  <th scope="col" class="text-center">Title</th>
                  <th scope="col" class="text-center">Description</th>
                  <th scope="col" class="text-center">Status</th>
                  <th scope="col" class="text-center">Edit</th>
                  <th scope="col" class="text-center">Delete</th>
                </tr>
              </thead>
              <tbody class="table-background">
                <tr v-for="todo in todoLists" :key="todo.id">
                  <td>
                    <!-- todo -->
                    {{ todo.title }}
                  </td>
                  <td class="text-center button-check">
                    {{ todo.description }}
                  </td>
                  <td class="text-center button-check">
                    <div v-if="todo.status === 'Active'">
                      <span class="badge rounded-pill bg-primary">Active</span>
                    </div>
                    <div v-else-if="todo.status === 'In-Progress'">
                      <span class="badge rounded-pill bg-secondary"
                        >In-Progress</span
                      >
                    </div>
                    <div v-else-if="todo.status === 'Done'">
                      <span class="badge rounded-pill bg-warning">Done</span>
                    </div>
                    <div v-else-if="todo.status === 'Completed'">
                      <span class="badge rounded-pill bg-success"
                        >Completed</span
                      >
                    </div>

                    <div v-else>None</div>
                  </td>

                  <td>
                    <button class="btn btn-primary" @click="toggleEdit(todo)">
                      Edit
                    </button>
                  </td>
                  <td>
                    <button
                      style="margin-right: 20px"
                      class="btn btn-danger"
                      @click="deleteTodo(todo.id)"
                    >
                      Remove
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </body>
</template>

<script>
import { onMounted, ref } from "vue";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";

export default {
  setup() {
    let todoLists = ref([]);
    let addTitle = ref("");
    let addDescription = ref("");
    let hiddenID = ref("");
    let editInput = ref("");
    const update = ref(false);
    let status = ref("");

    display();

    function display() {
      axios
        .get(
          "http://localhost/ojt-training-todoapp/src/components/action.php?run=read"
        )
        .then(function (response) {
          todoLists.value = response.data.todo;
        })
        .catch(function (error) {
          console.log(error);
        });
    }

    function addNewTodo() {
      location.reload();
      axios.post(
        "http://localhost/ojt-training-todoapp/src/components/action.php?run=add",
        {
          title: addTitle.value,
          description: addDescription.value,
          status: status.value,
        }
      );
      addTitle.value = "";
      addDescription.value = "";
    }

    function deleteTodo(id) {
      location.reload();
      axios.post(
        "http://localhost/ojt-training-todoapp/src/components/action.php?run=delete",
        {
          id: id,
        }
      );
    }

    function updateTodo() {
      location.reload();
      axios.post(
        "http://localhost/ojt-training-todoapp/src/components/action.php?run=update",
        {
          title: addTitle.value,
          description: addDescription.value,
          id: hiddenID.value,
          status: status.value,
        }
      );
    }
    const toggleEdit = (todo) => {
      if (addTitle.value < 1) {
        update.value = !update.value;
        hiddenID.value = todo.id;
        addTitle.value = todo.title;
        addDescription.value = todo.description;
      }
    };

    const onCancel = () => {
      location.reload();
    };

    //onMounted
    onMounted(() => {
      display();
    });

    return {
      todoLists,
      addNewTodo,
      addTitle,
      addDescription,
      hiddenID,
      deleteTodo,
      updateTodo,
      editInput,
      toggleEdit,
      update,
      status,
      onCancel,
    };
  },
};
</script>

<style scope>
form {
  background: #005f73;
  border-radius: 5px;
  padding-top: 15px;
  padding-left: 10px;
  padding-bottom: 15px;
  display: flex;
  align-items: center;
  margin: 20px;
  width: 100%;
}

form input[type="text"] {
  border: none;
  border-radius: 5px;
  width: 90%;
}

form input[type="submit"] {
  border: none;
  padding: 10px 25px;
  background: #e90c0c;
  color: white;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
}
.table-background {
  background-color: white;
  color: black;
}

.bg_move {
  background-size: 250px 250px;
  background-position: 0 0;
  color: black;
}

.header-background {
  background-color: #005f73;
  color: white;
}

.bg_move h1 {
  font-size: 6rem;
  font-family: sans-serif;
}

.bg_move i {
  font-size: 8rem;
}

@media only screen and (max-width: 900px) {
  html {
    font-size: 10px;
  }
}

@media only screen and (max-width: 500px) {
  html {
    font-size: 6px;
  }
}

@-webkit-keyframes stripes {
  100% {
    background-position: 250px 0, 250px 0, 100px 0;
  }
}

@keyframes stripes {
  100% {
    background-position: 250px 0, 250px 0, 100px 0;
  }
}
</style>
