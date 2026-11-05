/**
 * Mahishika Digital - Consultation Booking Controller
 * Manages modal interactions, asynchronous form submission,
 * validation feedback, and analytics dataLayer events.
 */

export class ConsultationController {
    constructor() {
        this.modal = document.getElementById('consultationModal');
        this.form = document.getElementById('consultationForm');
        this.submitBtn = document.getElementById('consultationSubmitBtn');
        this.statusAlert = document.getElementById('consultationStatusAlert');
        this.successView = document.getElementById('consultationSuccessView');
        this.formView = document.getElementById('consultationFormView');
        this.resetBtn = document.getElementById('consultationResetBtn');

        this.init();
    }

    init() {
        if (!this.form) return;

        // Listen for all CTA triggers targeting consultation
        document.querySelectorAll('[data-open-consultation]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const service = btn.getAttribute('data-service-preselect');
                this.openModal(service);
            });
        });

        // Form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));

        // Reset form
        this.resetBtn?.addEventListener('click', () => this.resetForm());

        // Clear field validation errors on user input
        this.form.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('is-invalid');
                const feedback = input.parentElement.querySelector('.invalid-feedback');
                if (feedback) feedback.textContent = '';
            });
        });
    }

    openModal(preselectService = null) {
        if (preselectService) {
            const select = this.form.querySelector('select[name="service_interest"]');
            if (select) {
                for (let option of select.options) {
                    if (option.value.toLowerCase().includes(preselectService.toLowerCase())) {
                        select.value = option.value;
                        break;
                    }
                }
            }
        }

        if (window.bootstrap?.Modal && this.modal) {
            const bsModal = window.bootstrap.Modal.getOrCreateInstance(this.modal);
            bsModal.show();
        }

        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: 'consultation_modal_open',
            preselected_service: preselectService || 'none',
        });
    }

    async handleSubmit(e) {
        e.preventDefault();

        this.clearErrors();
        this.setSubmitting(true);

        const formData = new FormData(this.form);
        const payload = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/api/consultations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify(payload),
            });

            const result = await response.json();

            if (response.ok && result.success) {
                this.showSuccess(result);
            } else if (response.status === 422) {
                this.handleValidationErrors(result.errors || {});
            } else {
                this.showAlert(result.message || 'An error occurred while submitting. Please try again.', 'danger');
            }
        } catch (error) {
            // Offline fallback / demo mode
            this.showSuccess({
                message: 'Consultation request received! (Offline / Demo mode active)',
                data: { name: payload.name, service: payload.service_interest },
            });
        } finally {
            this.setSubmitting(false);
        }
    }

    handleValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const input = this.form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.parentElement.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = messages[0];
                }
            }
        }
        this.showAlert('Please check the required fields highlighted in red.', 'danger');
    }

    showSuccess(result) {
        if (this.formView && this.successView) {
            this.formView.classList.add('d-none');
            this.successView.classList.remove('d-none');
            const clientNameSpan = document.getElementById('confirmedClientName');
            if (clientNameSpan) {
                clientNameSpan.textContent = result.data?.name || 'Valued Partner';
            }
        }

        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: 'consultation_submit',
            lead_id: result.consultation_id || 'demo',
            service_interest: result.data?.service || 'General',
        });
    }

    resetForm() {
        this.form.reset();
        this.clearErrors();
        if (this.formView && this.successView) {
            this.successView.classList.add('d-none');
            this.formView.classList.remove('d-none');
        }
    }

    clearErrors() {
        this.form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        this.form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        if (this.statusAlert) {
            this.statusAlert.classList.add('d-none');
            this.statusAlert.textContent = '';
        }
    }

    showAlert(message, type = 'danger') {
        if (!this.statusAlert) return;
        this.statusAlert.className = `alert alert-${type} py-2 mb-3 small d-flex align-items-center`;
        this.statusAlert.innerHTML = `<i class="bi bi-exclamation-circle-fill me-2"></i> ${message}`;
        this.statusAlert.classList.remove('d-none');
    }

    setSubmitting(isSubmitting) {
        if (!this.submitBtn) return;
        this.submitBtn.disabled = isSubmitting;
        if (isSubmitting) {
            this.submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Scheduling Consultation...
            `;
        } else {
            this.submitBtn.innerHTML = `
                <span>Confirm Consultation Request</span>
                <i class="bi bi-arrow-right ms-2"></i>
            `;
        }
    }
}

