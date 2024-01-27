/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/Views/**/*.php"],
  theme: {
    extend: {
      colors : {
        'light': '#FFFBF5',
        'dark': '#FDEFF4',
        'primary': '#222831',
        'secondary': '#F4BF96',
        'success': '#46af46',
        'warning': '#fba200',
        'danger': '#df5338',
        'info': '#599afe',
      },
      fontFamily : {
        'Roboto' : ['sans-serif', 'Roboto'],
      }
    },
  },
  plugins: [],
}

