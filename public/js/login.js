// File: public/js/login.js
// Purpose: Validasi dan interaksi untuk halaman login (SRP)

(function() {
	'use strict';

	// Dependency Inversion ready: form validator depends on abstractions (DOM APIs)
	const form = document.getElementById('loginForm');
	if (!form) return;

	const fields = {
		email: form.querySelector('#email'),
		password: form.querySelector('#password')
	};

	function setError(fieldName, message) {
		const err = form.querySelector(`[data-error-for="${fieldName}"]`);
		if (err) err.textContent = message || '';
	}

	function validateEmail(value) {
		return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(value).toLowerCase());
	}

	function validate() {
		let valid = true;

		if (!fields.email.value.trim() || !validateEmail(fields.email.value)) {
			setError('email', 'Email tidak valid');
			valid = false;
		} else setError('email');

		if (!fields.password.value || fields.password.value.length < 6) {
			setError('password', 'Minimal 6 karakter');
			valid = false;
		} else setError('password');

		return valid;
	}

	form.addEventListener('submit', function(e) {
		e.preventDefault();
		if (!validate()) return;
		// Ready to integrate with Laravel: submit via fetch or form action
		console.log('Login payload', {
			email: fields.email.value,
			password: fields.password.value
		});
	});
})();


