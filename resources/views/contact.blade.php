@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 py-5 contact-page">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="row g-0">
                    <!-- Image de fond -->
                    <div class="col-md-5 d-none d-md-block">
                        <div class="contact-image h-100" style="background-image: url('{{ asset('assets/v10.jpg') }}');">
                            <div class="contact-overlay">
                                <h2 class="text-white mb-4">Besoin d'aide ?</h2>
                                <p class="text-white-50">Notre équipe est là pour vous répondre dans les plus brefs délais.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Formulaire de contact -->
                    <div class="col-md-7">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="text-center mb-4 text-primary">Contactez-nous</h2>
                            <p class="text-muted text-center mb-4">Remplissez le formulaire ci-dessous et nous vous répondrons dès que possible.</p>
                            
                            <!-- Messages d'erreur généraux -->
                            <div id="form-errors" class="alert alert-danger d-none">
                                <ul class="mb-0"></ul>
                            </div>
                            
                            <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    <div class="invalid-feedback">
                                        @error('name') {{ $message }} @else Veuillez entrer votre nom @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Adresse email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    <div class="invalid-feedback">
                                        @error('email') {{ $message }} @else Veuillez entrer une adresse email valide @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label">Votre message <span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-lg @error('message') is-invalid @enderror" 
                                              id="message" 
                                              name="message" 
                                              rows="5" 
                                              required>{{ old('message') }}</textarea>
                                    <div class="invalid-feedback">
                                        @error('message') {{ $message }} @else Veuillez entrer votre message (10 caractères minimum) @enderror
                                    </div>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                        <span class="submit-text">Envoyer le message</span>
                                    </button>
                                </div>
                            </form>
                            
                            <hr class="my-4">
                            
                            <div class="text-center">
                                <p class="mb-2">Ou contactez-nous directement :</p>
                                <div class="d-flex justify-content-center gap-4">
                                    <a href="tel:+21612345678" class="text-decoration-none text-muted">
                                        <i class="fas fa-phone-alt me-2"></i> +216 12 345 678
                                    </a>
                                    <a href="mailto:contact@retnacar.tn" class="text-decoration-none text-muted">
                                        <i class="fas fa-envelope me-2"></i> contact@retnacar.tn
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast de notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="notificationToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="toast-title">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-message">
            <!-- Le message de notification sera inséré ici -->
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.contact-page {
    background-color: #f8f9fa;
}

.contact-image {
    background-size: cover;
    background-position: center;
    min-height: 100%;
    position: relative;
    border-radius: 0.5rem 0 0 0.5rem;
}

.contact-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
    color: white;
    padding: 2rem;
    border-radius: 0 0 0 0.5rem;
}

.card {
    border: none;
    border-radius: 0.5rem;
    overflow: hidden;
}

.form-control, .form-control:focus {
    border-color: #dee2e6;
    box-shadow: none;
}

.form-control:focus {
    border-color: #0d6efd;
}

.btn-primary {
    background-color: #0d6efd;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #0b5ed7;
}

.invalid-feedback {
    display: block;
}

/* Animation du toast */
@keyframes slideInUp {
    from {
        transform: translate3d(0, 100%, 0);
        visibility: visible;
        opacity: 0;
    }
    to {
        transform: translate3d(0, 0, 0);
        opacity: 1;
    }
}

