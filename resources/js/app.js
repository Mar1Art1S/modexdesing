import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Alpine = Alpine;
window.AOS = AOS;
Alpine.start();

const initAOS = () => {
    AOS.init({
        duration: 550,
        easing: 'ease-out-cubic',
        once: true,
        offset: 40,
        delay: 0,
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAOS);
} else {
    initAOS();
}
