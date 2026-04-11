import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

Alpine.data('heroRotator', (slides = []) => ({
    slides,
    slideIndex: 0,
    charIndex: 0,
    typedText: '',
    deleting: false,
    started: false,
    start() {
        if (this.started || !this.slides.length) {
            return;
        }

        this.started = true;
        this.tick();
    },
    get currentSlide() {
        return this.slides[this.slideIndex] ?? null;
    },
    tick() {
        const slide = this.currentSlide;

        if (!slide) {
            return;
        }

        const fullText = slide.headline;

        if (!this.deleting) {
            this.charIndex += 1;
            this.typedText = fullText.slice(0, this.charIndex);

            if (this.charIndex >= fullText.length) {
                window.setTimeout(() => {
                    this.deleting = true;
                    this.tick();
                }, 1800);

                return;
            }

            window.setTimeout(() => this.tick(), 48);

            return;
        }

        this.charIndex -= 1;
        this.typedText = fullText.slice(0, this.charIndex);

        if (this.charIndex <= 0) {
            this.deleting = false;
            this.slideIndex = (this.slideIndex + 1) % this.slides.length;
            window.setTimeout(() => this.tick(), 280);

            return;
        }

        window.setTimeout(() => this.tick(), 26);
    },
}));

Alpine.data('testimonialSlider', (slides = []) => ({
    slides,
    slideIndex: 0,
    intervalId: null,
    start() {
        if (this.intervalId || this.slides.length < 2) {
            return;
        }

        this.intervalId = window.setInterval(() => {
            this.next();
        }, 5000);
    },
    stop() {
        if (!this.intervalId) {
            return;
        }

        window.clearInterval(this.intervalId);
        this.intervalId = null;
    },
    next() {
        if (!this.slides.length) {
            return;
        }

        this.slideIndex = (this.slideIndex + 1) % this.slides.length;
    },
    prev() {
        if (!this.slides.length) {
            return;
        }

        this.slideIndex = (this.slideIndex - 1 + this.slides.length) % this.slides.length;
    },
    goTo(index) {
        this.slideIndex = index;
    },
}));

Alpine.data('projectGallery', () => ({
    activeFilter: 'All',
    lightbox: null,
    projects: [],
    init() {
        const el = document.getElementById('projects-data');
        this.projects = el ? JSON.parse(el.textContent) : [];
    },
    openLightbox(index) {
        this.lightbox = this.projects[index] || null;
    },
    step(dir) {
        const list = this.activeFilter === 'All'
            ? this.projects
            : this.projects.filter(p => p.category === this.activeFilter);
        const idx = list.findIndex(p => p.image === this.lightbox.image);
        this.lightbox = list[(idx + dir + list.length) % list.length];
    },
    close() {
        this.lightbox = null;
    },
}));

Alpine.data('faqPage', () => ({
    search: '',
    activeCategory: 'All',
    openItem: null,
    faqs: [],
    init() {
        const el = document.getElementById('faqs-data');
        this.faqs = el ? JSON.parse(el.textContent) : [];
        this.$watch('activeCategory', () => { this.openItem = null; });
        this.$watch('search', () => { this.openItem = null; });
    },
    get categories() {
        const seen = new Set();
        const result = ['All'];
        this.faqs.forEach(f => {
            if (!seen.has(f.category)) {
                seen.add(f.category);
                result.push(f.category);
            }
        });
        return result;
    },
    countFor(cat) {
        if (cat === 'All') return this.faqs.length;
        return this.faqs.filter(f => f.category === cat).length;
    },
    get filtered() {
        return this.faqs.filter(f => {
            const matchCat = this.activeCategory === 'All' || f.category === this.activeCategory;
            const q = this.search.trim().toLowerCase();
            const matchSearch = !q || f.question.toLowerCase().includes(q) || f.answer.toLowerCase().includes(q);
            return matchCat && matchSearch;
        });
    },
    toggle(i) {
        this.openItem = this.openItem === i ? null : i;
    },
}));

// ===== Scroll-reveal via IntersectionObserver =====
(function () {
    const targets = document.querySelectorAll('[data-reveal]');
    if (!targets.length || !('IntersectionObserver' in window)) {
        targets.forEach(el => el.classList.add('revealed'));
        return;
    }
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.08 }
    );
    targets.forEach(el => observer.observe(el));
})();

window.Alpine = Alpine;

Alpine.start();
