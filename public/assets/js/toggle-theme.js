class ThemeManager {
    constructor() {
        this.toggleSwitch = document.getElementById("themeToggle");
        this.themeLabel = document.getElementById("themeLabel");
        this.html = document.documentElement;
        this.currentTheme = this.getSavedTheme();
        
        // Theme icons
        this.icons = {
            light: "🌙",
            dark: "☀️",
            auto: "🔄",
            gradient: "🎨",
            purple: "💜"
        };

        this.init();
    }

    getSavedTheme() {
        const savedTheme = localStorage.getItem("theme");
        if (savedTheme && ["light","dark","auto","gradient","purple"].includes(savedTheme)) {
            return savedTheme;
        }
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return "dark";
        }
        return "light";
    }

    getEffectiveTheme() {
        if (this.currentTheme === "auto") {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? "dark" : "light";
        }
        return this.currentTheme;
    }

    applyTheme(theme = this.currentTheme) {
        const effectiveTheme = theme === "auto" ? this.getEffectiveTheme() : theme;

        document.body.classList.add('theme-transition');

        // Reset previous theme
        this.html.setAttribute("data-bs-theme", effectiveTheme);
        document.body.classList.remove("theme-gradient", "theme-purple");

        // Apply custom themes
        if (effectiveTheme === "gradient") document.body.classList.add("theme-gradient");
        if (effectiveTheme === "purple") document.body.classList.add("theme-purple");

        this.updateToggleUI();
        this.updateThemeLabel();

        setTimeout(() => document.body.classList.remove('theme-transition'), 300);

        this.dispatchThemeChangeEvent(effectiveTheme);
        this.updateMetaThemeColor(effectiveTheme);
    }

    updateToggleUI() {
        if (this.toggleSwitch) {
            const effectiveTheme = this.getEffectiveTheme();
            this.toggleSwitch.checked = ["dark","gradient","purple"].includes(effectiveTheme);
        }
    }

    updateThemeLabel() {
        if (this.themeLabel) {
            const effectiveTheme = this.getEffectiveTheme();
            this.themeLabel.textContent = this.icons[effectiveTheme] || this.icons.light;
            this.themeLabel.setAttribute('title', `Current theme: ${effectiveTheme}`);
        }
    }

    saveTheme(theme) {
        try { localStorage.setItem("theme", theme); } 
        catch (e) { console.warn("Could not save theme preference:", e); }
    }

    toggleTheme() {
        const order = ["light","dark","gradient","purple","auto"];
        let idx = order.indexOf(this.currentTheme);
        let newTheme = order[(idx+1) % order.length];
        this.setTheme(newTheme);
    }

    setTheme(theme) {
        if (!["light","dark","auto","gradient","purple"].includes(theme)) theme="light";
        this.currentTheme = theme;
        this.saveTheme(theme);
        this.applyTheme(theme);
    }

    dispatchThemeChangeEvent(effectiveTheme) {
        const event = new CustomEvent('themeChange', {
            detail: { theme: this.currentTheme, effectiveTheme, timestamp: Date.now() }
        });
        document.dispatchEvent(event);
    }

    updateMetaThemeColor(theme) {
        let color = "#ffffff";
        if (theme==="dark") color="#1e1e2d";
        if (theme==="gradient") color="#667eea";
        if (theme==="purple") color="#6f42c1";

        let meta = document.querySelector("meta[name=theme-color]");
        if(!meta){
            meta = document.createElement("meta");
            meta.name="theme-color";
            document.head.appendChild(meta);
        }
        meta.setAttribute("content", color);
    }

    setupSystemThemeListener() {
        if(window.matchMedia){
            const mq = window.matchMedia('(prefers-color-scheme: dark)');
            const listener = ()=>{ if(this.currentTheme==="auto") this.applyTheme("auto"); };
            if(mq.addEventListener) mq.addEventListener('change', listener);
            else if(mq.addListener) mq.addListener(listener);
        }
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', e=>{
            if((e.ctrlKey||e.metaKey) && e.shiftKey && e.code==='KeyT'){
                e.preventDefault();
                this.toggleTheme();
            }
        });
    }

    init() {
        this.applyTheme(this.currentTheme);
        if(this.toggleSwitch) this.toggleSwitch.addEventListener("change", ()=>this.toggleTheme());
        this.setupSystemThemeListener();
        this.setupKeyboardShortcuts();
        this.addTransitionStyles();
    }

    addTransitionStyles() {
        if(!document.getElementById('theme-transitions')){
            const style = document.createElement('style');
            style.id='theme-transitions';
            style.textContent=`
                .theme-transition * {
                    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease !important;
                }
            `;
            document.head.appendChild(style);
        }
    }
}

// Initialize
document.addEventListener("DOMContentLoaded", ()=>{
    window.themeManager = new ThemeManager();
    window.toggleTheme = ()=>window.themeManager.toggleTheme();
    window.setTheme = (theme)=>window.themeManager.setTheme(theme);
});
