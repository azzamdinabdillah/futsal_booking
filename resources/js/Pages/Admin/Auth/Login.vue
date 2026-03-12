<script setup lang="ts">
import { useForm, Head } from "@inertiajs/vue3";
import TextInput from "@/Components/Admin/TextInput.vue";
import Button from "@/Components/Admin/Button.vue";
import Checkbox from "@/Components/Admin/Checkbox.vue";
import { Mail, Lock } from "lucide-vue-next";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post("/admin/login", {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Admin Login" />
    <div class="min-h-screen flex bg-light dark:bg-dark">
        <!-- Left Side - Image & Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-dark overflow-hidden">
            <img
                src="/assets/images/futsal-1.jpg"
                alt="Futsal Arena"
                class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay scale-105 hover:scale-110 transition-transform duration-[20s] ease-linear"
            />
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary/90 to-dark/90 mix-blend-multiply"
            ></div>

            <div
                class="relative z-10 w-full flex flex-col justify-between p-12 text-white"
            >
                <div class="flex items-center gap-3">
                    <img
                        src="/assets/images/logo.jpg"
                        alt="Logo"
                        class="h-12 w-12 rounded-xl shadow-xl ring-2 ring-white/20"
                    />
                    <span class="text-2xl font-bold tracking-wide"
                        >Premier Futsal</span
                    >
                </div>

                <div class="space-y-8 max-w-lg">
                    <h1
                        class="text-5xl font-extrabold leading-tight drop-shadow-lg"
                    >
                        Manage Your <br />
                        <span class="text-success">Futsal Arena</span> <br />
                        Efficiently.
                    </h1>
                    <p
                        class="text-lg text-gray-200 font-medium leading-relaxed drop-shadow-md border-l-4 border-success pl-4"
                    >
                        The complete solution for booking management,
                        scheduling, and customer relations.
                    </p>
                </div>

                <div
                    class="flex items-center gap-4 text-sm text-gray-400 font-medium"
                >
                    <span
                        >&copy; {{ new Date().getFullYear() }} Premier Futsal
                        Arena</span
                    >
                    <span class="h-1 w-1 bg-gray-500 rounded-full"></span>
                    <span>Admin Portal</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-16 bg-white dark:bg-dark"
        >
            <div class="w-full max-w-md space-y-10">
                <div class="text-center lg:text-left space-y-2">
                    <div class="lg:hidden flex justify-center mb-8">
                        <img
                            src="/assets/images/logo.jpg"
                            alt="Logo"
                            class="h-16 w-16 rounded-2xl shadow-lg"
                        />
                    </div>
                    <h2
                        class="text-3xl font-bold tracking-tight text-dark dark:text-white"
                    >
                        Welcome back
                    </h2>
                    <p class="text-secondary dark:text-secondary/80 text-lg">
                        Please enter your details to sign in.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-5">
                        <TextInput
                            id="email"
                            type="email"
                            label="Email Address"
                            v-model="form.email"
                            :error="form.errors.email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="admin@premierfutsal.com"
                        >
                            <template #prefix>
                                <Mail class="size-4.5" />
                            </template>
                        </TextInput>

                        <TextInput
                            id="password"
                            type="password"
                            label="Password"
                            v-model="form.password"
                            :error="form.errors.password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                            <template #prefix>
                                <Lock class="size-4.5" />
                            </template>
                        </TextInput>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <Checkbox
                            id="remember"
                            label="Keep me logged in"
                            v-model="form.remember"
                        />
                    </div>

                    <Button
                        type="submit"
                        variant="primary"
                        block
                        size="lg"
                        :loading="form.processing"
                    >
                        Sign in to Dashboard
                    </Button>
                </form>
            </div>
        </div>
    </div>
</template>
