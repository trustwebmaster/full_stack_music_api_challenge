<template>
  <div
    class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
    <form class="space-y-6" @submit="register">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-300">
        Search Artist Music <br>
        Register
      </h2>
      <h5 class="text-xl font-medium text-gray-900 dark:text-white">Sign up to use our platform</h5>
      <Alert v-if="errorMsg">
        {{ errorMsg }}
        <span
          @click="errorMsg = ''"
          class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
        >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </span>
      </Alert>
      <div>
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
        <input v-model="user.name" type="text" name="name" id="name"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
               required autofocus>
      </div>
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
        <input v-model="user.email" type="email" name="email" id="email"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
               required>
      </div>
      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
        <input v-model="user.password" type="password" name="password" id="password" placeholder="8+ characters"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
               required>
      </div>
      <div>
        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Confirmation</label>
        <input v-model="user.password_confirmation" type="password" name="password_confirmation" id="password_confirmation"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
               required>
      </div>

      <button
        type="submit"
        :disabled="loading"
        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300"
        :class="{
          'cursor-not-allowed': loading,
          'hover:bg-indigo-500': loading,
        }"
      >
        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
          <LockClosedIcon
            class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
            aria-hidden="true"
          />
        </span>
        <svg
          v-if="loading"
          class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          ></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
          ></path>
        </svg>
        Register
      </button>
      <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
        Already have an account?
        <router-link :to="{ name: 'Login' }" class="text-blue-700 hover:underline dark:text-blue-500">
          Login to your account
        </router-link>
      </div>
    </form>
  </div>
</template>

<script>
import AuthLayout  from "../../components/AuthLayout.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid";
import store from "../../store/index.js";
import {useRouter} from "vue-router";
import Alert from "../../components/Alert.vue";
import { ref } from "vue";

export default {
  components: {
    LockClosedIcon,
    AuthLayout,
    Alert
  },

  setup() {
    const router = useRouter();
    const loading = ref(false);
    const errors = ref("");
    const user = {
      name: '',
      email: '',
      password: '',
    }
    function register(ev) {
      ev.preventDefault();
      loading.value = true;
      store
        .dispatch("register", user)
        .then(() => {
            console.log(user)

          loading.value = false;
          router.push({
            name: "Artists",
          });
        })
        .catch((error) => {
          loading.value = false;
          if (error.response.status === 422) {
            errors.value = error.response.data.errors;
          }
        });
    }

    return {
      user,
      register,
      router,
      errors,
      loading
    };
  },
}
</script>
