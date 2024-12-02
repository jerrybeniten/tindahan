<template>
  <div>
    <!-- Top Navbar -->
    <div>
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom fixed-top">
        <div class="container-fluid">
          <a
            class="navbar-brand d-flex align-items-center"
            href="#"
            style="text-decoration: none; padding: 0"
          >
            <!-- Cloud Logo (SVG) -->
            <div class="d-flex align-items-center">
              <svg
                style="margin-top: 15px"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 200 200"
                width="50"
              >
                <!-- Cloud Body -->
                <circle cx="60" cy="80" r="30" fill="#00A1E0" />
                <circle cx="100" cy="70" r="40" fill="#00A1E0" />
                <circle cx="140" cy="90" r="25" fill="#00A1E0" />
              </svg>
            </div>

            <!-- Text Column -->
            <div class="col-auto">
              <span style="color: #5f6368">Tindahan</span>
            </div>

            <div class="divider"></div>

            <div class="col-auto">
              <span style="color: #5f6368">SUPER USER</span>
            </div>
          </a>

          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarContent">
            <form class="d-flex ms-auto">
              <input
                class="form-control me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    </div>
    <div v-if="isLoading" class="loading-line" style="margin-top: 26px"></div>

    <!-- Main Layout -->
    <div class="d-flex" style="margin-top: 80px; height: calc(100vh - 56px)">
      <!-- Sidebar -->
      <aside class="sidebar bg-light border-end" style="width: 250px; overflow-y: auto">
        <ul class="nav flex-column p-3">
          <li class="nav-item">
            <a href="#" class="nav-link text-dark">
              <i class="fas fa-chart-line"></i> Dashboard</a
            >
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link text-dark">
              <i class="fas fa-store"></i> Store Management</a
            >
          </li>
          <li class="nav-item">
            <a
              href="#submenu1"
              class="nav-link text-dark"
              data-bs-toggle="collapse"
              role="button"
              aria-expanded="false"
              aria-controls="submenu1"
              @click="toggleCollapse('traffic')"
            >
              <i class="fas fa-chart-bar"></i>
              <i
                class="fa-xs fas ms-2"
                :class="collapseState['traffic'] ? 'fa-chevron-down' : 'fa-chevron-right'"
              ></i>
              Traffic
            </a>
            <ul class="collapse list-unstyled ps-3" id="submenu1">
              <li>
                <a href="#" class="nav-link text-dark">User Management</a>
              </li>
              <li>
                <a href="#" class="nav-link text-dark">Settings</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a
              href="#submenu2"
              class="nav-link text-dark"
              data-bs-toggle="collapse"
              role="button"
              aria-expanded="false"
              aria-controls="submenu2"
              @click="toggleCollapse('user')"
            >
              <i class="fas fa-chart-bar"></i>
              <i
                class="fa-xs fas ms-2"
                :class="collapseState['user'] ? 'fa-chevron-down' : 'fa-chevron-right'"
              ></i>
              User Management
            </a>
            <ul class="collapse list-unstyled ps-3" id="submenu2">
              <li>
                <a href="#" class="nav-link text-dark">Retention</a>
              </li>
              <li>
                <a href="#" class="nav-link text-dark">Pages and screens</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link text-dark">
              <i class="fas fa-gear"></i> Settings</a
            >
          </li>
        </ul>
      </aside>

      <!-- Content Area -->
      <slot></slot>
    </div>
  </div>
</template>

<script>
import { ref, onUnmounted } from "vue";

export default {
  name: "AuthenticatedLayout",
  setup() {
    // Define reactive state using ref
    const collapseState = ref({
      traffic: false, // 'traffic' menu state (collapsed or expanded)
      user: false, // 'user' menu state (collapsed or expanded)
    });

    const isLoading = ref(true);

    // Method to toggle the collapse state of each menu
    const toggleCollapse = (menu) => {
      collapseState.value[menu] = !collapseState.value[menu];
    };

    // Use this loader when there is axios process for dashboard
    isLoading.value = false;

    return {
      isLoading,
      collapseState,
      toggleCollapse,
    };
  },
};
</script>

<style scoped>
.sidebar {
  height: 100%;
}

.chart-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
}

.nav {
  font-size: 14px;
  font-weight: 500;
}

.divider {
  border-left: 1px solid #dadce0;
  height: 32px;
  margin: 0 8px;
  width: 1px;
}

.loading-line {
  height: 2px; /* Thickness of the line */
  background-color: #00a1e0; /* Color of the loading line */
  width: 0; /* Start with width 0 */
  position: fixed;
  top: 56px; /* Adjust to match your navbar height */
  left: 0;
  z-index: 999;
  animation: loadAnimation 3s ease-out forwards; /* Animation to expand width */
}

@keyframes loadAnimation {
  0% {
    width: 0;
  }
  100% {
    width: 100%;
  }
}
</style>
