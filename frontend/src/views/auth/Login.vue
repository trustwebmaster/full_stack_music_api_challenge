<template>
  <div
    class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
    <form class="space-y-6" @submit="login">
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-300">
        Search Artist Music <br>
        Welcome
      </h2>
      <h5 class="text-xl font-medium text-gray-900 dark:text-white">Sign in to our platform</h5>
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
      <input type="hidden" name="remember" value="true"/>
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
        <input v-model="user.email" type="email" name="email" id="email"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
               required autofocus>
      </div>
      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
        <input v-model="user.password" type="password" name="password" id="password"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
               required>
      </div>
      <div class="flex items-start">
        <div class="flex items-start">
          <div class="flex items-center h-5">
            <input v-model="user.remember" id="remember" type="checkbox" value=""
                   class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800">
          </div>
          <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
        </div>
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
        Login to your account
      </button>
      <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
        Not registered?
        <router-link :to="{ name: 'Register' }" class="text-blue-700 hover:underline dark:text-blue-500">
          Register for free
        </router-link>
      </div>
      <p class="mt-2 text-center text-sm text-gray-300">
        Or
      </p>
      <button
        @click="google"
        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 focus:ring-offset-2 focus:ring-indigo-500">
        <svg class="w-4 h-4 mr-2 -ml-1"
             aria-hidden="true"
             focusable="false"
             data-prefix="fab"
             data-icon="google"
             role="img"
             xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 488 512">
          <path fill="currentColor"
                d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path>
        </svg>
        Sign in with Google
      </button>
    </form>
  </div>
</template>

<script>
import AuthLayout from "../../components/AuthLayout.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid";
import {useRouter} from "vue-router";
import store from "../../store/index.js";
import {ref} from "vue";
import Alert from "../../components/Alert.vue";

export default {
  components: {
    LockClosedIcon,
    AuthLayout,
    Alert
  },

  setup() {
    const router = useRouter();
    let loading = ref(false);
    const user = {
      email: '',
      password: '',
      remember: false
    }
    let errorMsg = ref('');

    function login(ev) {
      ev.preventDefault();
      loading.value = true;
      store
        .dispatch("login", user)
        .then(() => {
          loading.value = false;
          router.push({
            name: "Artists",
          });
        })
        .catch((err) => {
          loading.value = false;
          throw err
        });
    }

    function google(ev) {
      ev.preventDefault();
      store
        .dispatch("google")
        .then(() => {
          loading.value = false;
          router.push({
            name: "Google",
          });
        })
        .catch((err) => {
          loading.value = false;
          throw err
        });
    }

    return {
      user,
      google,
      login,
      errorMsg,
      loading,
    };
  },
}
</script>
