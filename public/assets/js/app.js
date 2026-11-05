/**
 * Mahishika Digital - Application Entry Point
 */

import { MegaMenu } from './mega-menu.js';
import { ConsultationController } from './consultation.js';

document.addEventListener('DOMContentLoaded', () => {
    // Initialize custom mega menu
    const menu = new MegaMenu();

    // Initialize consultation modal & form handler
    const consultation = new ConsultationController();

    // Expose on window for debugging / inspection
    window.MahishikaApp = {
        menu,
        consultation,
    };
});
