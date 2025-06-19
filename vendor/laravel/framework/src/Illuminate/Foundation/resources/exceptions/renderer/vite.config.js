// /** @type {import('vite').UserConfig} */
// export default {
//     plugins: [],
//     build: {
//         assetsDir: '',
//         rollupOptions: {
//             input: ['scripts.js', 'styles.css', 'dark-mode.css', 'light-mode.css'],
//             output: {
//                 assetFileNames: '[name][extname]',
//                 entryFileNames: '[name].js',
//             },
//         },
//     },
// };
/** @type {import('vite').UserConfig} */
export default {
    plugins: [],
    server: {
        host: '0.0.0.0', // Allow access from LAN (your phone)
        port: 5173, // Or change if this port conflicts
        strictPort: true,
        hmr: {
            host: '192.168.0.221', // Replace with your laptop's local IP
        },
    },
    build: {
        assetsDir: '',
        rollupOptions: {
            input: ['scripts.js', 'styles.css', 'dark-mode.css', 'light-mode.css'],
            output: {
                assetFileNames: '[name][extname]',
                entryFileNames: '[name].js',
            },
        },
    },
};
