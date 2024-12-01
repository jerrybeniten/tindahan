<template>
  <div class="body container-fluid d-flex align-items-center justify-content-center">
    <!-- Left Column (Login Form) -->
    <div
      class="login-container col-12 col-md-6 d-flex justify-content-center flex-column align-items-center"
    >      
      <div class="login-box p-4 shadow-lg rounded w-100">
        <form>
          <div class="mb-3">
            <label for="username" class="form-label">Merchant Username</label>
            <input type="text" class="form-control" id="username" name="username" />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" />
          </div>

          <button type="submit" class="btn btn-primary">Log In</button>

          <div class="mt-3 form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe" />
            <label class="form-check-label forgot-password" for="rememberMe"
              >Remember me</label
            >
          </div>

          <div class="d-flex justify-content-between mt-3">
            <a href="#" class="forgot-password">Forgot Your Password?</a>
            <a href="#" class="try-free">Try for Free</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Right Column (Promotional Section) -->
    <div class="container-right col-md-6 d-none d-md-block">
      <div class="promo-text container">
        <div class="container mt-5">
          <div class="row align-items-center">
            <!-- SVG Column -->
            <div class="col-auto" style="margin-left:-30px;">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="100">
                <!-- Cloud Body -->
                <circle cx="60" cy="80" r="30" fill="#00A1E0" />
                <circle cx="100" cy="70" r="40" fill="#00A1E0" />
                <circle cx="140" cy="90" r="25" fill="#00A1E0" />

                <!-- Store Icon -->
                <rect x="80" y="115" width="40" height="35" fill="#E6F7FF" rx="5" />
                <polygon points="80,115 100,90 120,115" fill="#E6F7FF" />

                <!-- Store Door -->
                <rect x="90" y="130" width="20" height="20" fill="#00A1E0" />

                <!-- Store Text Inside Cloud -->
                <text
                  x="50%"
                  y="85"
                  font-size="16"
                  fill="white"
                  text-anchor="middle"
                  font-family="Arial, sans-serif"
                >
                  TINDAHAN
                </text>
              </svg>
            </div>
            <!-- Text Column -->
            <div class="col-auto" style="margin-left:-15px;">
              <h1>Tindahan</h1>
            </div>
          </div>
        </div>

        <h3 class="mt-3">Your Storefront Without the Physical Store</h3>
        <p class="mt-5">
          Tindahan.biz empowers sari-sari store ownsers and small entrepreneurs to start
          their own business without the hassle of building a physical shop. With just a
          few clicks, you can create an online store, manage orders, and serve customers
          right from your doorstep. Wheter you are slling snacks, household essentials, or
          specialty items, Tidahan.biz makes it simple to reach your neighborhood and
          beyond. No Physical space? No Problem-your home is now your business hub!
        </p>
        <a href="#" class="btn btn-primary">WATCH NOW</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    canLogin: {
      type: Boolean,
    },
    canRegister: {
      type: Boolean,
    },
    laravelVersion: {
      type: String,
      required: true,
    },
    phpVersion: {
      type: String,
      required: true,
    },
  },
};
</script>
1
