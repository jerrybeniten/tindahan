<template>
  <Head title="Store Management" />
  <AuthenticatedLayout>
    <main class="content flex-grow-1 p-4">
      <div class="d-flex justify-content-between align-items-center">
        <h5>Store Management / Profile / {{ data.name }}</h5>
      </div>

      <hr />

      <!-- Table Section -->
      <div class="mt-4 justify-left">
        <div class="mt-4 justify-left">
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center w-100">
              <input
                type="text"
                v-model="search"
                class="form-control"
                placeholder="Search stores location by name or code..."
                @input="fetchStoreLocations(1)"
                style="width: 50%"
              />
              <span class="ms-2">
                <button
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#createStoreLocation"
                  @click.prevent="createStoreLocation"
                >
                  <i class="fas fa-plus"></i> Add Location
                </button>
              </span>
            </div>
          </div>
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
              <th @click="setSort('location_name')" class="sortable">
                Location Name
                <span v-if="sortBy == 'uuid'">
                  <i :class="sortOrderIcon"></i>
                </span>
              </th>
              <th @click="setSort('store_code')" class="sortable">
                Store Code
                <span v-if="sortBy == 'store_code'">
                  <i :class="sortOrderIcon"></i>
                </span>
              </th>
              <th @click="setSort('manager_name')" class="sortable">
                Manager's Name
                <span v-if="sortBy == 'manager_name'">
                  <i :class="sortOrderIcon"></i>
                </span>
              </th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="storeLocations in storeLocations.data" :key="storeLocations.uuid">
              <td>
                <a
                  :href="route('storeManagement.profile', { uuid: storeLocations.uuid })"
                >
                  {{ storeLocations.uuid.split("-")[0] }}</a
                >
              </td>
              <td>{{ storeLocations.location_name }}</td>
              <td>{{ storeLocations.store_code }}</td>
              <td>{{ storeLocations.manager_name }}</td>
              <td>
                <span
                  ><a
                    href="#"
                    class="text-decoration-none"
                    @click.prevent="viewStore(storeLocations.uuid)"
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
                    @click.prevent="viewStore(storeLocations.uuid)"
                    ><i class="fas fa-regular fa-pen-to-square"></i></a
                ></span>
                <span
                  ><a
                    href="#"
                    class="text-decoration-none"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteStore"
                    @click.prevent="viewStore(storeLocations.uuid)"
                    ><i class="fas fa-regular fa-trash-can"></i></a
                ></span>
                <span
                  ><a href="#" class="text-decoration-none"
                    ><i class="fas fa-regular fa-lock-open"></i></a
                ></span>
              </td>
            </tr>
          </tbody>
        </table>
        <nav>
          <ul class="pagination justify-content-start">
            <li class="page-item" :class="{ disabled: pagination.current === 1 }">
              <button
                class="page-link"
                @click="fetchStoreLocations(pagination.current - 1)"
              >
                Previous
              </button>
            </li>
            <li
              class="page-item"
              v-for="page in pagination.pages"
              :key="page"
              :class="{ active: pagination.current === page }"
            >
              <button class="page-link" @click="fetchStoreLocations(page)">
                {{ page }}
              </button>
            </li>
            <li
              class="page-item"
              :class="{ disabled: pagination.current === pagination.pages.length }"
            >
              <button
                class="page-link"
                @click="fetchStoreLocations(pagination.current + 1)"
              >
                Next
              </button>
            </li>
          </ul>
        </nav>
      </div>

      <!--create store location modal-->
      <div
        class="modal fade"
        id="createStoreLocation"
        tabindex="-1"
        aria-labelledby="createStoreLocationModalLabel"
      >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="createStoreLocationModalLabel">
                <i class="fas fa-plus"></i> Create Store Location
              </h1>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <form v-if="!isSuccessfull" @submit.prevent="submitStoreLocation">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="location_name" class="col-form-label"
                        >Location Name:</label
                      >
                      <input
                        v-model="location_name"
                        type="text"
                        class="form-control"
                        :class="{
                          'form-control': true,
                          'is-invalid': errors.location_name,
                        }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.location_name }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="store-code" class="col-form-label">Store Code:</label>
                      <input
                        v-model="store_code"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.store_code }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.store_code }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="managers-name" class="col-form-label"
                        >Managers Name:</label
                      >
                      <input
                        v-model="manager_name"
                        class="form-control"
                        :class="{
                          'form-control': true,
                          'is-invalid': errors.manager_name,
                        }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.manager_name }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="email" class="col-form-label">Email:</label>
                      <input
                        v-model="email"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.email }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.email }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="phone" class="col-form-label">Phone:</label>
                      <input
                        v-model="phone"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.phone }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.phone }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="addressLine1" class="col-form-label"
                        >Address Line 1:</label
                      >
                      <input
                        v-model="address_line1"
                        class="form-control"
                        :class="{
                          'form-control': true,
                          'is-invalid': errors.address_line1,
                        }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.address_line1 }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="addressLine2" class="col-form-label"
                        >Address Line 2:</label
                      >
                      <input
                        v-model="address_line2"
                        class="form-control"
                        :class="{
                          'form-control': true,
                          'is-invalid': errors.address_line2,
                        }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.address_line2 }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="city" class="col-form-label">City:</label>
                      <input
                        v-model="city"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.city }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.city }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="state" class="col-form-label">State:</label>
                      <input
                        v-model="state"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.state }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.state }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="zipCode" class="col-form-label">Zip Code:</label>
                      <input
                        v-model="zip_code"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.zip_code }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.zip_code }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label for="country" class="col-form-label">Country:</label>
                      <input
                        v-model="country"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.country }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.country }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="latitude" class="col-form-label">Latitude:</label>
                      <input
                        v-model="latitude"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.latitude }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.latitude }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="longitude" class="col-form-label">Longitude:</label>
                      <input
                        v-model="longitude"
                        class="form-control"
                        :class="{ 'form-control': true, 'is-invalid': errors.longitude }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.longitude }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="longitude" class="col-form-label">Opening Hours:</label>
                      <input
                        v-model="opening_hours"
                        class="form-control"
                        :class="{
                          'form-control': true,
                          'is-invalid': errors.opening_hours,
                        }"
                      />
                      <div class="invalid-feedback">
                        {{ errors.opening_hours }}
                      </div>
                    </div>
                    <div class="mb-3">
                      <div class="form-check form-switch">
                        <input
                          v-model="is_active"
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          id="flexSwitchCheckDefault"
                        />
                        <label class="form-check-label" for="flexSwitchCheckDefault"
                          >Enabled</label
                        >
                      </div>
                    </div>
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
import { ref, reactive, computed, onMounted } from "vue";

