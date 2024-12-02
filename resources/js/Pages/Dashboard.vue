<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <main class="content flex-grow-1 p-4">
      <div class="d-flex justify-content-between align-items-center">
        <h5>Dashboard</h5>
        <div>
          <span class="ms-2"> <button class="btn btn-outline-secondary">Add Filter</button> </span>
          <span class="ms-2"> <button class="btn btn-outline-secondary">Add Comparison</button> </span>
        </div>
      </div>

      <hr />

      <!-- Chart Section -->
      <div class="mb-4">
        <div class="chart-placeholder bg-light border" style="height: 300px">
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
  </AuthenticatedLayout>
</template>
