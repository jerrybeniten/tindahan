<template>
  <div class="body container-fluid d-flex align-items-center justify-content-center">
    <!-- Left Column (Login Form) -->
    <div
      class="login-container col-12 col-md-6 d-flex justify-content-center flex-column align-items-center"
    >
      <div class="logo text-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
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

      <div class="login-box p-4 shadow-lg rounded w-100">
        <form>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
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
      <div class="promo-text">
        <h3>Inside Dreamforce: The EMEA Edition</h3>
        <p>
          AI innovation. Expert-led learning. Inspired customer stories. All in six
          bitesized episodes. Only on Salesforce+.
        </p>
        <a href="#" class="btn btn-light">Watch Now</a>
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