const location_name = ref("");
const store_code = ref("");
const manager_name = ref("");
const email = ref("");
const phone = ref("");
const address_line1 = ref("");
const address_line2 = ref("");
const city = ref("");
const state = ref("");
const zip_code = ref("");
const country = ref("");
const latitude = ref("");
const longitude = ref("");
const is_active = ref(true);
const opening_hours = ref("");

const errors = reactive({});
const isProcessing = ref(false);
const isSuccessfull = ref(false);

const viewData = reactive({});

const clearErrors = () => {
  isProcessing.value = true;
  Object.keys(errors).forEach((key) => {
    errors[key] = ""; // Reset each error message to an empty string
  });
};

const submitStoreLocation = async () => {
  clearErrors();
  try {
    // Make a POST request to the login route
    const response = await axios.post("/store-location/store", {
      location_name: location_name.value,
      store_code: store_code.value,
      manager_name: manager_name.value,
      email: email.value,
      phone: phone.value,
      address_line1: address_line1.value,
      address_line2: address_line2.value,
      city: city.value,
      state: state.value,
      zip_code: zip_code.value,
      country: country.value,
      latitude: latitude.value,
      longitude: longitude.value,
      is_active: is_active.value,
      opening_hours: opening_hours.value,
    });

    if (response.status === 200) {
      isSuccessfull.value = true;
      fetchStoreLocations();
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
      console.log(err);
      alert("An unexpected error occurred.");
    }

    // allows ready for re-processing again
    isProcessing.value = false;
  }
};

// getStores
// State variables
const storeLocations = reactive({
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
const fetchStoreLocations = async (page = 1) => {
  try {
    const response = await axios.get("/store-location/get-store-locatons", {
      params: {
        page,
        sort_by: sortBy.value,
        sort_order: sortOrder.value,
        search: search.value,
      },
    });

    // Update reactive objects
    storeLocations.data = response.data.data;
    storeLocations.current_page = response.data.current_page;
    storeLocations.last_page = response.data.last_page;

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
  fetchStoreLocations(pagination.current);
};

// Compute the sort order icon
const sortOrderIcon = computed(() =>
  sortOrder.value === "asc"
    ? "fas fa-arrow-up-wide-short"
    : "fas fa-arrow-down-wide-short"
);

// Fetch data on mount
onMounted(() => {
  fetchStoreLocations();
});

defineProps({
  data: {
    type: Object,
    required: true,
  },
});
</script>
