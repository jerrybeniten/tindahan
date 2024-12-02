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
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Store Name</th>
              <th>Locations</th>
              <th># of System Users</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Shanghai</td>
              <td>7</td>
              <td>0</td>
              <td>0%</td>
              <td>244</td>
              <td>₱0.00</td>
            </tr>
            <tr>
              <td>Manila</td>
              <td>5</td>
              <td>1</td>
              <td>20%</td>
              <td>100</td>
              <td>₱500.00</td>
            </tr>
            <tr>
              <td>Taguig</td>
              <td>3</td>
              <td>1</td>
              <td>30%</td>
              <td>50</td>
              <td>₱200.00</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div
        class="modal fade"
        id="createStore"
        tabindex="-1"
        aria-labelledby="createStoreModalLabel"
        aria-hidden="true"
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
    </main>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { reactive, ref } from "vue";

const name = ref("");
const description = ref("");
const errors = reactive({});
const isProcessing = ref(false);
const isSuccessfull = ref(false);

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
</script>