.toast {
    animation: slideInUp 0.3s ease-in-out;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const submitText = contactForm.querySelector('.submit-text');
    const spinner = contactForm.querySelector('.spinner-border');
    const formErrors = document.getElementById('form-errors');
    const formErrorsList = formErrors.querySelector('ul');
    
    // Initialiser les toasts Bootstrap
    const toastEl = document.getElementById('notificationToast');
    const toastTitle = document.getElementById('toast-title');
    const toastMessage = document.getElementById('toast-message');
    const toast = new bootstrap.Toast(toastEl, {
        autohide: true,
        delay: 5000
    });
    
    // Fonction pour afficher une notification
    function showNotification(title, message, type = 'success') {
        // Mettre à jour le style en fonction du type
        const toastHeader = toastEl.querySelector('.toast-header');
        const toastBody = toastEl.querySelector('.toast-body');
        
        // Réinitialiser les classes
        toastHeader.className = 'toast-header';
        toastBody.className = 'toast-body';
        
        // Ajouter les classes en fonction du type
        if (type === 'success') {
            toastHeader.classList.add('bg-success', 'text-white');
        } else if (type === 'error') {
            toastHeader.classList.add('bg-danger', 'text-white');
        } else if (type === 'warning') {
            toastHeader.classList.add('bg-warning');
        } else if (type === 'info') {
            toastHeader.classList.add('bg-info', 'text-white');
        }
        
        // Mettre à jour le titre et le message
        toastTitle.textContent = title;
        toastMessage.textContent = message;
        
        // Afficher le toast
        toast.show();
    }
    
    // Gestion de la soumission du formulaire
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Désactiver le bouton et afficher le spinner
        submitBtn.disabled = true;
        submitText.textContent = 'Envoi en cours...';
        spinner.classList.remove('d-none');
        
        // Réinitialiser les erreurs
        formErrors.classList.add('d-none');
        formErrorsList.innerHTML = '';
        
        // Récupérer les données du formulaire
        const formData = new FormData(contactForm);
        
        try {
            // Envoyer la requête AJAX
            const response = await fetch(contactForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await response.json();
            
            // Vérifier si la requête a réussi
            if (response.ok) {
                // Afficher le message de succès
                showNotification('Succès', data.message || 'Votre message a été envoyé avec succès !', 'success');
                
                // Réinitialiser le formulaire
                contactForm.reset();
                
                // Réinitialiser les états de validation
                contactForm.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            } else {
                // Afficher les erreurs de validation
                if (response.status === 422 && data.errors) {
                    formErrors.classList.remove('d-none');
                    
                    // Afficher les erreurs de validation
                    Object.values(data.errors).forEach(messages => {
                        messages.forEach(message => {
                            const li = document.createElement('li');
                            li.textContent = message;
                            formErrorsList.appendChild(li);
                        });
                    });
                    
                    // Faire défiler jusqu'au haut du formulaire
                    formErrors.scrollIntoView({ behavior: 'smooth' });
                    
                    showNotification('Erreur', 'Veuillez corriger les erreurs dans le formulaire.', 'error');
                } else {
                    // Afficher une erreur générique
                    showNotification('Erreur', data.message || 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer plus tard.', 'error');
                }
            }
        } catch (error) {
            console.error('Erreur lors de l\'envoi du formulaire:', error);
            showNotification('Erreur', 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer plus tard.', 'error');
        } finally {
            // Réactiver le bouton et masquer le spinner
            submitBtn.disabled = false;
            submitText.textContent = 'Envoyer le message';
            spinner.classList.add('d-none');
        }
    });
    
    // Gestion de la validation en temps réel
    contactForm.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>
@endpush
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const btnText = contactForm.querySelector('.btn-text');
    const spinner = contactForm.querySelector('.spinner-border');
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notification-message');
    const toast = new bootstrap.Toast(notification.querySelector('.toast'));

    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Reset form validation
        contactForm.classList.remove('was-validated');
        
        if (!contactForm.checkValidity()) {
            contactForm.classList.add('was-validated');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
        btnText.textContent = 'Envoi en cours...';

        try {
            const formData = new FormData(contactForm);
            const response = await fetch('{{ route("contact.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                // Show success message
                showNotification(data.message || 'Votre message a été envoyé avec succès!', 'success');
                contactForm.reset();
            } else {
                // Show error message
                const errorMessage = data.message || 'Une erreur est survenue. Veuillez réessayer.';
                showNotification(errorMessage, 'danger');
                
                // Show validation errors if any
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = contactForm.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = input.nextElementSibling;
                            if (feedback && feedback.classList.contains('invalid-feedback')) {
                                feedback.textContent = data.errors[field][0];
                            }
                        }
                    });
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Une erreur est survenue. Veuillez réessayer plus tard.', 'danger');
        } finally {
            // Reset button state
            submitBtn.disabled = false;
            spinner.classList.add('d-none');
            btnText.textContent = 'Envoyer';
        }
    });

    function showNotification(message, type = 'success') {
        const toastEl = notification.querySelector('.toast');
        
        // Set message and style
        notificationMessage.textContent = message;
        
        // Set background color based on type
        if (type === 'success') {
            toastEl.classList.add('bg-success');
            toastEl.classList.remove('bg-danger');
        } else {
            toastEl.classList.add('bg-danger');
            toastEl.classList.remove('bg-success');
        }
        
        // Show notification
        notification.style.display = 'block';
        toast.show();
        
        // Hide after 5 seconds
        setTimeout(() => {
            toast.hide();
        }, 5000);
    }
    
    // Handle toast hidden event
    notification.querySelector('.toast').addEventListener('hidden.bs.toast', function () {
        notification.style.display = 'none';
    });
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush

<style>
/* Animation for notification */
.toast {
    transition: opacity 0.3s ease-in-out;
}

/* Form validation styles */
.was-validated .form-control:invalid,
.form-control.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.was-validated .form-control:valid,
.form-control.is-valid {
    border-color: #198754;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.was-validated .form-control:invalid ~ .invalid-feedback,
.was-validated .form-control:invalid ~ .invalid-tooltip,
.form-control.is-invalid ~ .invalid-feedback,
.form-control.is-invalid ~ .invalid-tooltip {
    display: block;
}
</style>

{{-- Footer removed from contact page --}}