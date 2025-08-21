// File: public/js/register.js
// Purpose: Validasi dan interaksi untuk halaman register (SRP)

(function() {
	'use strict';

	const form = document.getElementById('registerForm');
	if (!form) return;

	const fields = {
		first_name: form.querySelector('#first_name'),
		last_name: form.querySelector('#last_name'),
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

		if (!fields.first_name.value.trim()) {
			setError('first_name', 'Wajib diisi');
			valid = false;
		} else setError('first_name');

		if (!fields.last_name.value.trim()) {
			setError('last_name', 'Wajib diisi');
			valid = false;
		} else setError('last_name');

		if (!fields.email.value.trim() || !validateEmail(fields.email.value)) {
			setError('email', 'Email tidak valid');
			valid = false;
		} else setError('email');

		const phone = document.getElementById('phone');
  const phonePattern = /^(\+62|62|0)8[1-9][0-9]{6,11}$/; // pola nomor HP/WA Indonesia
  if (!phonePattern.test(phone.value)) {
    showError(phone, "Nomor HP/WhatsApp tidak valid");
    valid = false;
  } else clearError(phone);

		if (!fields.password.value || fields.password.value.length < 6) {
			setError('password', 'Minimal 6 karakter');
			valid = false;
		} else setError('password');

		return valid;
	}

	form.addEventListener('submit', function(e) {
		e.preventDefault();
		if (!validate()) return;
		// Ready for backend integration
		console.log('Register payload', {
			first_name: fields.first_name.value,
			last_name: fields.last_name.value,
			email: fields.email.value,
			password: fields.password.value
		});
	});
})();


