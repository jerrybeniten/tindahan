<template>
  <Head title="Store Management" />
  <AuthenticatedLayout>
    <main class="content flex-grow-1 p-4">
      <div class="d-flex justify-content-between align-items-center">
        <h5>Store Management</h5>
        <div>
          <span class="ms-2">
            <button
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#createStore"
              @click.prevent="createStore"
            >
              <i class="fas fa-plus"></i> Create Store
            </button>
          </span>
        </div>
      </div>

      <hr />

      <!-- Table Section -->
      <div class="mt-4 justify-left">
        <div class="mb-3">
          <input
            type="text"
            v-model="search"
            class="form-control"
            placeholder="Search stores by name or description..."
            @input="fetchStores(1)"
          />
        </div>
        <table class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th @click="setSort('uuid')" class="sortable">
                UUID
                <span v-if="sortBy == 'uuid'">
                  <i :class="sortOrderIcon"></i>
                </span>
              </th>
              <th @click="setSort('name')" class="sortable">
                Name
                <span v-if="sortBy == 'name'">
                  <i :class="sortOrderIcon"></i>
                </span>
              </th>
              <th @click="setSort('description')" class="sortable">
                Description
                <span v-if="sortBy == 'description'">
                  <i :class="sortOrderIcon"></i>
                </span>
              </th>
              <th @click="setSort('created_at')" class="sortable">Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="store in stores.data" :key="store.uuid">
              <td>{{ store.uuid.split("-")[0] }}</td>
              <td>{{ store.name }}</td>
              <td>{{ store.description }}</td>
              <td>{{ store.created_at }}</td>
              <td class="d-flex gap-2">
                <span
                  ><a
                    href="#"
                    class="text-decoration-none"
                    @click.prevent="viewStore(store.uuid)"
                    data-bs-toggle="modal"
                    data-bs-target="#viewStore"
                    ><i class="fas fa-regular fa-eye"></i></a
                ></span>
                <span
                  ><a
                    href="#"
                    class="text-decoration-none"
                    data-bs-toggle="modal"
                    data-bs-target="#updateStore"
                    @click.prevent="viewStore(store.uuid)"
                    ><i class="fas fa-regular fa-pen-to-square"></i></a
                ></span>
                <span
                  ><a href="#" class="text-decoration-none"
                    ><i class="fas fa-regular fa-trash-can"></i></a
                ></span>
                <span
                  ><a href="#" class="text-decoration-none"
                    ><i class="fas fa-regular fa-circle-stop"></i></a
                ></span>
              </td>
            </tr>
          </tbody>
        </table>
        <nav>
          <ul class="pagination justify-content-start">
            <li class="page-item" :class="{ disabled: pagination.current === 1 }">
              <button class="page-link" @click="fetchStores(pagination.current - 1)">
                Previous
              </button>
            </li>
            <li
              class="page-item"
              v-for="page in pagination.pages"
              :key="page"
              :class="{ active: pagination.current === page }"
            >
              <button class="page-link" @click="fetchStores(page)">
                {{ page }}
              </button>
            </li>
            <li
              class="page-item"
              :class="{ disabled: pagination.current === pagination.pages.length }"
            >
              <button class="page-link" @click="fetchStores(pagination.current + 1)">
                Next
              </button>
            </li>
          </ul>
        </nav>
      </div>

      <div
        class="modal fade"
        id="viewStore"
        tabindex="-1"
        aria-labelledby="viewStoreModalLabel"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="viewStoreModalLabel">
                <i class="fas fa-regular fa-eye"></i> View Store
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div>
              <div class="modal-body">
                <p>
                  <strong>UUID:</strong> <span> {{ viewData.value?.uuid }} </span>
                </p>
                <p>
                  <strong>Store Name:</strong> <span> {{ viewData.value?.name }} </span>
                </p>
                <p>
                  <strong>Description:</strong>
                  <span> {{ viewData.value?.description }} </span>
                </p>
              </div>
              <!-- Success Notice -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--create store modal-->
      <div
        class="modal fade"
        id="createStore"
        tabindex="-1"
        aria-labelledby="createStoreModalLabel"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="createStoreModalLabel">
                <i class="fas fa-plus"></i> Create Store
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <form v-if="!isSuccessfull" @submit.prevent="submitStore">
              <div class="modal-body">
                <div class="mb-3">
                  <label for="name" class="col-form-label">Store Name:</label>
                  <input
                    v-model="name"
                    type="text"
                    class="form-control"
                    :class="{ 'form-control': true, 'is-invalid': errors.name }"
                  />
                  <div class="invalid-feedback">
                    {{ errors.name }}
                  </div>
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Description:</label>
                  <textarea
                    v-model="description"
                    class="form-control"
                    :class="{ 'form-control': true, 'is-invalid': errors.description }"
                  >
                  </textarea>
                  <div class="invalid-feedback">
                    {{ errors.description }}
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Close
                </button>
                <button
                  type="submit"
                  :class="isProcessing ? 'btn btn-primary disabled' : 'btn btn-primary'"
                  :disabled="isProcessing"
                >
                  <div
                    v-if="isProcessing"
                    class="spinner-border spinner-border-sm me-2 mt-1"
                    role="status"
                  ></div>
                  {{ isProcessing ? "Please Wait..." : "Submit" }}
                </button>
              </div>
            </form>
            <div v-else>
              <div class="modal-body text-center">
                <i class="fa-solid fa-check success-icon"></i>
                <p class="success-text">Successful</p>
              </div>
              <!-- Success Notice -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--update store modal-->
      <div
        class="modal fade"
        id="updateStore"
        tabindex="-1"
        aria-labelledby="updateStoreModalLabel"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="updateStoreModalLabel">
                <i class="fas fa-regular fa-pen-to-square"></i> Update Store
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <form v-if="!isSuccessfull" @submit.prevent="submitUpdateStore">
              <div class="modal-body">
                <div class="mb-3">
                  <label for="name" class="col-form-label">UUID:</label>
                  <input v-model="uuid" type="text" class="form-control" disabled />
                  <div class="invalid-feedback">
                    {{ errors.name }}
                  </div>
                </div>
                <div class="mb-3">
                  <label for="name" class="col-form-label">Store Name:</label>
                  <input
                    v-model="name"
                    type="text"
                    class="form-control"
                    :class="{ 'form-control': true, 'is-invalid': errors.name }"
                  />
                  <div class="invalid-feedback">
                    {{ errors.name }}
                  </div>
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Description:</label>
                  <textarea
                    v-model="description"
                    class="form-control"
                    :class="{ 'form-control': true, 'is-invalid': errors.description }"
                  >
                  </textarea>
                  <div class="invalid-feedback">
                    {{ errors.description }}
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Close
                </button>
                <button
                  type="submit"
                  :class="isProcessing ? 'btn btn-primary disabled' : 'btn btn-primary'"
                  :disabled="isProcessing"
                >
                  <div
                    v-if="isProcessing"
                    class="spinner-border spinner-border-sm me-2 mt-1"
                    role="status"
                  ></div>
                  {{ isProcessing ? "Please Wait..." : "Update" }}
                </button>
              </div>
            </form>
            <div v-else>
              <div class="modal-body text-center">
                <i class="fa-solid fa-check success-icon"></i>
                <p class="success-text">Successful</p>
              </div>
              <!-- Success Notice -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, reactive, computed, onMounted } from "vue";

