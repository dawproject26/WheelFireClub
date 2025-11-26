import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
=======
            input: [
                'resources/css/wheelfireclub.css',
                'resources/js/postit.js'
            ],
            refresh: true,
        }),
    ],
});
>>>>>>> 4aa33854db4a7f23c631ff9f4f608033481aa08b
