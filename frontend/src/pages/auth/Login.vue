
<template>
    <div class="flex min-h-full flex-1 flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" @submit="login">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input v-model="user.email" id="email" name="email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input v-model="user.password" id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input v-model="user.remember" id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                            <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-900">Remember me</label>
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="loading"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300"
                            :class="{'cursor-not-allowed': loading,  'hover:bg-indigo-500': loading, }"
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
                    </div>
                </form>

                <div>
                    <div class="relative mt-10">
                        <div class="relative flex justify-center text-sm font-medium leading-6">
                            <span class="bg-white px-6 text-gray-900">Or continue with</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-8">
                        <button @click="google"
                                class="flex w-full items-center justify-center gap-3 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:ring-transparent">
                            <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24">
                                <path d="M12.0003 4.75C13.7703 4.75 15.3553 5.36002 16.6053 6.54998L20.0303 3.125C17.9502 1.19 15.2353 0 12.0003 0C7.31028 0 3.25527 2.69 1.28027 6.60998L5.27028 9.70498C6.21525 6.86002 8.87028 4.75 12.0003 4.75Z" fill="#EA4335" />
                                <path d="M23.49 12.275C23.49 11.49 23.415 10.73 23.3 10H12V14.51H18.47C18.18 15.99 17.34 17.25 16.08 18.1L19.945 21.1C22.2 19.01 23.49 15.92 23.49 12.275Z" fill="#4285F4" />
                                <path d="M5.26498 14.2949C5.02498 13.5699 4.88501 12.7999 4.88501 11.9999C4.88501 11.1999 5.01998 10.4299 5.26498 9.7049L1.275 6.60986C0.46 8.22986 0 10.0599 0 11.9999C0 13.9399 0.46 15.7699 1.28 17.3899L5.26498 14.2949Z" fill="#FBBC05" />
                                <path d="M12.0004 24.0001C15.2404 24.0001 17.9654 22.935 19.9454 21.095L16.0804 18.095C15.0054 18.82 13.6204 19.245 12.0004 19.245C8.8704 19.245 6.21537 17.135 5.2654 14.29L1.27539 17.385C3.25539 21.31 7.3104 24.0001 12.0004 24.0001Z" fill="#34A853" />
                            </svg>
                            <span class="text-sm font-semibold leading-6">Sign in with Google</span>
                        </button>
                    </div>

                    <div class="mt-6 text-sm font-medium text-gray-500 dark:text-gray-300">
                        Not registered?
                        <router-link :to="{ name: 'Register' }" class="text-blue-700 hover:underline dark:text-blue-500 font-bold">
                           Register
                        </router-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AuthLayout from "../../components/layouts/auth/SignInLayout.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid";
import {useRouter} from "vue-router";
import store from "../../store/index.js";
import {ref} from "vue";
import Alert from "../../components/layouts/Flash.vue";

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