const name = ref("");
const description = ref("");
const uuid = ref("");
const errors = reactive({});
const isProcessing = ref(false);
const isSuccessfull = ref(false);

const viewData = reactive({});

const createStore = () => {
  isProcessing.value = false;
  isSuccessfull.value = false;
  name.value = "";
  description.value = "";
};

const clearErrors = () => {
  isProcessing.value = true;
  Object.keys(errors).forEach((key) => {
    errors[key] = ""; // Reset each error message to an empty string
  });
};

const submitStore = async () => {
  clearErrors();
  try {
    // Make a POST request to the login route
    const response = await axios.post("/store-management/store", {
      name: name.value,
      description: description.value,
    });

    if (response.status === 200) {
      isSuccessfull.value = true;
      fetchStores();
    }
  } catch (err) {
    // Handle error (invalid credentials, etc.)
    // error.value = err.errors || 'Login failed!';

    if (err.response?.data?.errors) {
      const responseErrors = err.response.data.errors;
      Object.keys(responseErrors).forEach((field) => {
        errors[field] = responseErrors[field][0]; // Take the first error message
      });
    } else {
      alert("An unexpected error occurred.");
    }

    // allows ready for re-processing again
    isProcessing.value = false;
  }
};

const submitUpdateStore = async () => {
  clearErrors();
  try {
    // Make a POST request to the login route
    const response = await axios.post("/store-management/update-store", {
      uuid: uuid.value,
      name: name.value,
      description: description.value,
    });

    if (response.status === 200) {
      isSuccessfull.value = true;
      isProcessing.value = false;
      fetchStores();
    }
  } catch (err) {
    // Handle error (invalid credentials, etc.)
    // error.value = err.errors || 'Login failed!';

    if (err.response?.data?.errors) {
      const responseErrors = err.response.data.errors;
      Object.keys(responseErrors).forEach((field) => {
        errors[field] = responseErrors[field][0]; // Take the first error message
      });
    } else {
      alert("An unexpected error occurred.");
    }

    // allows ready for re-processing again
    isProcessing.value = false;
  }
};

const viewStore = async (uuidData) => {
  isSuccessfull.value = false;
  try {
    // Make a POST request to the login route
    const response = await axios.post("/store-management/view-store", {
      uuid: uuidData,
    });

    if (response.status === 200) {
      viewData.value = response.data;
      uuid.value = viewData.value?.uuid;
      name.value = viewData.value?.name;
      description.value = viewData.value?.description;
    }
  } catch (err) {
    // Handle error (invalid credentials, etc.)
    // error.value = err.errors || 'Login failed!';
    console.log(err);
    if (err.response?.data?.errors) {
    } else {
      alert("An unexpected error occurred.");
    }
  }
};

// getStores
// State variables
const stores = reactive({
  data: [],
  current_page: 1,
  last_page: 1,
});

const sortBy = ref("id");
const sortOrder = ref("asc");
const search = ref("");

const pagination = reactive({
  current: 1,
  pages: [],
});

// Fetch stores from the backend
const fetchStores = async (page = 1) => {
  try {
    const response = await axios.get("/store-management/get-stores", {
      params: {
        page,
        sort_by: sortBy.value,
        sort_order: sortOrder.value,
        search: search.value,
      },
    });

    // Update reactive objects
    stores.data = response.data.data;
    stores.current_page = response.data.current_page;
    stores.last_page = response.data.last_page;

    pagination.current = response.data.current_page;
    pagination.pages = Array.from({ length: response.data.last_page }, (_, i) => i + 1);
  } catch (error) {
    console.error("Error fetching stores:", error);
  }
};

// Set sorting for columns
const setSort = (column) => {
  if (sortBy.value === column) {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
  } else {
    sortBy.value = column;
    sortOrder.value = "asc";
  }
  fetchStores(pagination.current);
};

// Compute the sort order icon
const sortOrderIcon = computed(() =>
  sortOrder.value === "asc"
    ? "fas fa-arrow-up-wide-short"
    : "fas fa-arrow-down-wide-short"
);

// Fetch data on mount
onMounted(() => {
  fetchStores();
});
</script>
