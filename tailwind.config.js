/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/Views/**/*.php"],
  theme: {
    extend: {
      colors : {
        'primay1' : '#FFFFFF',
        'primay2' : '#000000',
        'pallet1' : '#186F65',
        'pallet2' : '#B5CB99',
        'pallet3' : '#FCE09B',
        'pallet4' : '#B2533E',

        // button
        'add' : '#687EFF',
        'addHover' : '#80B3FF',
        'edit' : '#E9B824',
        'editHover' : '#EE9322',
        'delete' : '#A73121',
        'deleteHover' : '#952323',
        'view' : '#748E63',
        'viewHover' : '#555843',
      }
    },
  },
  plugins: [],
}

