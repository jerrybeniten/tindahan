<template>
    <div>
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Analytics</a>
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
  
      <!-- Main Layout -->
      <div class="d-flex" style="margin-top: 56px; height: calc(100vh - 56px);">
        <!-- Sidebar -->
        <aside
          class="sidebar bg-light border-end"
          style="width: 250px; overflow-y: auto;"
        >
          <ul class="nav flex-column p-3">
            <li class="nav-item">
              <a href="#" class="nav-link text-dark">Reports snapshot</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-dark">Realtime overview</a>
            </li>
            <li class="nav-item">
              <a
                href="#submenu1"
                class="nav-link text-dark"
                data-bs-toggle="collapse"
                role="button"
                aria-expanded="false"
                aria-controls="submenu1"
              >
                Traffic
              </a>
              <ul
                class="collapse list-unstyled ps-3"
                id="submenu1"
              >
                <li>
                  <a href="#" class="nav-link text-dark">Overview</a>
                </li>
                <li>
                  <a href="#" class="nav-link text-dark">Demographic details</a>
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
              >
                User engagement
              </a>
              <ul
                class="collapse list-unstyled ps-3"
                id="submenu2"
              >
                <li>
                  <a href="#" class="nav-link text-dark">Retention</a>
                </li>
                <li>
                  <a href="#" class="nav-link text-dark">Pages and screens</a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-dark">Tech</a>
            </li>
          </ul>
        </aside>
  
        <!-- Content Area -->
        <main class="content flex-grow-1 p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5>Demographic details: City</h5>
            <div>
              <button class="btn btn-outline-secondary">Add Filter</button>
              <button class="btn btn-outline-secondary">Add Comparison</button>
            </div>
          </div>
  
          <hr />
  
          <!-- Chart Section -->
          <div class="mb-4">
            <div
              class="chart-placeholder bg-light border"
              style="height: 300px;"
            >
              <p class="text-center pt-5 text-muted">Chart Placeholder</p>
            </div>
          </div>
  
          <!-- Table Section -->
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>City</th>
                  <th>Active Users</th>
                  <th>New Users</th>
                  <th>Engagement Rate</th>
                  <th>Event Count</th>
                  <th>Total Revenue</th>
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
        </main>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "AnalyticsLayout",
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
  </style>
  