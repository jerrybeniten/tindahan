<template>
  <div class="body container-fluid d-flex align-items-center justify-content-center">
    <!-- Left Column (Login Form) -->
    <div
      class="login-container col-12 col-md-6 d-flex justify-content-center flex-column align-items-center"
    >
      <div class="login-box p-4 shadow-lg rounded w-100">
        <form @submit.prevent="login">
          <div class="mb-3">
            <label for="username" class="form-label">Merchant Username</label>
            <input
              v-model="email"
              type="text"
              :class="{ 'form-control': true, 'is-invalid': errors.email }"
            />
            <div class="invalid-feedback">
              {{ errors.email }}
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              v-model="password"
              type="password"
              :class="{ 'form-control': true, 'is-invalid': errors.password }"
            />

            <div class="invalid-feedback">
              {{ errors.password }}
            </div>
          </div>

          <button
            type="submit"
            :class="isProcessing ? 'btn btn-primary disabled' : 'btn btn-primary'"
            :disabled="isProcessing"
          >
            <div
              v-if="isProcessing"
              class="spinner-border spinner-border-sm me-2 mt-1"
              role="status"
            >
              <span class="visually-hidden">Loading...</span>
            </div>
            {{ isProcessing ? "Please Wait..." : "Log In" }}
          </button>

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
            <div class="col-auto" style="margin-left: -30px">
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
            <div class="col-auto" style="margin-left: -15px">
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
import { reactive, ref } from "vue";

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

  setup() {
    const email = ref("");
    const password = ref("");
    const errors = reactive({});
    const isProcessing = ref(false);

    const clearErrors = () => {
      isProcessing.value = true;
      Object.keys(errors).forEach((key) => {
        errors[key] = ""; // Reset each error message to an empty string
      });
    };

    const login = async () => {
      clearErrors();
      try {
        // Make a POST request to the login route
        const response = await axios.post("/login", {
          email: email.value,
          password: password.value,
        });

        window.location.href = "/dashboard"; // Redirect to a protected page
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

    return {
      isProcessing,
      email,
      password,
      errors,
      login,
    };
  },
};
</script>

<style lang="css" scoped>
.body {
  background-color: #f4f6f9;
}

.container-fluid {
  height: 100vh;
}

.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.login-box {
  width: 100%;
  max-width: 400px;
  background-color: white;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.logo {
  width: 150px;
}

.form-control {
  height: 50px;
}

.btn-primary {
  width: 100%;
  font-size: 1.1rem;
  padding: 12px;
}

.forgot-password,
.try-free {
  font-size: 0.875rem;
}

.container-right {
  background: url("https://picsum.photos/id/765/900?blur=2") no-repeat center center;
  background-size: cover;
  height: 100%;
}

.container-right .promo-text {
  color: white;
  padding: 100px;
}

label {
  font-size: 12px;
  color: rgb(84, 105, 141);
  margin: 0px 0px 8px;
  line-height: inherit;
}

.btn {
  font-size: 12px;
}

.btn-primary {
  background-color: rgb(0, 112, 210);
}

a {
  text-decoration: none;
  color: #0070d2;
}
</style>
