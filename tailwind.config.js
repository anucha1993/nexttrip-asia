/**** Tailwind v4 config (using new @tailwindcss/vite) adding Flowbite content paths ****/
export default {
  darkMode: 'class',
 content: [
    // ครอบคลุมทุก view เดิม + หน้าใหม่ (แนะนำให้คงบรรทัดนี้ไว้)
    './resources/views/**/*.blade.php',

    // ถ้าคุณเก็บ JS ของหน้าใหม่ไว้ใต้ resources/newhome/js จริง ๆ ให้เพิ่มบรรทัดนี้
    './resources/newhome/js/**/*.js',

    // (ยังต้องการ) เวลา Blade ถูกคอมไพล์มาไว้ชั่วคราว
    './storage/framework/views/*.php',

    // (ตัวเลือก) view ของ pagination ของ Laravel
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['ui-sans-serif','system-ui','sans-serif']
      },
      colors: {
        // Primary brand (inspired by NextTrip Holiday warm orange)
        brand: {
          50: '#fff7ed',
          100: '#ffedd5',
          200: '#fed7aa',
          300: '#fdba74',
          400: '#fb923c',
          500: '#f97316',
          600: '#ea580c',
          700: '#c2410c',
          800: '#9a3412',
          900: '#7c2d12'
        },
        // Accent cool blue for contrast elements
        accent: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a'
        }
      }
    }
  },
  plugins: []
};
