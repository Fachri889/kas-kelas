
/**
 * Kas Kelas - Tailwind CSS Theme Configuration (js/tailwind-config.js)
 */
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "secondary-fixed-dim": "#4ae176",
        "tertiary-fixed-dim": "#eec200",
        "on-secondary-fixed": "#002109",
        "on-primary-fixed-variant": "#003ea8",
        outline: "#737686",
        "on-background": "#0b1c30",
        "primary-container": "#2563eb",
        "outline-variant": "#c3c6d7",
        "on-primary-fixed": "#00174b",
        "on-secondary": "#ffffff",
        "on-surface-variant": "#434655",
        "inverse-primary": "#b4c5ff",
        "on-error-container": "#93000a",
        primary: "#004ac6",
        "on-tertiary-container": "#4e3d00",
        "inverse-surface": "#213145",
        "tertiary-container": "#cea700",
        "on-surface": "#0b1c30",
        "surface-dim": "#cbdbf5",
        "secondary-container": "#6bff8f",
        "surface-container-high": "#dce9ff",
        "surface-container-highest": "#d3e4fe",
        "tertiary-fixed": "#ffe083",
        "primary-fixed-dim": "#b4c5ff",
        "error-container": "#ffdad6",
        "surface-bright": "#f8f9ff",
        "on-tertiary-fixed": "#231b00",
        "surface-variant": "#d3e4fe",
        "primary-fixed": "#dbe1ff",
        "on-secondary-fixed-variant": "#005321",
        "on-tertiary": "#ffffff",
        background: "#f8f9ff",
        "surface-container-lowest": "#ffffff",
        "surface-container-low": "#eff4ff",
        "inverse-on-surface": "#eaf1ff",
        "surface-tint": "#0053db",
        secondary: "#006e2f",
        "on-tertiary-fixed-variant": "#574500",
        surface: "#f8f9ff",
        "on-secondary-container": "#007432",
        "on-primary-container": "#eeefff",
        error: "#ba1a1a",
        "on-primary": "#ffffff",
        tertiary: "#735c00",
        "surface-container": "#e5eeff",
        "on-error": "#ffffff",
        "secondary-fixed": "#6bff8f",
        brand: {
          50: "#EFF6FF",
          100: "#DBEAFE",
          200: "#BFDBFE",
          500: "#3B82F6",
          600: "#2563EB",
          700: "#1D4ED8",
          800: "#1E40AF",
          900: "#1E3A8A"
        }
      },
      borderRadius: {
        DEFAULT: "0.25rem",
        lg: "0.5rem",
        xl: "0.75rem",
        full: "9999px"
      },
      spacing: {
        margin: "2rem",
        gutter: "1.5rem",
        "space-xl": "2rem",
        "space-xs": "0.25rem",
        "space-sm": "0.5rem",
        "space-md": "1rem",
        "margin-mobile": "1rem",
        "gutter-mobile": "1rem",
        "space-lg": "1.5rem"
      },
      fontFamily: {
        sans: ["Plus Jakarta Sans", "sans-serif"],
        mono: ["JetBrains Mono", "monospace"],
        "headline-lg": ["Plus Jakarta Sans"],
        "label-md": ["Plus Jakarta Sans"],
        "body-sm": ["Plus Jakarta Sans"],
        "label-lg": ["Plus Jakarta Sans"],
        "display-lg": ["Plus Jakarta Sans"],
        "headline-sm": ["Plus Jakarta Sans"],
        "display-lg-mobile": ["Plus Jakarta Sans"],
        "currency-stat": ["Plus Jakarta Sans"],
        "headline-md": ["Plus Jakarta Sans"],
        "body-lg": ["Plus Jakarta Sans"],
        "body-md": ["Plus Jakarta Sans"],
        "label-sm": ["Plus Jakarta Sans"]
      },
      fontSize: {
        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }],
        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.01em", fontWeight: "600" }],
        "body-sm": ["12px", { lineHeight: "18px", fontWeight: "400" }],
        "label-lg": ["14px", { lineHeight: "20px", fontWeight: "600" }],
        "display-lg": ["36px", { lineHeight: "44px", letterSpacing: "-0.02em", fontWeight: "700" }],
        "headline-sm": ["16px", { lineHeight: "24px", fontWeight: "600" }],
        "display-lg-mobile": ["28px", { lineHeight: "36px", letterSpacing: "-0.01em", fontWeight: "700" }],
        "currency-stat": ["30px", { lineHeight: "38px", letterSpacing: "-0.02em", fontWeight: "700" }],
        "headline-md": ["20px", { lineHeight: "28px", fontWeight: "600" }],
        "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
        "body-md": ["14px", { lineHeight: "20px", fontWeight: "400" }],
        "label-sm": ["11px", { lineHeight: "14px", letterSpacing: "0.04em", fontWeight: "700" }]
      }
    }
  }
};
