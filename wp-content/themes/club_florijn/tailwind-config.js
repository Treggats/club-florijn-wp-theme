// Tailwind CDN config (extracted)
// Disables Tailwind's Preflight (base) styles and extends lineClamp
window.tailwind = window.tailwind || {};
tailwind.config = {
  corePlugins: {
    preflight: false,
  },
  theme: {
    extend: {
      lineClamp: {
        3: "3",
      }
    }
  }
};
