// tailwind.config.js
module.exports = {
    theme: {
        // ...
    },
    plugins: [
        require('@tailwindcss/typography'),
        function ({ addUtilities }) {
            addUtilities({
                '.inline-table': {
                    display: 'inline-table',
                },
            })
        }
    ],


}
