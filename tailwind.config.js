import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./src/**/*.{html,js}",
        "./node_modules/tw-elements/dist/js/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            animation: {
                "progress": "progress 1s ease-in-out infinite",
            },
            keyframes: {
                progress: {
                    "0%": { width: "0%", marginLeft: "0%" },
                    "20%": { marginLeft: "0%" },
                    "100%": { width: "50%", marginLeft: "100%" },
                },
            },
        },
    },

    plugins: [forms, require("tw-elements/dist/plugin.cjs")],
    darkMode: "class",
};
