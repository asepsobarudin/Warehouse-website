/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/Views/**/*.php"],
  theme: {
    extend: {
      colors : {
        'light': '#EEEEEE',
        'netral': '#FFFFFF',
        'primary': '#222831',
        'secondary': '#F4BF96',
        'tersier': '#393E46',
        'success': '#46af46',
        'warning': '#fba200',
        'danger': '#df5338',
        'info': '#599afe',
      },
    },
  },
  plugins: [],
}

